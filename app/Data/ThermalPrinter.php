<?php

namespace App\Data;

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class ThermalPrinter
{
    public function printOrder($order)
    {
        $orderDetails = $order->orderDetail()->get();

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
            // return implode("\n", $hasilBaris) . "\n";
        }

        $printer->initialize();
        $printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Goud Koffie\n");
        $printer->text("\n");
        $printer->initialize();
        $printer->setFont(Printer::FONT_B);
        $printer->text("JL. MT Haryono No 8, Kedungwaru, Tulungagung. \n");
 
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
        if ($order->discount_value != null) {
            $printer->text('Diskon '.$order->discount_value."% \n");
        }
        $printer->text('Sub Total '.number_format($order->sub_total)."\n");
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

        return;
    }
}
