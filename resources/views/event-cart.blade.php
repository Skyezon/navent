@extends('base.vendor')
@section('main')

<div class="text-lg-center add-product-title">My <span class="txt-green">Carts</span></div>
<div class="d-flex justify-content-center event-cart-container">
    @php
    $total = 0;
    @endphp
    @if ($carts->count() > 0)
    <div class="d-flex flex-row cart-container">
        <div class="cart-left">
            @foreach($carts as $cart)
            @php
            $total += $cart->price * $cart->quantity;
            @endphp
            <div class="container d-flex flex-row">
                <div>
                    <img class="cart-image" src="{{env('APP_URL')}}:8000/uploads/image/event/{{$cart->image}}" onerror="this.onerror=null;this.src='{{$cart->image}}';">
                </div>
                <div>
                    <a href="/event/{{$cart->event_id}}/detail">
                        <div class="cart-title txt-green">{{$cart->name}}</div>
                    </a>
                    <div>Rp{{number_format($cart->price, 0, "", ".")}}</div>
                    <div class="fa fa-ticket-alt"></div> {{$cart->quantity}}
                </div>
            </div>
            <hr class="line">
            @endforeach
        </div>
        <div class="cart-right">
            <label for="code">Promo Code:</label>
            <input name="code" type="text" id="code"></input>
            <button class="btn btn-success" onclick="checkPromoCode()" type="submit">
                Use Code
            </button>
            <div class="text-danger" id="not-found-promo">This promo code cannot be used</div>
            <div><b>Total</b></div>
            Rp<span id="total">{{number_format($total, 0, "", ".")}}</span>
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
                            <form action="/cart/event/checkout" method="POST">
                                {{csrf_field()}}
                                <input name="code" style="display: none;" id="input-code">
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
            Looks like there are no items in your cart, Check out more items <a class="txt-green" href="/event"><b>here</b></a> !
        </div>
    </div>

    @endif
</div>

<script>
    const checkPromoCode = () => {
        const code = document.getElementById("code").value;
        fetch(`http://localhost:8000/promo/check?code=${code}`, {
                method: "GET"
            })
            .then(e => e.json())
            .then(res => {
                const err = document.getElementById("not-found-promo");
                err.style.display = "none";
                err.innerText = "This promo code cannot be used";
                const inputCode = document.getElementById("input-code");
                inputCode.value = "";
                if (res.code) {
                    const err = document.getElementById("not-found-promo");
                    err.style.display = "block";
                    err.className = "txt-green";
                    err.innerText = "Success Used The Promo"
                    const totalTxt = document.getElementById("total");
                    const total = parseInt(<?= $total ?> - res.discount);
                    totalTxt.innerText = (total < 0 ? 0 : total).toLocaleString('en');
                    inputCode.value = res.code;
                } else {
                    const err = document.getElementById("not-found-promo");
                    if (res.message) {
                        err.innerText = res.message;
                    }
                    err.style.display = "block";
                    err.className = "text-danger";
                    const totalTxt = document.getElementById("total");
                    totalTxt.innerText = (<?= $total ?>).toLocaleString('en');
                }
            });
    };
</script>

@endsection