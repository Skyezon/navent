<?php

namespace App\Http\Controllers;

use App\Organizer;
use App\User;
use Illuminate\Http\Request;

class OrganizerController extends Controller
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
     * @param  \App\Organizer  $organizer
     * @return \Illuminate\Http\Response
     */
    public function show(Organizer $organizer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Organizer  $organizer
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //ToDo change into id
        $id = 2;
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

        $organizer = Organizer::where('user_id', $id)->first();
        $organizer->name = $request->name;
        $organizer->phone_number = $request->phone;
        $organizer->city = $request->city;
        $organizer->province = $request->province;
        $file = $request->file('image');

        if ($file != null) {
            $filename = $request->name . "." . $file->getClientOriginalExtension();
            $path = "/uploads/image/organizer/";
            if (substr($organizer->image, 0, strlen($path)) == $path) {
                unlink(public_path() . $organizer->image);
            }
            $file->move(public_path() . '/uploads/image/organizer', $filename);
            $organizer->image = '/uploads/image/organizer/' . $filename;
        }
        $organizer->save();

        return redirect()->intended('/event')->with("message", "Success Updated Profile!");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Organizer  $organizer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organizer $organizer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Organizer  $organizer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organizer $organizer)
    {
        //
    }
}
