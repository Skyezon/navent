@extends('base.vendor')
@section('main')

@if(session()->has('message'))
<div class="alert alert-success alert-green alert-dismissible">
    <a class="close txt-green" data-dismiss="alert" aria-label="close">&times;</a>
    {{ session()->get('message') }}
</div>
@endif


@php
$selectedProv = isset($_GET['province']) ? $_GET['province'] : $provinces[0];
$cities = App\Constants\Location::LOCATION[$selectedProv];
$selectedCity = isset($_GET['city']) ? $_GET['city'] : null;
@endphp

<div class="container d-flex justify-content-center flex-column promo-container">
    <div class="products-title text-center">My <span class="txt-green">Events</span>
    </div>
    <h2>Search by location</h2>
    <div class="form__group field">
        <label for="province" class="form__label">Province</label>
        <select id="province" name="province" onchange="getCities()" class="form__field">
            @foreach($provinces as $prov)
            @if($selectedProv == $prov)
            <option value="{{$prov}}" selected="true">{{$prov}}</option>
            @else
            <option value="{{$prov}}">{{$prov}}</option>
            @endif
            @endforeach
            <option value="">Select All Provinces</option>
        </select>
    </div>
    <div class="form__group field">
        <label for="city" class="form__label">City</label>
        <select id="city" name="city" class="form__field">
            @if($cities != null)
            @foreach($cities as $city)
            @if($selectedCity == $city)
            <option value="{{$city}}" selected="true">{{$city}}</option>
            @else
            <option value="{{$city}}">{{$city}}</option>
            @endif
            @endforeach
            @endif
            @if($selectedCity == "")
            <option value="" selected="true">Select All Cities</option>
            @else
            <option value="">Select All Cities</option>
            @endif
        </select>
    </div>
    <button type="submit" class="btn submit-btn" onclick="setLocationParams()">Search</button>

    <div class="event-type">
        <div>Filter By Event Type:</div>
        <select id="eventType" onchange="changeEventType()">
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
        <a href="/event">
            <button class="submit-btn">
                Reset
            </button>
        </a>
    </div>
    <a href="/event/add">
        <button class="btn submit-btn">Add Event</button>
    </a>
    @if(count($events) ==0)
    <div class="products-title text-center">Oops, Cannot Find any <span class="txt-green">Events</span>
        <img src="/assets/product-not-found.png">
        @else
        @foreach($events as $event)
        <div class="container card-event">
            <div class="d-flex flex-row">
                <a href="/event/{{$event->id}}/detail">
                    <img src="{{$event->image}}" class="event-image">
                </a>
                <div class="event-container">
                    <a href="/event/{{$event->id}}/detail">
                        <div class="event-name">{{$event->name}}</div>
                    </a>
                    <div>
                        Organized By: <a href="/organizer/{{$event->organizer_id}}" class="txt-green">
                            <h4>{{$event->organizer_name}}</h4>
                        </a>
                    </div>
                    <div class="event-cat">Category: <a href="/event?type_id={{$event->type_id}}" class="card-type">{{$event->type_name}}</a></div>
                    <div class="d-flex flex-row event-date align-items-center">
                        <span class="fa fa-clock"></span>
                        <div>{{Carbon\Carbon::parse($event->date_start)->toDayDateTimeString()}} -
                            {{Carbon\Carbon::parse($event->date_end)->toDayDateTimeString()}}</div>
                    </div>
                    <div class="d-flex flex-row event-location align-items-center">
                        <span class="fa fa-map-marker-alt"></span>
                        <div>{{$event->city}}, {{$event->province}}</div>
                    </div>
                    <button type="button" class="btn event-btn submit-btn" data-toggle="modal" data-target="#event-modal-{{$event->id}}">
                        See Details
                    </button>
                    <div class="modal fade" id="event-modal-{{$event->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><b>{{$event->name}}</b></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <b>Price: {{$event->price == 0 ? "Free": $event->price}}</b>
                                    <div><b>Slot: {{$event->slot}}</b></div>
                                    <div><b>Address:</b></div>
                                    <div>{{$event->address}}</div>
                                    <div><b>Description:</b></div>
                                    {{$event->description}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn d-flex flex-row prod-edit justify-content-center">
                        <a href="/event/edit/{{$event->id}}">
                            Edit
                        </a>
                    </button>
                    <button class="btn d-flex flex-row prod-delete" data-toggle="modal" data-target="#event-delete-modal-{{$event->id}}">
                        Delete
                    </button>
                    <div class="modal fade" id="event-delete-modal-{{$event->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><b>Delete Event</b></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div><b>Do you want to delete this event?</b></div>
                                    <b>{{$event->name}}</b>
                                    <form action="/event/{{$event->id}}/delete" method="POST">
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

        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        {{$events->links()}}
    </div>
    @endif
    @endsection