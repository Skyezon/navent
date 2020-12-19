@extends('base.vendor')
@section('main')
@if(session()->has('message'))
<div class="alert alert-success alert-green alert-dismissible">
    <a class="close txt-green" data-dismiss="alert" aria-label="close">&times;</a>
    {{ session()->get('message') }}
</div>
@endif

@error('quantity')
<div class="alert alert-danger alert-dismissible">
    <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
    {{ $message }}
</div>
@enderror
<div class="products-title text-center">My <span class="txt-green">Products</span>
</div>
<div class="product-type">
    <div>Filter By Product Type:</div>
    <select id="productType" onchange="changeProductType()">
        @foreach($types as $type)
        @if(isset($_GET['type_id']))
        @if($_GET['type_id'] == $type->id)
        <option value="{{$type->id}}" selected>{{$type->name}}</option>
        @else
        <option value="{{$type->id}}">{{$type->name}}</option>
        @endif
        @else
        <option value="{{$type->id}}">{{$type->name}}</option>
        @endif
        @endforeach
    </select>
    <a href="/products">
        <button class="btn submit-btn">
            Reset
        </button>
    </a>
    <a href="{{route('productAdd')}}">
        <button class="btn submit-btn">Add Product</button>
    </a>
</div>


<div class="container card-container">
    @if(count($products) ==0 )
    <div class="products-title text-center">Oops, Cannot Find any <span class="txt-green">Products</span>
        <img src="/assets/product-not-found.png">
        @else
        @foreach($products as $product)
        <div class="card">
            <a href="/product/{{$product->id}}/detail">
                <img class="card-img-top" src="{{env('APP_URL')}}:8000/uploads/image/product/{{$product->image}}" onerror="this.onerror=null;this.src='{{$product->image}}';">
            </a>
            <div class="card-body">
                <div class="card-body-left">
                    <a href="/product/{{$product->id}}/detail">
                        <h5 class="card-title"><b>{{$product->name}}</b></h5>
                    </a>
                    <a href="/products?type_id={{$product->type_id}}" class="card-type">{{$product->type_name}}</a>
                    <h3 class="card-text-price">Rp{{$product->price}}</h3>
                    <div class="d-inline"><span class="fa fa-star">
                        </span> {{$product->rating}}</div>
                </div>
                <div class="card-body-right">
                    <div class="d-flex flex-column">
                        <button class="btn d-flex flex-row prod-edit justify-content-center">
                            <a href="/product/{{$product->id}}">
                                Edit
                            </a>
                        </button>
                        <button class="btn d-flex flex-row prod-delete" data-toggle="modal" data-target="#product-delete-modal-{{$product->id}}">
                            Delete
                        </button>
                        <div class="modal fade" id="product-delete-modal-{{$product->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><b>Delete Product</b></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div><b>Do you want to delete this product?</b></div>
                                        <b>{{$product->name}}</b>
                                        <form action="/product/{{$product->id}}/delete" method="POST">
                                            {{ csrf_field() }}
                                            <button class="btn btn-danger" type="submit">
                                                Yes
                                            </button>
                                            <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @php
            $value = isset($product->quantity) ? $product->quantity: null;
            $text = $value != null ? "Update Cart": "Add to Cart";
            $qty = $value != null ? "In Cart (".$value.")" : null;
            @endphp
            <button type="button" class="btn submit-btn" data-toggle="modal" data-target="#product-modal-{{$product->id}}">
                See Details {{$qty}}
            </button>
            <div class="modal fade" id="product-modal-{{$product->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><b>{{$product->name}}</b></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <b>Price: {{$product->price}}</b>
                            <div><b>{{$product->stock}}</b> Stock Left</div>
                            <div><b>Product description:</b></div>
                            {{$product->description}}
                            <br /><br />
                            @if($product->stock <= 0) <div class="text-danger">Sorry, this product is out of stock
                        </div>
                        @else
                        <form action="cart/product/{{$product->id}}" method="POST">
                            <div>Number of Products:</div>
                            {{ csrf_field() }}
                            <input type="number" value="{{$value}}" name="quantity">
                            <br /><br />
                            <button type="submit" class="btn btn-success">{{$text}}</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endforeach
</div>
<div class="d-flex justify-content-center">
    {{$products->links()}}
    @endif
</div>


@endsection