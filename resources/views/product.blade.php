@extends('base.vendor')
@section('main')
@if(session()->has('message'))
<div class="alert alert-success alert-dismissible">
    <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
    {{ session()->get('message') }}
</div>
@endif

@endsection