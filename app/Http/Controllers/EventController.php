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
        $rules = [
            'name' => 'required|min:5',
            'slot' => 'required|numeric|min:5',
            'price' => 'required|min:0',
            'province' => 'required',
            "city" => 'required',
            'type' => 'required',
            'dateStart' => 'required',
            'address' => 'required|min:5',
            'dateEnd' => 'required|after_or_equal:dateStart',
            'desc' => 'required|min:5',
            'image' => 'required|mimes:jpg,png,jpeg'
        ];
        $request->validate($rules);
        $file = $request->file('image');
        $now = Carbon::now();
        $filename = $request->name . "_" . $now->getTimestamp() . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/uploads/image/event', $filename);
        $filename = '/uploads/image/event/' . $filename;

        //TODO: get organizer id from auth
        Event::insert([
            "organizer_id" => 1,
            "type_id" => $request->type,
            "name" => $request->name,
            "date_start" => $request->dateStart,
            "date_end" => $request->dateEnd,
            'image' => $filename,
            'description' => $request->desc,
            'province' => $request->province,
            'city' => $request->city,
            'price' =>  $request->price,
            'slot' =>  $request->slot,
            'address' => $request->address
        ]);
        return redirect()->intended('/event')->with("message", "Success Add Event!");
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
        $rules = [
            'name' => 'required|min:5',
            'slot' => 'required|numeric|min:5',
            'price' => 'required|min:0',
            'province' => 'required',
            "city" => 'required',
            'type' => 'required',
            'dateStart' => 'required',
            'address' => 'required|min:5',
            'dateEnd' => 'required|after_or_equal:dateStart',
            'desc' => 'required|min:5',
            'image' => 'nullable|mimes:jpg,png,jpeg'
        ];
        $request->validate($rules);
        $file = $request->file('image');
        $event = Event::where('id', $id)->first();
        $event->name = $request->name;
        $event->slot = $request->slot;
        $event->price = $request->price;
        $event->province = $request->province;
        $event->city = $request->city;
        $event->type_id = $request->type;
        $event->date_start = $request->dateStart;
        $event->date_end = $request->dateEnd;
        $event->description = $request->desc;
        $event->address = $request->address;
        if ($file != null) {
            $filename = $request->name . "." . $file->getClientOriginalExtension();
            $path = "/uploads/image/event/";
            if (substr($event->image, 0, strlen($path)) == $path) {
                unlink(public_path() . $event->image);
            }
            $file->move(public_path() . '/uploads/event', $filename);
            $event->image = '/uploads/event/' . $filename;
        }
        $event->save();

        return redirect()->intended('/event')->with("message", "Success Updated Event!");
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
