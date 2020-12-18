<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Navent</title>
</head>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<style>
    .bg-dark {
        background-color: #343a40 !important;
    }

    .mw-100 {
        max-width: 100% !important;
    }

    .container {

        padding-right: 15px;
        padding-left: 15px;
        width: 100%;
        margin-right: auto;
        margin-left: auto;
    }

    .text-white {
        color: #fff !important;
    }

    main {
        font-family: 'Poppins', sans-serif;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }

    .txt-green {
        color: #6ce779;
    }

    .mt-2,
    .my-2 {
        margin-top: 0.5rem !important;
    }

    .mt-3,
    .my-3 {
        margin-top: 1rem !important;
    }

    #app {
        padding: 3rem 4rem;
        border: 2px solid #161b22;
    }

    .bg-ticket-image {
        background-color: white;
    }

    .ticket-header {
        background-color: #6ce779;
        font-size: 2rem;
        width: 102%;
        margin-left: -0.9rem;
    }
</style>

<body class="bg-dark mw-100" style="height:150vh;">
    <div id="app">
        <main class="py-4 container">
            <div class="container">
                <div class="text-white">
                    <h1 class="txt-green">Navent</h1>
                    <h2>Hi, {{$transaction->member_name}}</h2>
                    <h3>Your ticket purchase has been confirmed, Here is your ticket. Thank you for choosing Navent and enjoy your event!</h3>
                </div>

                <div class="ticket-header">This Ticket Issued By Navent</div>
                <div class="row bg-ticket-image">
                    <div class="col-lg-9">
                        <div class="align-items-end d-flex text-right flex-column" style="display: flex;flex-direction:column;padding: 2rem">
                            <h2 class="w-25 my-5 h1">
                                {{$transaction->name}}
                            </h2>
                            <h3 class="mt-2">
                                Date :
                                {{Carbon\Carbon::parse($transaction->date_start)->toDayDateTimeString()}}
                            </h3>
                            <h3 class="mt-3">
                                Location: {{$transaction->city}}, {{$transaction->province}}
                            </h3>
                            <h3 class="mt-3">
                                {{$transaction->address}}
                            </h3>
                        </div>

                    </div>
                    <div style="transform: translateX(30px)" class="col-lg-3 text-center d-flex flex-column justify-content-around mx-auto">
                        <div>Ticket id : {{$transaction->id}} </div>
                        <div>{{$transaction->name}}</div>
                        <div style="margin-left:1rem;max-width: 30ch;">{{$transaction->address}}</div>
                        <div>{{Carbon\Carbon::parse($transaction->date_start)->toDayDateTimeString()}}</div>
                    </div>
                </div>
            </div>
            <h3 class="mt-3 text-white">
                Your event location can be seen here
            </h3>
            <iframe src="https://www.google.com/maps/d/embed?mid=1kwDQeFXAW-Agnlr7bL9exoTE6iACOcvn" width="640" height="480"></iframe>
            <hr class="line">
            <h3>Created by Navent</h3>
        </main>
    </div>
</body>

</html>