<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Unit;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('unit.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new Unit();

        return view('unit.form', compact('model'));
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
            'name' => 'required|string|min:1',
            'code'  => 'required|string|min:1',
        ]);

        $unit = Unit::create($request->all());

        return $unit;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Unit::findOrFail($id);

        return view('unit.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Unit::findOrFail($id);

        return view('unit.form', compact('model'));
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
            'name' => 'required|string|min:1',
            'code'  => 'required|string|min:1',
        ]);

        $unit = Unit::findOrFail($id);

        $unit->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Unit::findOrFail($id);

        $model->delete();
    }

    public function dataTable()
    {
        $units = Unit::query();
        return DataTables::of($units)
        ->addColumn('action', function ($units) {
            return view('layouts.partials._action', [
                'model' => $units,
                'show_url' => route('product.unit.show', $units->id),
                'edit_url' => route('product.unit.edit', $units->id),
                'delete_url' => route('product.unit.destroy', $units->id)
            ]);
        })
        ->rawColumns(['action'])
        ->make(true);
    }
}
