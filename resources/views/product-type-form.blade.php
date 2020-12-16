@extends('base.vendor')
@section('main')
@php
$name = isset($type) ? $type->name : null;

$endpoint = isset($id) ? "/product/type/".$id : "/product/type";
$action = isset($type) ? "Edit" : "Add";
@endphp


<div class="add-product-container">
    <div class="text-lg-center add-product-title">{{$action}} <span class="txt-green">Product Type</span>
    </div>
    <form class="container" action="{{$endpoint}}" method="POST">
        {{csrf_field()}}
        <div class="form__group field">
            <input type="input" class="form__field" value="{{$name}}" placeholder="Promo Code" name="name" id='name' />
            <label for="name" class="form__label">Type Name</label>
        </div>
        @error('name')
        <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
        @enderror

        <button type="submit" class="btn submit-btn">Submit</button>
    </form>

</div>
@endsection