<?php

namespace App\Http\Controllers;

use App\Constants\Location;
use App\Http\Requests\MemberRequest;
use App\Member;
use App\Organizer;
use App\Promo;
use App\User;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //TODO change all id to auth
        //if user is member
        // $user = Member::selectRaw('users.email AS email, event_members.*')
        //     ->where('user_id', 1)
        //     ->join('users', 'users.id', 'event_members.user_id')
        //     ->first();
        // return view('member-edit', compact('user'));

        //if user is organizer
        // $user = Organizer::selectRaw('users.email AS email, organizers.*')
        //     ->where('user_id', 2)
        //     ->join('users', 'users.id', 'organizers.user_id')
        //     ->first();

        // $provinces = array_keys(Location::LOCATION);
        // return view('organizer-edit', compact('user', 'provinces'));

        //if user is vendor
        $user = Vendor::selectRaw('users.email AS email, vendors.*')
            ->where('user_id', 3)
            ->join('users', 'users.id', 'vendors.user_id')
            ->first();
        $provinces = array_keys(Location::LOCATION);
        return view('vendor-edit', compact('user', 'provinces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(MemberRequest $request)
    {
        DB::table('event_members')->insert([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'phone_number' => $request->phoneNumber,
        ]);
        return redirect()->route('home')->with('success','Register as Member success');
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
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(MemberRequest $request)
    {
        //ToDo change into user id
        $id = 1;

        $user = User::where('id', $id)->first();
        $user->email = $request->email;
        if ($request->password != null) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        $member = Member::where('user_id', $id)->first();
        $member->name = $request->name;
        $member->phone_number = $request->phone;
        $member->save();

        return redirect()->intended('/event')->with("message", "Success Updated Profile!");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        //
    }
}
