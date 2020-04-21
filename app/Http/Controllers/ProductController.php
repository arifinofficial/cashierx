<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\MainProduct;
use App\Unit;
use App\ProductItem;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mainProductId = request('main_product');

        $mainProduct = MainProduct::findOrFail($mainProductId);

        $units = Unit::pluck('name', 'id');

        return view('product.create', compact('mainProduct', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->is_variant == 1) {
            foreach ($request->products as $product) {
                if (isset($product['picture'])) {
                    $savedImg = $product['picture']->store('products');
                }
                $saveProduct = Product::create([
                    'main_product_id' => $request->main_product_id,
                    'name' => $request->name,
                    'sku' => $request->sku.'-'.Str::slug($product['variant'], '-'),
                    'qty' => $product['qty'],
                    'variant' => $product['variant'],
                    'picture' => isset($product['picture']) ? $savedImg : null,
                    'price' => $product['price']
                ]);

                foreach ($product['items'] as $item) {
                    ProductItem::create([
                        'product_id' => $saveProduct->id,
                        'unit_id' => $item['unit'],
                        'name' => $item['name'],
                        'recipe' => $item['recipe']
                    ]);
                }
            }
        } else {
            if ($request->hasFile('picture')) {
                $savedImg = $request->file('picture')->store('products');
            }
            $product = Product::create([
                'main_product_id' => $request->main_product_id,
                'name' => $request->name,
                'sku' => $request->sku,
                'qty' => $request->qty,
                'price' => $request->price,
                'picture' => $request->hasFile('picture') ? $savedImg : null,
            ]);
    
            if ($request->has('items')) {
                foreach ($request->items as $key => $item) {
                    ProductItem::create([
                        'product_id' => $product->id,
                        'unit_id' => $item['unit'],
                        'name' => $item['name'],
                        'recipe' => $item['recipe']
                    ]);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $productId)
    {
        $product = Product::findOrFail($productId);

        $units = Unit::pluck('name', 'id');

        $productItems = $product->productItems()->get();

        return view('product.edit', compact('product', 'units', 'productItems'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $main_product, $product)
    {
        $this->validate($request, [
            'name' => 'required|string|min:2',
            'sku' => 'required|alpha_dash|unique:products,sku,'.$product,
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'qty' => 'required|integer|min:0',
            'picture' => 'nullable|mimes:jpeg,jpg,png|max:10240'
        ]);

        $product = Product::findOrFail($product);

        if ($request->hasFile('picture')) {
            if ($product->picture != null) {
                Storage::delete($product->picture);
            }

            $savedImg = $request->file('picture')->store('products');

            $product->update([
                'picture' => $savedImg
            ]);
        }

        DB::beginTransaction();

        $product->update($request->except('picture'));

        if ($request->has('items')) {
            $product->productItems()->delete();

            foreach ($request->items as $key => $item) {
                ProductItem::create([
                    'product_id' => $product->id,
                    'unit_id' => $item['unit'],
                    'name' => $item['name'],
                    'recipe' => $item['recipe']
                ]);
            }
        }

        DB::commit();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $productId)
    {
        $mainProduct = MainProduct::findOrFail($id);

        if ($mainProduct->is_variant === 0) {
            $getPicture = $mainProduct->products()->first()->picture;

            if ($getPicture != null) {
                Storage::delete($getPicture);
            }
            
            $mainProduct->delete();
        } else {
            $product = $mainProduct->products()->findOrFail($productId);
            $getPicture = $product->picture;

            if ($getPicture != null) {
                Storage::delete($getPicture);
            }

            if (count($mainProduct->products()->get()) == 1) {
                MainProduct::findOrFail($id)->delete();
            } else {
                $product->delete();
            }
        }
    }
}
