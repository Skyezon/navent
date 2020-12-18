<?php

namespace App\Http\Controllers;

use App\EventType;
use App\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = ProductType::paginate(10);
        return view('product-type', compact('types'));
    }

    public function addForm()
    {
        return view('product-type-form');
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
            'name' => 'required|unique:product_types'
        ];
        $request->validate($rules);
        ProductType::insert([
            "name" => $request->name
        ]);
        return redirect()->intended('/product/type')->with("message", "Success Created Product Type!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EventType  $eventType
     * @return \Illuminate\Http\Response
     */
    public function editForm($id)
    {
        $type = ProductType::where('id', $id)->first();
        return view('product-type-form', compact('type', 'id'));
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
            'name' => 'required|unique:product_types,name,' . $id
        ];
        $request->validate($rules);
        $type = ProductType::where('id', $id)->first();
        $type->name = $request->name;
        $type->save();

        return redirect()->intended('/product/type')->with("message", "Success Updated Product Type!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EventType  $eventType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ProductType::destroy($id);
        return redirect()->intended('/product/type')->with("message", "Success Deleted Product Type!");
    }
}
