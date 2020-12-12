<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //TODO add by id
        $carts = Cart::selectRaw("products.*, carts.*, vendors.name AS vendor_name")
            ->where('organizer_id', 1)
            ->join('products', 'products.id', 'carts.product_id')
            ->join('vendors', 'vendors.id', 'products.vendor_id')
            ->get();
        return view('cart', compact('carts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $product = Product::where('id', $id)->first();
        $rules = [
            'quantity' => 'required|min:1|lte:' . $product->stock
        ];
        $request->validate($rules);

        //TODO add organizer id by auth
        Cart::insert([
            "organizer_id" => 1,
            "product_id" => $id,
            "quantity" => $request->quantity
        ]);
        return redirect()->intended('/products')->with("message", "Success Added Product to Cart!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
