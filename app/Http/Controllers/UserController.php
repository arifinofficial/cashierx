<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new User();
        $roles = Role::orderBy('name', 'ASC')->get();

        return view('user.form', compact('model', 'roles'));
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
            'email'  => 'required|email|string|unique:users',
            'password' => 'required|string|min:2'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = User::findOrFail($id);

        return view('user.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = User::findOrFail($id);
        $roles = Role::orderBy('name', 'ASC')->get();

        return view('user.form', compact('model', 'roles'));
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
            'email'  => 'required|email|string|unique:users,email,' . $id,
            'password' => 'nullable|string|min:2'
        ]);

        $user = User::findOrFail($id);

        $request['password'] = $request->get('password') ? Hash::make($request->get('password')) : $user->password;

        $user->update($request->all());
        $user->syncRoles($request->role);

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = User::findOrFail($id);

        $model->delete();
    }

    public function dataTable()
    {
        $users = User::query();
        return DataTables::of($users)
        ->addColumn('action', function ($users) {
            return view('layouts.partials._action', [
                'model' => $users,
                'show_url' => route('user.show', $users->id),
                'edit_url' => route('user.edit', $users->id),
                'delete_url' => route('user.destroy', $users->id)
            ]);
        })
        ->rawColumns(['action'])
        ->make(true);
    }
}
