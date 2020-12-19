@extends('base.vendor')
@section('main')
@if(session()->has('message'))
<div class="alert alert-success alert-green alert-dismissible">
    <a class="close txt-green" data-dismiss="alert" aria-label="close">&times;</a>
    {{ session()->get('message') }}
</div>
@endif

<div class="container d-flex justify-content-center flex-column promo-container">
    <div class="products-title">Promo <span class="txt-green">Code</span>
    </div>
    <a href="/promo/add">
        <button class="btn submit-btn">Add Promo</button>
    </a>

    <table class="promo-table">
        <tr class="promo-head">
            <th class="head-first text-center">Id</th>
            <th class="text-center">Promo Code</th>
            <th class="text-center">Discount</th>
            <th class="head-last text-center">Actions</th>
        </tr>

        @foreach($promos as $promo)
        <tr class="promo-body">
            <th>{{$promo->id}}</th>
            <th>{{$promo->code}}</th>
            <th>Rp{{$promo->discount}}</th>
            <th>
                <div class="d-flex flex-row align-items-center justify-content-center action-promo">
                    <a href="/promo/edit/{{$promo->id}}"><button class="btn prod-edit">Edit</button></a>
                    <button class="btn prod-delete" data-toggle="modal" data-target="#promo-modal-{{$promo->id}}">
                        Delete</button>
                    <div class="modal fade" id="promo-modal-{{$promo->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><b>Delete Promo</b></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <b>Promo Code: <span class="txt-green">{{$promo->code}}</span></b>
                                    <form action="/promo/{{$promo->id}}/delete" method="POST">
                                        {{csrf_field()}}
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
            </th>
        </tr>
        @endforeach
    </table>

</div>
<div class="d-flex justify-content-center">
    {{$promos->links()}}
</div>
@endsection