<?php

namespace App\Http\Controllers;

use App\Constants\Location;
use App\Constants\Role;
use App\Http\Requests\MemberRequest;
use App\Member;
use App\Organizer;
use App\Promo;
use App\User;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            //TODO : need rfc
        if(Auth::user()->role == 'member'){
            $user = Member::selectRaw('users.email AS email, event_members.*')
                ->where('user_id', Auth::user()->id)
                ->join('users', 'users.id', 'event_members.user_id')
                ->first();
            return view('member-edit', compact('user'));
        }elseif (Auth::user()->role == 'organizer'){
            $user = Organizer::selectRaw('users.email AS email, organizers.*')
                ->where('user_id', Auth::user()->id)
                ->join('users', 'users.id', 'organizers.user_id')
                ->first();

            $provinces = array_keys(Location::LOCATION);
            return view('organizer-edit', compact('user', 'provinces'));
        }elseif (Auth::user()->role == 'vendor'){
            $user = Vendor::selectRaw('users.email AS email, vendors.*')
                ->where('user_id', Auth::user()->id)
                ->join('users', 'users.id', 'vendors.user_id')
                ->first();
            $provinces = array_keys(Location::LOCATION);
            return view('vendor-edit', compact('user', 'provinces'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(MemberRequest $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => Role::MEMBERS
        ]);
        Member::insert([
            'user_id' => $newUser->id,
            'name' => $request->name,
            'phone_number' => $request->phone,
        ]);

        $newMember = Member::where('user_id',$newUser->id)->first();

        Promo::insert([
            "code" => Str::random('5'),
            "discount" => 25000,
            'event_members_id' => $newMember->id
        ]);

        Auth::attempt($request->only('email','password'));

        return redirect()->route('home')->with('message','Register as Member success');
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
        $id = Auth::user()->memberId();

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
