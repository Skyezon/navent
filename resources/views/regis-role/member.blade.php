@extends('base.vendor')
@section('main')

    <div class="add-product-container">
        <div class="text-lg-center add-product-title">Register as <span class="txt-green">Member</span>
        </div>
        <form class="container" action="{{route('roleRegisMember')}}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form__group field">
                <input type="input" class="form__field" value="{{old('name')}}" placeholder="Name" name="name" id='name' />
                <label for="name" class="form__label">Name</label>
            </div>
            @error('name')
            <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
            @enderror

            <div class="form__group field">
                <input type="input" class="form__field" value="{{old('email')}}" placeholder="Email" name="email" id='email' />
                <label for="email" class="form__label">Email</label>
            </div>
            @error('email')
            <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
            @enderror

            <div class="form__group field">
                <input type="input" class="form__field" value="{{old('phone')}}" placeholder="Phone Number" name="phone" id='phone' />
                <label for="phone" class="form__label">Phone Number</label>
            </div>
            @error('phone')
            <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
            @enderror

            <div class="form__group field">
                <input type="password" class="form__field" placeholder="Password" name="password" id='password' />
                <label for="password" class="form__label">Password </label>
            </div>

            <div class="form__group field">
                <input id="password-confirm" type="password" name="password_confirmation" placeholder="password confirmation" required autocomplete="new-password" class="form__field">
                <label for="password-confirm" class="form__label">{{ __('Confirm Password') }}</label>
            </div>

            @error('password')
            <span class="error-message" role="alert">
            <div class="text-danger">{{ $message }}</div>
        </span>
            @enderror
            <button type="submit" class="btn submit-btn">Submit</button>
        </form>

@endsection
