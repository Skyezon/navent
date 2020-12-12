@extends('base.vendor')
@section('main')

<div class="d-flex justify-content-center">
    @php
    $total = 0;
    @endphp
    @if ($carts->count() > 0)
    <div class="container d-flex flex-row cart-container">
        <div class="cart-left">
            @foreach($carts as $cart)
            @php
            $total += $cart->price * $cart->quantity;
            @endphp
            <div class="container d-flex flex-row">
                <div>
                    <img class="cart-image" src="{{env('APP_URL')}}:8000/uploads/image/product/{{$cart->image}}" onerror="this.onerror=null;this.src='{{$cart->image}}';">
                </div>
                <div>
                    <div class="cart-title txt-green">{{$cart->name}}</div>
                    <div>Rp{{$cart->price}}</div>
                    <div class="fa fa-shopping-cart"></div> {{$cart->quantity}}
                </div>
            </div>
            <hr class="line">
            @endforeach
        </div>
        <div class="cart-right">
            <div><b>Total</b></div>
            <div>Rp{{$total}}</div>
            <hr class="line">
            <button class="btn checkout-btn submit-btn" data-toggle="modal" data-target="#checkout-modal">Checkout</button>
            <div class=" modal fade" id="checkout-modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><b>Checkout Items</b></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div><b>Do you want to checkout now?</b></div>
                            <form action="/cart/checkout" method="POST">
                                {{csrf_field()}}
                                <button class="btn btn-success" type="submit">
                                    Yes
                                </button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="d-flex justify-content-center flex-column">
        <div class="cart-title text-center">
            No Items in <span class="txt-green">Cart</span>
        </div>
        <div class="cart-not-found">
        </div>
        <div class="cart-desc">
            Looks like there are no items in your cart, Check out more items <a class="txt-green" href="/products"><b>here</b></a> !
        </div>
    </div>

    @endif
</div>

@endsection