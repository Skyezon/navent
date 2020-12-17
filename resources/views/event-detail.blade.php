@extends('base.vendor')
@section('main')
@php
$value = isset($event->quantity) ? $event->quantity: null;
$text = $value != null ? "Update Cart": "Add to Cart";
@endphp
<div class="modal-header">
    <h5 class="modal-title"><b>{{$event->name}}</b></h5>
</div>
<div class="modal-body d-flex flex-direction-row">
    <a href="/organizer/{{$event->organizer_id}}">
        <img class="prod-det-image" src="{{env('APP_URL')}}:8000/uploads/image/event/{{$event->image}}" onerror="this.onerror=null;this.src='{{$event->image}}';">
    </a>
    <div>
        <b>Price: Rp{{$event->price}}</b>
        <div><b>{{$event->slot}}</b> Slot Left</div>
        <div><b>Event description:</b></div>
        {{$event->description}}
        <br /><br />
        <div>
            Organized By: <a href="/organizer/{{$event->organizer_id}}" class="txt-green">
                <h4>{{$event->organizer_name}}</h4>
            </a>
        </div>
        <div>
            <div>Address:</div>
            <h3>{{$event->address}}</h3>
        </div>
        <div class="event-cat">Category: <a href="/events/type/{{$event->type_id}}" class="card-type">{{$event->type_name}}</a></div>
        <div class="d-flex flex-row event-date align-items-center">
            <span class="fa fa-clock"></span>
            <div>{{Carbon\Carbon::parse($event->date_start)->toDayDateTimeString()}} -
                {{Carbon\Carbon::parse($event->date_end)->toDayDateTimeString()}}</div>
        </div>
        <div class="d-flex flex-row event-location align-items-center">
            <span class="fa fa-map-marker-alt"></span>
            <div>{{$event->city}}, {{$event->province}}</div>
        </div>
        @if($event->slot <= 0) <div class="text-danger">Sorry, this event is full
    </div>
    @elseif(strtotime($event->date_end) < time()) <div class="text-danger">
        <h1>
            Sorry, this event has ended {{\Carbon\Carbon::createFromTimeStamp(strtotime($event->date_end))->diffForHumans()}}
        </h1>
</div>
@else
<form action="/cart/event/{{$event->id}}" method="POST">
    <div>Number of Tickets:</div>
    {{ csrf_field() }}
    <input type="number" value="{{$value}}" name="quantity">
    @error('quantity')
    <span class="error-message" role="alert">
        <div class="text-danger">{{ $message }}</div>
    </span>
    @enderror
    <br /><br />
    <button type="submit" class="btn btn-success">{{$text}}</button>
</form>
@endif
<h2>Location</h2>
<iframe src="https://www.google.com/maps/d/embed?mid=1kwDQeFXAW-Agnlr7bL9exoTE6iACOcvn" width="640" height="480"></iframe>
</div>
@endsection