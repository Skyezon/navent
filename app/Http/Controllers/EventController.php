<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventCart;
use App\EventType;
use App\Member;
use App\Organizer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allEvents = Event::all();
        $allEvents->sortBy('date_start');
        $count = 0;
        $datas = collect([]);
        foreach ($allEvents as $event){
            if($count == 9){
                break;
            }
            $datas->push($event);
            $count++;
        }
        $types = DB::table('event_types')->take(3)->get();
        return view('home',compact('datas','types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Responhoe
     */
    public function create(Request $request)
    {
        //
        $selector = $request->query('type_id') != null ? "events.type_id = " .  $request->query('type_id') : "1=1";
        //TODO: get organizer id from auth
        $events = Event::selectRaw('events.*, organizers.name AS organizer_name, event_types.name AS type_name')
            ->join('organizers', 'events.organizer_id', 'organizers.id')
            ->join('event_types', 'event_types.id', 'events.type_id')
            ->where('organizers.id', 1)
            ->whereRaw($selector)
            ->paginate(10);

        $types = EventType::all();

        $organizer = Organizer::where('id', 1)->first();
        return view('events', compact('events', 'organizer', 'types'));
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
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }

    public function detail($id)
    {
        //TODO change member id
        $carts = EventCart::where('member_id', '1')
            ->get();
        $event = Event::selectRaw('events.*, organizers.name AS organizer_name, event_types.name AS type_name')
            ->join('organizers', 'events.organizer_id', 'organizers.id')
            ->join('event_types', 'event_types.id', 'events.type_id')
            ->where('events.id', $id)
            ->first();
        foreach ($carts as $cart) {
            if ($cart->event_id == $event->id) {
                $event->quantity = $cart->quantity;
                break;
            }
        }
        return view('event-detail', compact('event'));
    }

    public function search(Request $request)
    {
        $query = $request->query('query');
        $movies = Event::where('name', 'LIKE', '%' . $query . '%')
            ->whereRaw('date_end > NOW()')
            ->get();
        if (strlen($query) == 0 || count($movies) == 0) {
            return response()->json([
                'message' => 'Not Found'
            ]);
        }
        return response()->json($movies);
    }
}
