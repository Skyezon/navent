<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navent</title>
    <link href="{{asset('/css/app.css')}}" rel="stylesheet">
    <link href="{{asset('/css/vendor.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="{{asset('/js/app.js')}}"></script>
</head>

<body>
    <nav class="navbar nav navbar-expand-lg">
        <a class="navbar-brand text-light font-weight-bold" href="#">Navent</a>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <a class="nav-link text-light" href="/products">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="#">Pricing</a>
                </li>
                <!-- if vendor search product, if member search event and category -->
                <form class="search-bar" action="/" method="GET">
                    <input type="text" name="query" onkeyup="searchEvent()" class="search-input" id="product-search" placeholder="Search">
                    <button class="search-button" type="submit"><i class="fas fa-search"></i></button>
                </form>
                <div class="result" id="result">
                </div>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Profile
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" data-toggle="modal" data-target="#referral-code">Get Code Referral</a>
                        <a class="dropdown-item" href="/profile/edit">Edit Profile</a>
                    </div>
                    <div class=" modal fade" id="referral-code" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><b>Your Referral Code</b></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                @if(Auth::check() && Auth::user()->memberId())
                                    @php
                                    $promo = App\Promo::where('event_members_id', Auth::user()->memberId())->first();
                                    @endphp
                                    <div class="modal-body">
                                        Use Promo Code: <h2 class="txt-green">{{$promo->code}}</h2> to get {{$promo->discount}} discount on event ticket and share with your friends!
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div>
        @yield('main')
    </div>

</body>


</html>
