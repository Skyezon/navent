<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Constants\TransactionStatus;
use App\TransactionProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout(Request $request)
    {
        //TODO: add organizer id by auth
        $carts = Cart::selectRaw("products.*, carts.*")
            ->where('organizer_id', 1)
            ->join('products', 'products.id', 'carts.product_id')
            ->get();
        //TODO: add organizer id by auth
        $id = TransactionProduct::insertGetId([
            "status" => TransactionStatus::WAITING_CONFIRMATION,
            "organizer_id" => '1',
        ]);

        foreach ($carts as $cart) {
            DB::table("transaction_product_details")->insert([
                "transaction_id" => $id,
                'product_name' => $cart->name,
                'quantity' => $cart->quantity,
                "product_price" => $cart->price
            ]);
            $cart->destroy($cart->id);
        }
        return redirect()->intended('/products')->with("message", "Success Buy Item, Please Wait for Vendor's Confirmation!");
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\TransactionProduct  $transactionProduct
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionProduct $transactionProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TransactionProduct  $transactionProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(TransactionProduct $transactionProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TransactionProduct  $transactionProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransactionProduct $transactionProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TransactionProduct  $transactionProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionProduct $transactionProduct)
    {
        //
    }
}
