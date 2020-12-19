<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Constants\TransactionStatus;
use App\TransactionProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $filter = Auth::user()->role == 1 ? "1=1" : 'transaction_products.organizer_id = ' . 1;
        $results = TransactionProduct::selectRaw('transaction_products.*, transaction_product_details.*, organizers.name AS organizer_name')
            ->join('transaction_product_details', 'transaction_product_details.transaction_id', 'transaction_products.id')
            ->join('organizers', 'organizers.id', 'transaction_products.organizer_id')
            ->whereRaw($filter)
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
                    'organizer_name' => $transaction->organizer_name,
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
        $transactionStatus = array(
            TransactionStatus::WAITING_CONFIRMATION,
            TransactionStatus::DELIVERED,
            TransactionStatus::ARRIVED,
            TransactionStatus::CLOSED
        );
        return view('transaction', compact('transactions', 'transactionStatus'));
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
        $carts = Cart::selectRaw("products.*, carts.*")
            ->where('organizer_id', Auth::user()->organizerId())
            ->join('products', 'products.id', 'carts.product_id')
            ->get();
        $id = TransactionProduct::insertGetId([
            "status" => TransactionStatus::WAITING_CONFIRMATION,
            "organizer_id" => Auth::user()->organizerId(),
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
    public function changeTransactionStatus(Request $request, $id)
    {
        //if role is Admin
        $transaction = TransactionProduct::find($id);
        $transaction->status = $request->status;
        $transaction->save();
        return redirect()->intended('/transaction')->with("message", "Success Updated Transaction Status!");
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
