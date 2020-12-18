@extends('base.vendor')
@section('main')

@php
$name = isset($event) ? $event->name : null;
$type = isset($event) ? $event->type : null;
$price = isset($event) ? $event->price : null;
$image = isset($event) ? $event->image : null;
$address = isset($event) ? $event->address : null;
$province = isset($event) ? $event->province : $provinces[0];
$cities = App\Constants\Location::LOCATION[$province];
$dateStart = isset($event) ? date("Y-m-d\TH:i", strtotime($event->date_start )): null;
$dateEnd = isset($event) ? date("Y-m-d\TH:i", strtotime($event->date_end )): null;
$city = isset($event) ? $event->city : null;
$slot = isset($event) ? $event->slot : null;
$desc = isset($event) ? $event->description : null;

$endpoint = isset($id) ? "/event/".$id : "/event";
$actions = isset($promo) ? "Edit" : "Add";
@endphp

<div class="add-product-container">
    <div class="text-lg-center add-product-title">{{$actions}} <span class="txt-green">Event</span>
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
            <label for="type" class="form__label">Event Type</label>
            <select id="type" name="type" class="form__field">
                @foreach($types as $t)
                @if($t->id == $type)
                <option value="{{$t->id}}" selected="true">{{$t->name}}</option>
                @else
                <option value="{{$t->id}}">{{$t->name}}</option>
                @endif
                @endforeach
            </select>
        </div>
        @error('type')
        <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
        @enderror

        <div class="form__group field">
            <input type="number" class="form__field" value="{{$slot}}" placeholder="slot" name="slot" id='slot' />
            <label for="slot" class="form__label">Slot</label>
        </div>
        @error('slot')
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
            <input type="text" class="form__field" value="{{$desc}}" placeholder="Description" name="desc" id='desc' />
            <label for="desc" class="form__label">Description</label>
        </div>
        @error('desc')
        <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
        @enderror

        <div class="form__group field">
            <label for="province" class="form__label">Province</label>
            <select id="province" name="province" onchange="getCities()" class="form__field">
                @foreach($provinces as $prov)
                @if($prov == $province)
                <option value="{{$prov}}" selected="true">{{$prov}}</option>
                @else
                <option value="{{$prov}}">{{$prov}}</option>
                @endif
                @endforeach
            </select>
        </div>
        @error('province')
        <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
        @enderror

        <div class="form__group field">
            <label for="city" class="form__label">City</label>
            <select id="city" name="city" class="form__field">
                @foreach($cities as $ct)
                @if($ct == $city)
                <option value="{{$ct}}" selected="true">{{$ct}}</option>
                @else
                <option value="{{$ct}}">{{$ct}}</option>
                @endif
                @endforeach
            </select>
        </div>
        @error('city')
        <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
        @enderror

        <div class="form__group field">
            <input type="input" class="form__field" value="{{$address}}" placeholder="Address" name="address" id='address' />
            <label for="address" class="form__label">Address</label>
        </div>
        @error('address')
        <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
        @enderror
        <div class="form__group field">
            <label for="dateStart" class="form__label">Time Start</label>
            <input type="datetime-local" class="form__field" value="{{$dateStart}}" name="dateStart" id='dateStart' />
        </div>
        @error('dateStart')
        <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
        @enderror

        <div class="form__group field">
            <label for="dateEnd" class="form__label">Time End</label>
            <input type="datetime-local" class="form__field" value="{{$dateEnd}}" name="dateEnd" id='dateEnd' />
        </div>
        @error('dateEnd')
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
        <button type="submit" class="btn submit-btn">Submit</button>
    </form>
</div>

@endsection