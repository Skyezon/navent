<?php

namespace App\Http\Controllers;

use App\Constants\Location;
use App\Constants\Role;
use App\Http\Requests\VendorRequest;
use App\User;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    public function showVendorRegisForm(){
        $provinces = array_keys(Location::LOCATION);
        return view('regis-role.vendor',compact('provinces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(VendorRequest $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'image' => 'required'
        ]);
        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => Role::VENDOR
        ]);
        $path = null;
        $file = $request->file('image');
        if($file != null){
            $filename = $request->name . "." . $file->getClientOriginalExtension();
            $path = '/uploads/image/vendor/' . $filename;
        }


        Vendor::insert([
            'user_id' => $newUser->id,
            'name' => $request->name,
            'phone_number' => $request->phone,
            'image' => $path,
            'province' => $request->province,
            'city' => $request->city
        ]);
        return redirect()->route('home')->with('message','Register as Vendor success');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorRequest $request)
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
    public function edit(VendorRequest $request)
    {
        $id = Auth::user()->vendorId();
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
