<?php

namespace App\Http\Controllers;

use App\EventType;
use Illuminate\Http\Request;

class EventTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = EventType::paginate(10);
        return view('event-type', compact('types'));
    }

    public function addForm()
    {
        return view('event-type-form');
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
        $rules = [
            'name' => 'required|unique:event_types'
        ];
        $request->validate($rules);
        EventType::insert([
            "name" => $request->name
        ]);
        return redirect()->intended('/event/type')->with("message", "Success Created Event Type!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EventType  $eventType
     * @return \Illuminate\Http\Response
     */
    public function editForm($id)
    {
        $type = EventType::where('id', $id)->first();
        return view('event-type-form', compact('type', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EventType  $eventType
     * @return \Illuminate\Http\Response
     */
    public function edit(EventType $eventType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EventType  $eventType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|unique:event_types,name,' . $id
        ];
        $request->validate($rules);
        $type = EventType::where('id', $id)->first();
        $type->name = $request->name;
        $type->save();

        return redirect()->intended('/event/type')->with("message", "Success Updated Event Type!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EventType  $eventType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        EventType::destroy($id);
        return redirect()->intended('/event/type')->with("message", "Success Deleted Event Type!");
    }
}
