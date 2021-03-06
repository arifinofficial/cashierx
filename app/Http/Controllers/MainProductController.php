<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MainProduct;
use App\Category;
use App\Variant;

class MainProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mainProducts = MainProduct::orderBy('created_at', 'DESC')->paginate(12);
        $categories = Category::get();

        return view('main_product.index', compact('mainProducts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id');
        $variants = Variant::pluck('name', 'id');

        return view('main_product.create', compact('categories', 'variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $this->validate($request, [
            'name' => 'required|string|min:2',
            'category_id' => 'required|integer',
        ]);

        $mainProduct = MainProduct::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'is_variant' => ($request->has('variant_id') ? 1 : 0)
        ]);

        if ($request->has('variant_id')) {
            $mainProduct->variants()->attach($request->variant_id);
        }

        return redirect()->route('product.main-product.product.create', [$mainProduct->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mainProducts = MainProduct::findOrFail($id)->products()->get();
        $categories = Category::pluck('name', 'id');

        return view('main_product.show', compact('mainProducts', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $MainProduct = MainProduct::findOrFail($id);

        $this->validate($request, [
            'category_id' => 'required'
        ]);

        $MainProduct->update([
            'category_id' => $request->category_id
        ]);

        return redirect()->back()->with(['success' => '<strong>Kategori Berhasil Perbaharui.</strong>']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = MainProduct::findOrFail($id);

        $model->delete();
    }

    public function getByCategory($id)
    {
        $mainProducts = Category::with('mainProducts')->findOrFail($id);
        $categories = Category::get();

        return view('main_product.product_category', compact('mainProducts', 'categories'));
    }
}
