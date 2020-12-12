@extends('base.vendor')
@section('main')
@if(session()->has('message'))
<div class="alert alert-success alert-dismissible">
    <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
    {{ session()->get('message') }}
</div>
@endif
<div class="products-title text-center">My <span class="txt-green">Products</span>
</div>
<div class="container card-container">
    @foreach($products as $product)
    <div class="card">
        <img class="card-img-top" src="{{env('APP_URL')}}:8000/uploads/image/product/{{$product->image}}" onerror="this.onerror=null;this.src='{{$product->image}}';">
        <div class="card-body">
            <div class="card-body-left">
                <h5 class="card-title"><b>{{$product->name}}</b></h5>
                <a href="/products/type/{{$product->type_id}}" class="card-type">{{$product->type_name}}</a>
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
        <button type="button" class="btn submit-btn" data-toggle="modal" data-target="#product-modal-{{$product->id}}">
            See Description
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
                        <div><b>Product description:</b></div>
                        {{$product->description}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endforeach
</div>
<div class="d-flex justify-content-center">
    {{$products->links()}}
</div>


@endsection