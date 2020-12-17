@extends('base.vendor')
@section('main')

Use Promo Code: <div class="txt-green">{{$promo->code}}</div> to get {{$promo->discount}} discount on event ticket and share with your friends!
@endsection