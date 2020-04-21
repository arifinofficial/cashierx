<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new Category();

        return view('category.form', compact('model'));
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
            'name' => 'required|string|min:2',
            'description' => 'string|nullable'
        ]);

        $category = Category::create($request->all());

        return $category;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Category::findOrFail($id);

        return view('category.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Category::findOrFail($id);

        return view('category.form', compact('model'));
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
            'name' => 'required|string|min:2',
            'description' => 'string|nullable'
        ]);

        $category = Category::findOrFail($id);

        $category->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Category::findOrFail($id);

        $model->delete();
    }

    public function dataTable()
    {
        $categories = Category::query();
        return DataTables::of($categories)
        ->addColumn('action', function ($categories) {
            return view('layouts.partials._action', [
                'model' => $categories,
                'show_url' => route('product.category.show', $categories->id),
                'edit_url' => route('product.category.edit', $categories->id),
                'delete_url' => route('product.category.destroy', $categories->id)
            ]);
        })
        ->rawColumns(['action'])
        ->make(true);
    }
}
