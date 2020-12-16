@extends('base.vendor')
@section('main')
@if(session()->has('message'))
<div class="alert alert-success alert-green alert-dismissible">
    <a class="close txt-green" data-dismiss="alert" aria-label="close">&times;</a>
    {{ session()->get('message') }}
</div>
@endif

<div class="container d-flex justify-content-center flex-column promo-container">
    <div class="products-title">Event <span class="txt-green">Type</span>
    </div>
    <a href="/event/type/add">
        <button class="btn submit-btn">Add Event Type</button>
    </a>

    <table class="promo-table">
        <tr class="promo-head">
            <th class="head-first text-center">Id</th>
            <th class="text-center">Event Type</th>
            <th class="head-last text-center">Actions</th>
        </tr>

        @foreach($types as $type)
        <tr class="promo-body">
            <th>{{$type->id}}</th>
            <th>{{$type->name}}</th>
            <th>
                <div class="d-flex flex-row align-items-center justify-content-center action-promo">
                    <a href="/event/type/edit/{{$type->id}}"><button class="btn prod-edit">Edit</button></a>
                    <button class="btn prod-delete" data-toggle="modal" data-target="#event-type-modal-{{$type->id}}">
                        Delete</button>
                    <div class="modal fade" id="event-type-modal-{{$type->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><b>Delete Event Type</b></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <b>Event Type: <span class="txt-green">{{$type->name}}</span></b>
                                    <form action="/event/type/{{$type->id}}/delete" method="POST">
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
    {{$types->links()}}
</div>
@endsection