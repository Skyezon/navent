@extends('layouts.app')

@section('content')

<div class="container">
    <div>
        <h3 class="mb-4">
            Featured Events
        </h3>
        <div class="glide">
            <div class="glide__arrows" data-glide-el="controls">
                <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><</button>
                <button class="glide__arrow glide__arrow--right" data-glide-dir=">">></button>
            </div>
            <div data-glide-el="track" class="glide__track">
                <ul class="glide__slides">
                    @foreach($datas as $data)
                        <li class="glide__slide">
                            <div class="card" style="width: 18rem;">
                                <img class="card-img-top" src="{{$data->image}}" alt="Card image cap">
                                <div class="card-body bg-navbar">
                                    <h5 class="card-title font-weight-bold">{{$data->name}}</h5>
                                    <div class="d-flex justify-content-around">
                                        <div class="d-flex">
                                            <span>{{$data->city}}</span>
                                        </div>
                                        <div class="d-flex">
                                            <span>Rp. {{$data->price}}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex  flex-column justify-content-around">
                                        <div class="d-flex my-3 justify-content-center align-items-center">
                                            <span>Slot : </span>
                                            <span>{{$data->slot}}</span>
                                        </div>
                                        <a href="{{route('eventDetail',$data->id)}}" class="btn btn-primary">
                                            See event details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @foreach($types as $typeIndex => $type)
        <div>
           <h4 class="mb-4">
               {{$type->name}}
           </h4>
            <div class="glidesel glidesel-{{$typeIndex}}">
             <div data-glide-el="track" class="glide__track">
                    <ul class="glide__slides">
                        @foreach(DB::table('events')->where('type_id',$type->id)->get() as $data)
                            <li class="glide__slide">
                                <div class="card text-center" style="width: 18rem;">
                                    <img class="card-img-top" src="{{$data->image}}" alt="Card image cap">
                                    <div class="card-body bg-navbar">
                                        <h5 class="card-title font-weight-bold">{{$data->name}}</h5>
                                        <div class="d-flex justify-content-around">
                                            <div class="d-flex">
                                                <span>{{$data->city}}</span>
                                            </div>
                                            <div class="d-flex">
                                                <span>Rp. {{$data->price}}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex  flex-column justify-content-around">
                                            <div class="d-flex my-3 justify-content-center align-items-center">
                                                <span>Slot : </span>
                                                <span>{{$data->slot}}</span>
                                            </div>
                                            <a class="btn btn-primary" href="{{route('eventDetail',$data->id)}}">
                                                See event details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
