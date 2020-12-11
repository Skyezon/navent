@extends('base.vendor')
@section('main')
<div class="add-product-container">
    <div class="text-lg-center add-product-title">Add <span class="txt-green">Product</span>
    </div>
    <form class="container" target="/product/add" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form__group field">
            <input type="input" class="form__field" placeholder="Name" name="name" id='name' />
            <label for="name" class="form__label">Name</label>
        </div>
        @error('name')
        <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
        @enderror
        <div class="form__group field">
            <input type="number" class="form__field" placeholder="Price" name="price" id='price' />
            <label for="price" class="form__label">Price</label>
        </div>

        @error('price')
        <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
        @enderror

        <div class="form__group field">
            <input type="number" class="form__field" placeholder="Stock" name="stock" id='stock' />
            <label for="stock" class="form__label">Stock</label>
        </div>
        @error('stock')
        <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
        @enderror

        <div class="form__group field">
            <input type="text" class="form__field" placeholder="Description" name="desc" id='desc' />
            <label for="desc" class="form__label">Description</label>
        </div>
        @error('desc')
        <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
        @enderror

        <div class="form__group field">
            <input type="file" class="form__field" placeholder="Image" name="image" id='image' />
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
                <option value="{{$productType->id}}">{{$productType->name}}</option>
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