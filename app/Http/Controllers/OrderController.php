<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Order;
use DB;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class OrderController extends Controller
{
    public function addOrder()
    {
        $products = Product::orderBy('created_at', 'DESC')->get();

        return view('order.add', compact('products'));
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
            'sku' => $product->sku,
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

            // TESTING

            $ip = '192.168.100.45';
            $printer = '58mm Series Printer';
            $connector = new WindowsPrintConnector("smb://" . $ip . "/" . $printer);
            $printer = new Printer($connector);

            function buatBaris4Kolom($kolom1, $kolom2, $kolom3, $kolom4)
            {
                // Mengatur lebar setiap kolom (dalam satuan karakter)
                $lebar_kolom_1 = 12;
                $lebar_kolom_2 = 3;
                $lebar_kolom_3 = 8;
                $lebar_kolom_4 = 9;
     
                // Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n
                $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
                $kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);
                $kolom3 = wordwrap($kolom3, $lebar_kolom_3, "\n", true);
                $kolom4 = wordwrap($kolom4, $lebar_kolom_4, "\n", true);
     
                // Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
                $kolom1Array = explode("\n", $kolom1);
                $kolom2Array = explode("\n", $kolom2);
                $kolom3Array = explode("\n", $kolom3);
                $kolom4Array = explode("\n", $kolom4);
     
                // Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
                $jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array), count($kolom3Array), count($kolom4Array));
     
                // Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
                $hasilBaris = array();
     
                // Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris
                for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {
     
                    // memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan,
                    $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");
                    $hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ");
     
                    // memberikan rata kanan pada kolom 3 dan 4 karena akan kita gunakan untuk harga dan total harga
                    $hasilKolom3 = str_pad((isset($kolom3Array[$i]) ? $kolom3Array[$i] : ""), $lebar_kolom_3, " ", STR_PAD_LEFT);
                    $hasilKolom4 = str_pad((isset($kolom4Array[$i]) ? $kolom4Array[$i] : ""), $lebar_kolom_4, " ", STR_PAD_LEFT);
     
                    // Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
                    $hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2 . " " . $hasilKolom3 . " " . $hasilKolom4;
                }
     
                // Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
                return implode($hasilBaris, "\n") . "\n";
            }

            $printer->initialize();
            $printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT); // Setting teks menjadi lebih besar
            $printer->setJustification(Printer::JUSTIFY_CENTER); // Setting teks menjadi rata tengah
            $printer->text("Goud Koffie\n");
            $printer->text("\n");
 
            // Data transaksi
            $printer->initialize();
            $printer->text("Kasir :".$order->user."\n");
            $printer->text("Waktu :".date($order->created_at)."\n");
 
            // Membuat tabel
            $printer->initialize(); // Reset bentuk/jenis teks
            $printer->setFont(Printer::FONT_B);
            $printer->text("----------------------------------------\n");
            $printer->text(buatBaris4Kolom("Items", "Qty", "Harga", "Sub"));
            $printer->text("----------------------------------------\n");
            $printer->text(buatBaris4Kolom("Makaroni 250gr", "2pcs", "15.000", "30.000"));
            $printer->text(buatBaris4Kolom("Telur", "2pcs", "5.000", "10.000"));
            $printer->text(buatBaris4Kolom("Tepung terigu", "1pcs", "8.200", "16.400"));
            $printer->text("----------------------------------------\n");
            $printer->text('Total '.number_format($order->total)."\n");
            $printer->text('Tunai '.number_format($order->cash)."\n");
            $printer->text('Kembalian '.number_format($order->total_change)."\n");
            $printer->text("\n");
 
            // Pesan penutup
            $printer->initialize();
            $printer->setFont(Printer::FONT_A);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Terimakasih.\n");
            $printer->text("www.goudkoffie.co\n");
 
            $printer->feed(5); // mencetak 5 baris kosong agar terangkat (pemotong kertas saya memiliki jarak 5 baris dari toner)
            $printer->close();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function generateInvoice()
    {
        $order = Order::orderBy('created_at', 'DESC');

        $order = Order::orderBy('created_at', 'DESC');
        if ($order->count() > 0) {
            $order = $order->first();
            $explode = explode('-', $order->invoice);
            return 'INVGK-' . ($explode[1] + 1);
        }
        return 'INVGK-25';
    }
}
