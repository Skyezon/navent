@extends('base.vendor')
@section('main')

@php
$status = array(
"waiting confirmation"=> "text-orange",
"arrived" => "txt-green",
"closed" => "text-red"
);
@endphp
<div class="text-lg-center add-product-title">My <span class="txt-green">Transactions</span></div>
<div id="accordion" class="transaction-history">
    @foreach($transactions as $transaction)
    <div class="card card-dark">
        <div class="card-header" id="heading-{{$transaction['id']}}">
            <h5 class="mb-0">
                <button class="btn text-light transaction-title" data-toggle="collapse" data-target="#transaction-{{$transaction['id']}}" aria-controls="transaction-{{$transaction['id']}}">
                    {{$transaction['date']}}
                    <span class="{{$status[$transaction['status']]}}"> {{$transaction['status']}}</span>
                </button>
            </h5>
        </div>
        <div id="transaction-{{$transaction['id']}}" class="collapse transaction-body" aria-labelledby="heading-{{$transaction['id']}}" data-parent="#accordion">
            @php
            $total = number_format($transaction['total'], 0, "", ".");
            @endphp
            <div class="text-right tran-total">Total: <div>Rp<span class="txt-green"><b>{{$total}}</b></span></div>
            </div>
            @foreach($transaction['products'] as $product)
            <div class="tran-prod-title">{{$product['name']}}</div>
            @php
            $price = number_format($product['price'], 0, "", ".");
            @endphp
            <span class="tran-prod-price txt-green"><span class="text-light">Rp </span>{{$price}}</span>
            <div class="tran-prod-quantity">Qty: {{$product['quantity']}}</div>
            <hr class="line">
            @endforeach
        </div>
    </div>
    @endforeach
</div>
@endsection