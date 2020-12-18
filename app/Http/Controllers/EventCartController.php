<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventCart;
use App\Product;
use App\Promo;
use App\TransactionEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = EventCart::selectRaw("events.*, event_carts.*, organizers.id AS organizer_id")
            ->where('event_carts.member_id', Auth::user()->memberId())
            ->join('events', 'events.id', 'event_carts.event_id')
            ->join('organizers', 'organizers.id', 'events.organizer_id')
            ->get();
        return view('event-cart', compact('carts'));
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
    public function store(Request $request, $id)
    {
        $event = Event::where('id', $id)->first();
        $rules = [
            'quantity' => 'required|min:1|lte:' . $event->slot
        ];
        $request->validate($rules);

        //TODO add organizer id by auth... ? member ?
        $ev = EventCart::where('event_id', $id)
            ->where('member_id', Auth::user()->memberId())
            ->first();

        if ($ev != null) {
            $ev->quantity = $request->quantity;
            $ev->save();
        } else {
            //TODO add organizer id by auth ? member ?
            EventCart::insertGetId([
                "member_id" => Auth::user()->memberId(),
                "event_id" => $id,
                "quantity" => $request->quantity
            ]);
        }
        return redirect()->intended('/event')->with("message", "Success Added Event to Cart!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EventCart  $eventCart
     * @return \Illuminate\Http\Response
     */
    public function checkout(Request $request)
    {
        $code = Promo::where('promos.code', $request->code)->first();
        $promoId = $code == null ? null : $code->id;
        $carts = EventCart::selectRaw("events.*, event_carts.*")
            ->where('member_id', Auth::user()->memberId())
            ->join('events', 'events.id', 'event_carts.event_id')
            ->get();

        foreach ($carts as $cart) {
            $tran = TransactionEvent::create([
                "member_id" => Auth::user()->memberId(),
                "event_id" => $cart->event_id,
                "quantity" => $cart->quantity,
                "promo_id" => $promoId
            ]);
            EventController::sendMail($tran->id);

            $cart->destroy($cart->id);
            $event = Event::where('id', $cart->event_id)->first();
            $event->slot -= $cart->quantity;
            $event->save();
        }

        return redirect()->intended('/event')->with("message", "Success Buy Event Tickets, Check your Email for the Ticket!");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EventCart  $eventCart
     * @return \Illuminate\Http\Response
     */
    public function edit(EventCart $eventCart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EventCart  $eventCart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventCart $eventCart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EventCart  $eventCart
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventCart $eventCart)
    {
        //
    }
}
