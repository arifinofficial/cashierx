<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Variant;

class VariantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('variant.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new Variant();

        return view('variant.form', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:2'
        ]);

        $variant = Variant::create($request->all());

        return $variant;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Variant::findOrFail($id);

        return view('variant.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Variant::findOrFail($id);

        return view('variant.form', compact('model'));
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
        $this->validate($request, [
            'name' => 'required|string|min:2'
        ]);

        $variant = Variant::findOrFail($id);

        $variant->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Variant::findOrFail($id);

        $model->delete();
    }

    public function dataTable()
    {
        $variants = Variant::query();
        return DataTables::of($variants)
        ->addColumn('action', function ($variants) {
            return view('layouts.partials._action', [
                'model' => $variants,
                'show_url' => route('product.variant.show', $variants->id),
                'edit_url' => route('product.variant.edit', $variants->id),
                'delete_url' => route('product.variant.destroy', $variants->id)
            ]);
        })
        ->rawColumns(['action'])
        ->make(true);
    }
}
