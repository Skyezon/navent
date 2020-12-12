@extends('base.vendor')
@section('main')


@php
$name = isset($product) ? $product->name : null;
$price = isset($product) ? $product->price : null;
$stock = isset($product) ? $product->stock : null;
$desc = isset($product) ? $product->description : null;
$type = isset($product) ? $product->type_id : $productTypes[0]->id;
$image = isset($product) ? $product->image : null;

$endpoint = isset($id) ? "/product/".$id : "/product";
$action = isset($product) ? "Edit" : "Add";
@endphp


<div class="add-product-container">
    <div class="text-lg-center add-product-title">{{$action}} <span class="txt-green">Product</span>
    </div>
    <form class="container" action="{{$endpoint}}" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form__group field">
            <input type="input" class="form__field" value="{{$name}}" placeholder="Name" name="name" id='name' />
            <label for="name" class="form__label">Name</label>
        </div>
        @error('name')
        <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
        @enderror
        <div class="form__group field">
            <input type="number" class="form__field" value="{{$price}}" placeholder="Price" name="price" id='price' />
            <label for="price" class="form__label">Price</label>
        </div>

        @error('price')
        <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
        @enderror

        <div class="form__group field">
            <input type="number" class="form__field" value="{{$stock}}" placeholder="Stock" name="stock" id='stock' />
            <label for="stock" class="form__label">Stock</label>
        </div>
        @error('stock')
        <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
        @enderror

        <div class="form__group field">
            <input type="text" class="form__field" value="{{$desc}}" placeholder="Description" name="desc" id='desc' />
            <label for="desc" class="form__label">Description</label>
        </div>
        @error('desc')
        <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
        @enderror

        <div class="form__group field">
            <input type="file" class="form__field" value="{{$image}}" placeholder="Image" name="image" id='image' />
            <label for="image" class="form__label">Image</label>
        </div>
        @error('image')
        <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
        @enderror

        <div class="form__group field">
            <label for="type" class="form__label">Product Type</label>
            <select id="type" name="type" class="form__field">
                @foreach($productTypes as $productType)
                @if($productType->id == $type)
                <option value="{{$productType->id}}" selected="true">{{$productType->name}}</option>
                @else
                <option value="{{$productType->id}}">{{$productType->name}}</option>
                @endif
                @endforeach
            </select>
        </div>
        @error('type')
        <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
        @enderror

        <button type="submit" class="btn submit-btn">Submit</button>
    </form>

</div>
@endsection