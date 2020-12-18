<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-white">
<div id="app">


    <main class="py-4">
        <div class="container">
            <div class="text-dark">
                <h1>Navent</h1>
                <h2>Hi, {{"nama resipein"}}</h2>
                <p>Pesanan tiket event Anda sudah dikonfirmasi, terlampir E-tiket Anda.
                    Ini bukti transaksi Anda
                    Terima kasih telah memilih Navent</p>
            </div>
           <div class="row bg-ticket-image">
                <div class="col-lg-9">
                    <div class="align-items-end d-flex text-right flex-column">
                        <h2 class="w-25 my-5">
                            {{"Event name"}}
                        </h2>
                        <h3 class="mt-3">
                            Date : {{"Event date"}}
                        </h3>
                        <h3 class="mt-5">
                            {{"Lokasi"}}
                        </h3>
                    </div>

                </div>
                <div style="transform: translateX(30px)" class="col-lg-3 text-center d-flex flex-column justify-content-around mx-auto">
                    <div>Ticket id : {{"ticket/order id"}} </div>
                    <div>{{"Event name"}}</div>
                    <div>{{"Event location"}}</div>
                    <div>{{"Event start date"}}</div>
                </div>
            </div>
        </div>

    </main>
</div>
</body>
</html>
