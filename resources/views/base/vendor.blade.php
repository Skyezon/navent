<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navent</title>
    <link href="/css/app.css" rel="stylesheet">
    <script src="/js/app.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand text-light font-weight-bold" href="#">Navent</a>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-light" href="/products">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="#">Pricing</a>
                </li>
            </ul>
        </div>
    </nav>
    <div>
        @yield('main')
    </div>

</body>


</html>