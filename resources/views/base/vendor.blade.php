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
            </ul>
        </div>
    </nav>
    <div>
        @yield('main')
    </div>

</body>


</html>
