@extends('base.vendor')
@section('main')

@php
$value = isset($product->quantity) ? $product->quantity: null;
$text = $value != null ? "Update Cart": "Add to Cart";
@endphp
<div class="modal-header">
    <h5 class="modal-title"><b>{{$product->name}}</b></h5>
</div>
<div class="modal-body d-flex flex-direction-row">
    <img class="prod-det-image" src="{{env('APP_URL')}}:8000/uploads/image/product/{{$product->image}}" onerror="this.onerror=null;this.src='{{$product->image}}';">
    <div>
        <b>Price: {{$product->price}}</b>
        <div><b>{{$product->stock}}</b> Stock Left</div>
        <div><b>Product description:</b></div>
        {{$product->description}}
        <br /><br />
        @if($product->stock == 0)
        <div class="text-danger">Sorry, this product is out of stock</div>
        @else
        <form action="/cart/product/{{$product->id}}" method="POST">
            <div>Number of Products:</div>
            {{ csrf_field() }}
            <input type="number" value="{{$value}}" name="quantity">
            <br /><br />
            <button type="submit" class="btn btn-success">{{$text}}</button>
        </form>
        @endif
    </div>

</div>
@endsection