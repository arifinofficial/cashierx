<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Order;

class TransactionDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('transaction.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Order::with('orderDetail')->findOrFail($id);

        return view('transaction.show', compact('model'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Order::findOrFail($id);

        $model->delete();
    }

    public function dataTable()
    {
        $orders = Order::query();
        $orders = $orders->get()->map(function ($item) {
            $item->total = number_format($item->total, 0, ',', '.');
            $item->cash = number_format($item->cash, 0, ',', '.');
            $item->total_change = number_format($item->total_change, 0, ',', '.');
            return $item;
        });
        return DataTables::of($orders)
        ->addColumn('action', function ($orders) {
            return view('layouts.partials._action', [
                'model' => $orders,
                'show_url' => route('transaction-data.show', $orders->id),
                'edit_url' => '#',
                'delete_url' => route('transaction-data.destroy', $orders->id)
            ]);
        })
        ->rawColumns(['action'])
        ->make(true);
    }
}
