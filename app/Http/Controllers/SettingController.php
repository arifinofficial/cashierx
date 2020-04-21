<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::first();

        return view('setting.index', compact('setting'));
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
        $this->validate($request, [
            'store_name' => 'required|string|min:1',
            'store_email' => 'required|email|min:1',
            'store_phone' => 'nullable|max:15',
            'store_address' => 'required|string|min:5',
            'store_logo' => 'nullable|mimes:jpeg,jpg,png|max:10240'
        ]);

        if ($request->hasFile('store_logo')) {
            $savedImg = $request->file('store_logo')->store('settings');

            Setting::create([
                'store_name' => $request->store_name,
                'store_email' => $request->store_email,
                'store_phone' => $request->store_phone,
                'store_address' => $request->store_address,
                'store_logo' => $savedImg
            ]);
        } else {
            Setting::create($request->all());
        }
        
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
}
