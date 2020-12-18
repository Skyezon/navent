<?php

namespace App\Http\Controllers;

use App\User;
use App\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //ToDo change into id
        $id = 3;
        $rules = [
            "name" => 'required|min:5',
            "password" => 'nullable|min:5',
            "phone" => 'numeric|min:10',
            "email" => 'required|unique:users,email,' . $id,
            'image' => 'nullable|mimes:jpg,png,jpeg'
        ];

        $request->validate($rules);
        $user = User::where('id', $id)->first();
        $user->email = $request->email;
        if ($request->password != null) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        $vendor = Vendor::where('user_id', $id)->first();
        $vendor->name = $request->name;
        $vendor->phone_number = $request->phone;
        $vendor->city = $request->city;
        $vendor->province = $request->province;
        $file = $request->file('image');

        if ($file != null) {
            $filename = $request->name . "." . $file->getClientOriginalExtension();
            $path = "/uploads/image/vendor/";
            if (substr($vendor->image, 0, strlen($path)) == $path) {
                unlink(public_path() . $vendor->image);
            }
            $file->move(public_path() . '/uploads/image/vendor', $filename);
            $vendor->image = '/uploads/image/vendor/' . $filename;
        }
        $vendor->save();

        return redirect()->intended('/event')->with("message", "Success Updated Profile!");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        //
    }
}
