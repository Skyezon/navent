<?php

namespace App\Http\Controllers;

use App\Promo;
use App\TransactionEvent;
use Illuminate\Http\Request;
use Faker\Factory;
use Illuminate\Support\Facades\Auth;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promos = Promo::paginate(10);
        return view('promo', compact('promos'));
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
        $request->code = strtoupper($request->code);
        $rules = [
            'code' => 'required|unique:promos',
            'discount' => 'required|numeric|min:1|max:100'
        ];
        $request->validate($rules);
        Promo::insert([
            "code" => $request->code,
            "discount" => $request->discount,
        ]);
        return redirect()->intended('/promo')->with("message", "Success Created Promo!");
    }

    public function check(Request $request)
    {
        $name = strtoupper($request->query('code'));
        $res = Promo::where("code", $name)->first();
        if ($res != null) {
            $transaction = TransactionEvent::where('promo_id', $res->id)
                ->where('member_id', Auth::user()->memberId())
                ->first();
            if ($transaction != null) {
                return response()->json([
                    'message' => 'Promo code used, try another one'
                ]);
            }
        }
        return response()->json($res);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function editForm($id)
    {
        $promo = Promo::where('id', $id)->first();
        return view('promo-form', compact('promo', 'id'));
    }

    public function addForm()
    {
        return view('promo-form');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'code' => 'required|unique:promos,code,' . $id,
            'discount' => 'required|numeric|min:1|max:100'
        ];
        $request->validate($rules);
        $promo = Promo::where('id', $id)->first();
        $promo->discount = $request->discount;
        $promo->code = $request->code;
        $promo->save();

        return redirect()->intended('/promo')->with("message", "Success Updated Promo!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Promo::destroy($id);
        return redirect()->intended('/promo')->with("message", "Success Deleted Promo!");
    }

    public function createReferralCode($userId)
    {
        $faker = Factory::create();
        Promo::insert([
            "code" => $faker->regexify('([A-Z]{3}[0-9]{2})'),
            "discount" => 15000,
            'event_members_id' => $userId
        ]);
    }
}
