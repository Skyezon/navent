<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Constants\TransactionStatus;
use App\TransactionProduct;
use Carbon\Carbon;
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
        //TODO add organizer id
        // $filter = Auth::user()->role == 1 ? "1=1" : 'transactions.user_id = ' . Auth::user()->id;
        $results = TransactionProduct::selectRaw('transaction_products.*, transaction_product_details.*')
            ->join('transaction_product_details', 'transaction_product_details.transaction_id', 'transaction_products.id')
            ->whereRaw("transaction_products.organizer_id = 1")
            ->get();
        $transactions = array();
        foreach ($results as $transaction) {
            if (!isset($transactions[$transaction->id])) {
                $date = new Carbon($transaction->created_at);
                $transactions[$transaction->id] = [
                    "id" => $transaction->id,
                    "date" => $date->toDayDateTimeString(),
                    "username" => $transaction->username,
                    "status" => $transaction->status,
                    "total" => 0,
                    "products" => array()
                ];
            }
            $transactions[$transaction->id]["total"] += $transaction->product_price;
            array_push($transactions[$transaction->id]["products"], [
                "name" => $transaction->product_name,
                "price" => $transaction->product_price,
                "quantity" => $transaction->quantity
            ]);
        }
        return view('transaction', compact('transactions'));
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
