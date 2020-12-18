@extends('base.vendor')
@section('main')

@php
$status = array(
"waiting confirmation"=> "text-orange",
"arrived" => "txt-green",
"delivered" => "text-primary",
"closed" => "text-red"
);
@endphp
@if(session()->has('message'))
<div class="alert alert-success alert-green alert-dismissible">
    <a class="close txt-green" data-dismiss="alert" aria-label="close">&times;</a>
    {{ session()->get('message') }}
</div>
@endif
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
            <button type="button" class="btn submit-btn" data-toggle="modal" data-target="#transaction-modal-{{$transaction['id']}}">
                Change Transaction Status
            </button>
            <div class="text-right tran-total">Total: <div>Rp<span class="txt-green"><b>{{$total}}</b></span></div>
            </div>
            <div>Transaction By: <b>{{$transaction['organizer_name']}}</b> at {{$transaction['date']}}</div>
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
        <div class="modal fade" id="transaction-modal-{{$transaction['id']}}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><b>Change Transaction Status</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div>Transaction By: <b>{{$transaction['organizer_name']}} </b>at {{$transaction['date']}}</div>
                        <form action="/transaction/{{$transaction['id']}}/status" method="POST">
                            <div>Status</div>

                            <select id="status" name="status">
                                @foreach($transactionStatus as $stat)
                                @if($stat == $transaction['status'])
                                <option value="{{$stat}}" selected="true">{{$stat}}</option>
                                @else
                                <option value="{{$stat}}">{{$stat}}</option>
                                @endif
                                @endforeach
                            </select>
                            {{ csrf_field() }}
                            <br /><br />
                            <button type="submit" class="btn btn-success">Change Status</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection