<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Order;
use PDF;

class ReportController extends Controller
{
    public function dailyIndex()
    {
        return view('report.daily.index');
    }

    public function generateDailyPdf(Request $request)
    {
        $date = Carbon::parse($request->date)->format('Y-m-d');

        $results = Order::whereDate('created_at', $date)->with('orderDetail')->get();

        if (count($results) === 0) {
            return redirect()->back();
        }
        
        $pdf = PDF::loadView('report.daily.pdf', compact('results'));

        return $pdf->stream();

        // return view('report.daily.pdf', compact('results'));
    }
}
