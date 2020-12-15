<?php

namespace App\Http\Controllers;

use App\Constants\Location;
use App\Event;
use App\EventType;
use App\Organizer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //TODO: get organizer id from auth
        $events = Event::selectRaw('events.*, organizers.name AS organizer_name, event_types.name AS type_name')
            ->join('organizers', 'events.organizer_id', 'organizers.id')
            ->join('event_types', 'event_types.id', 'events.type_id')
            ->where('organizers.id', 1)
            ->paginate(10);

        $organizer = Organizer::where('id', 1)->first();
        return view('events', compact('events', 'organizer'));
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
            'slot' =>  $request->slot
        ]);
        return redirect()->intended('/event')->with("message", "Success Add Event!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function addForm()
    {
        $types = EventType::all();
        $provinces = array_keys(Location::LOCATION);
        return view('event-form', compact('types', 'provinces'));
    }

    public function getProvinces(Request $request)
    {
        $cities = Location::LOCATION[$request->province];
        return response()->json($cities);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function editForm($id)
    {
        $types = EventType::all();
        $event = Event::where('id', $id)->first();
        $provinces = array_keys(Location::LOCATION);
        return view('event-form', compact('types', 'provinces', 'event', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:5',
            'slot' => 'required|numeric|min:5',
            'price' => 'required|min:0',
            'province' => 'required',
            "city" => 'required',
            'type' => 'required',
            'dateStart' => 'required',
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
    public function destroy($id)
    {
        $event = Event::where('id', $id)->first();
        $path = "/uploads/image/event/";
        if (substr($event->image, 0, strlen($path)) == $path) {
            unlink(public_path() . $event->image);
        }
        $event->delete();
        return redirect()->intended('/event')->with("message", "Success Deleted Event!");
    }
}
