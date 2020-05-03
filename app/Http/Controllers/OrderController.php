<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Order;
use App\Category;
use App\MainProduct;
use DB;
use Cookie;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use App\Data\ThermalPrinter;

class OrderController extends Controller
{
    public function index()
    {
        // $products = Product::orderBy('created_at', 'DESC')->get();
        $categories = Category::get();

        return view('order.add', compact('categories'));
    }

    public function search()
    {
        $keyword = request()->q;

        $products = Product::where('name', 'LIKE', '%'.$keyword.'%')->with(['mainProduct' => function ($query) {
            return $query->with(['category']);
        }])->get();

        return response()->json($products, 200);
    }

    public function getProductByCategory($id)
    {
        $products = Product::whereHas('mainProduct', function ($q) use ($id) {
            $q->where('category_id', $id) ;
        })->with(['mainProduct' => function ($query) {
            return $query->with(['category']);
        }])->get();

        return response()->json($products, 200);
    }

    public function allProducts()
    {
        $products = Product::with([
            'mainProduct' => function ($query) {
                return $query->with(['category']);
            }])->orderBy('created_at', 'DESC')->get();

        return response()->json($products, 200);
    }

    public function getProduct($id)
    {
        $products = Product::findOrFail($id);

        return response()->json($products, 200);
    }

    // cart
    public function addToCart(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer'
        ]);

        $product = Product::findOrFail($request->product_id);

        $getCart = json_decode($request->cookie('cart'), true);

        if ($getCart) {
            if (array_key_exists($request->product_id, $getCart)) {
                $getCart[$request->product_id]['qty'] += $request->qty;
                
                return response()->json($getCart, 200)->cookie('cart', json_encode($getCart), 120);
            }
        }

        $getCart[$request->product_id] = [
            'name' => $product->name,
            'price' => $product->price,
            'qty' => $request->qty,
            'variant' => $product->variant,
        ];

        return response()->json($getCart, 200)->cookie('cart', json_encode($getCart), 120);
    }

    public function getCart()
    {
        $cart = json_decode(request()->cookie('cart'), true);

        return response()->json($cart, 200);
    }

    public function removeCart($id)
    {
        $cart = json_decode(request()->cookie('cart'), true);

        unset($cart[$id]);

        return response()->json($cart, 200)->cookie('cart', json_encode($cart), 120);
    }

    public function storeOrder(Request $request)
    {
        $this->validate($request, [
            'total' => 'required|integer',
            'cash' => 'required|integer',
            'total_change' => 'required|integer'
        ]);

        $cart = json_decode($request->cookie('cart'), true);

        $result = collect($cart)->map(function ($value) {
            return [
                'name' => $value['name'],
                'qty' => $value['qty'],
                'price' => $value['price'],
                'variant' => $value['variant'],
                'result' => $value['price'] * $value['qty']
            ];
        })->all();

        DB::beginTransaction();
        try {
            $order = Order::create([
                'invoice' => $this->generateInvoice(),
                'user'  => auth()->user()->name,
                'total' => $request->total,
                'cash' => $request->cash,
                'total_change' => $request->total_change
            ]);
            
            foreach ($result as $key => $row) {
                $order->orderDetail()->create([
                    'product_id' => $key,
                    'order_id' => $order->id,
                    'qty' => $row['qty'],
                    'price' => $row['price'],
                    'product_name' => $row['name'],
                    'variant' => $row['variant']
                ]);
            }
            
            DB::commit();

            $print = new ThermalPrinter();
            $print->printOrder($order);

            $orderInvoice = $order->invoice;
            $orderTotal = $order->total;
            $orderCash = $order->cash;
            $orderTotalChange = $order->total_change;

            return redirect()->route('order.finish', compact('orderTotal', 'orderCash', 'orderTotalChange', 'orderInvoice'))->cookie(Cookie::forget('cart'));
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
            // return redirect()->back()->with(['error' => 'Error! Silahkan Coba Kembali.']);
        }
    }

    public function generateInvoice()
    {
        $order = Order::orderBy('created_at', 'DESC');

        $order = Order::orderBy('created_at', 'DESC');
        if ($order->count() > 0) {
            $order = $order->first();
            $explode = explode('-', $order->invoice);
            return 'GK-' . ($explode[1] + 1);
        }
        return 'GK-25';
    }
}
