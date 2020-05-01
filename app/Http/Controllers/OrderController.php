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

            $orderDetails = $order->orderDetail()->get();

            // TESTING

            $connector = new WindowsPrintConnector("smb://" . core()->printerSetting()->printer_ip . "/" . core()->printerSetting()->printer_name);
            $printer = new Printer($connector);

            function buatBaris4Kolom($kolom1, $kolom2, $kolom3, $kolom4)
            {
                $lebar_kolom_1 = 12;
                $lebar_kolom_2 = 3;
                $lebar_kolom_3 = 8;
                $lebar_kolom_4 = 9;
     
                $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
                $kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);
                $kolom3 = wordwrap($kolom3, $lebar_kolom_3, "\n", true);
                $kolom4 = wordwrap($kolom4, $lebar_kolom_4, "\n", true);
     
                $kolom1Array = explode("\n", $kolom1);
                $kolom2Array = explode("\n", $kolom2);
                $kolom3Array = explode("\n", $kolom3);
                $kolom4Array = explode("\n", $kolom4);
     
                $jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array), count($kolom3Array), count($kolom4Array));
     
                $hasilBaris = array();
     
                for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {
                    $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");
                    $hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ");
     
                    $hasilKolom3 = str_pad((isset($kolom3Array[$i]) ? $kolom3Array[$i] : ""), $lebar_kolom_3, " ", STR_PAD_LEFT);
                    $hasilKolom4 = str_pad((isset($kolom4Array[$i]) ? $kolom4Array[$i] : ""), $lebar_kolom_4, " ", STR_PAD_LEFT);
     
                    $hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2 . " " . $hasilKolom3 . " " . $hasilKolom4;
                }
     
                return implode($hasilBaris, "\n") . "\n";
            }

            $img = EscposImage::load(base_path().'/public/images/logo60.png');
            $printer->initialize();
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->graphics($img);
            $printer->initialize();
            $printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Goud Koffie\n");
            $printer->text("\n");
 
            $printer->initialize();
            $printer->text("Kasir : ".$order->user."\n");
            $printer->text("No Order :".$order->invoice."\n");
            $printer->text("Waktu :".date($order->created_at)."\n");
 
            $printer->initialize();
            $printer->setFont(Printer::FONT_B);
            $printer->text("----------------------------------------\n");
            $printer->text(buatBaris4Kolom("Items", "Qty", "Harga", "Sub"));
            $printer->text("----------------------------------------\n");
            foreach ($orderDetails as $key => $value) {
                $printer->text(buatBaris4Kolom($value->product_name, $value->qty, number_format($value->price), number_format($value->price * $value->qty)));
            }
            $printer->text("----------------------------------------\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text('Total '.number_format($order->total)."\n");
            $printer->text('Tunai '.number_format($order->cash)."\n");
            $printer->text('Kembalian '.number_format($order->total_change)."\n");
            $printer->text("\n");
 
            $printer->initialize();
            $printer->setFont(Printer::FONT_A);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Terimakasih.\n");
            $printer->text("www.goudkoffie.co\n");
 
            $printer->feed(5);
            $printer->close();

            $orderTotal = $order->total;
            $orderCash = $order->cash;
            $orderTotalChange = $order->total_change;

            return redirect()->route('order.finish', compact('orderTotal', 'orderCash', 'orderTotalChange'))->cookie(Cookie::forget('cart'));
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
