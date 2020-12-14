@extends('base.vendor')
@section('main')
@php
$code = isset($promo) ? $promo->code : null;
$discount = isset($promo) ? $promo->discount : null;

$endpoint = isset($id) ? "/promo/".$id : "/promo";
$action = isset($promo) ? "Edit" : "Add";
@endphp


<div class="add-product-container">
    <div class="text-lg-center add-product-title">{{$action}} <span class="txt-green">Product</span>
    </div>
    <form class="container" action="{{$endpoint}}" method="POST">
        {{csrf_field()}}
        <div class="form__group field">
            <input type="input" class="form__field" value="{{$code}}" placeholder="Promo Code" name="code" id='code' />
            <label for="code" class="form__label">Promo Code</label>
        </div>
        @error('code')
        <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
        @enderror
        <div class="form__group field">
            <input type="number" class="form__field" value="{{$discount}}" placeholder="Discount" name="discount" id='discount' />
            <label for="discount" class="form__label">Discount</label>
        </div>

        @error('discount')
        <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
        @enderror

        <button type="submit" class="btn submit-btn">Submit</button>
    </form>

</div>
@endsection