@extends('base.vendor')
@section('main')

<div>
    @php
    $total = 0;
    @endphp
    @if ($carts->count() > 0)
    <!-- TODO organizer id on auth -->
    <form action="/cart/checkout" method="POST">
        {{csrf_field()}}
        @foreach($carts as $cart)
        @php
        $total += $cart->price * $cart->quantity;
        @endphp
        <div class="container">
            <div>{{$cart->name}}</div>
            <div>Rp{{$cart->price}}</div>
            Quantity: {{$cart->quantity}}
        </div>
        @endforeach
        <div>Rp{{$total}}</div>
        <button type="submit" class="btn btn-checkout">Checkout</button>
    </form>
    @else
    <div>No items</div>
    @endif
</div>

@endsection