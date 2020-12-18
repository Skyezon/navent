@extends('base.vendor')
@section('main')

@php
$province = $user->province;
$cities = App\Constants\Location::LOCATION[$province];
$city = $user->city;
@endphp

<div class="add-product-container">
    <div class="text-lg-center add-product-title">Edit <span class="txt-green">Profile</span>
    </div>
    <form class="container" action="/organizer/edit" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form__group field">
            <input type="input" class="form__field" value="{{$user->name}}" placeholder="Name" name="name" id='name' />
            <label for="name" class="form__label">Name</label>
        </div>
        @error('name')
        <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
        @enderror

        <div class="form__group field">
            <input type="input" class="form__field" value="{{$user->email}}" placeholder="Email" name="email" id='email' />
            <label for="email" class="form__label">Email</label>
        </div>
        @error('email')
        <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
        @enderror

        <div class="form__group field">
            <input type="input" class="form__field" value="{{$user->phone_number}}" placeholder="Phone Number" name="phone" id='phone' />
            <label for="phone" class="form__label">Phone Number</label>
        </div>
        @error('phone')
        <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
        @enderror

        <div class="form__group field">
            <input type="password" class="form__field" placeholder="New Password" name="password" id='password' />
            <label for="password" class="form__label">New Password <span class="text-danger">*Optional</span></label>
        </div>

        @error('password')
        <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
        @enderror

        <div class="form__group field">
            <input type="file" class="form__field" value="{{$user->image}}" placeholder="Image" name="image" id='image' />
            <label for="image" class="form__label">Image</label>
        </div>
        @error('image')
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

        <button type="submit" class="btn submit-btn">Submit</button>
    </form>

    @endsection