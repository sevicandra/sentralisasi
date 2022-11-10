<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/layout.css">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    @section('head')
        
    @show
    <title>SENTRALISASI</title>
</head>
<body>
    <header class="header">
        <div class="title">
            <a style="text-decoration: none;color:white" href="{{ config('app.url') }}">
                <span>ALIKA SENTRALISASI</span>
            </a>
        </div>
        <div class="profil dropdown">
            <img src="{{ session()->get('gravatar') }}" alt="" class="" style="border-radius: 50%; height:40px; width: 40px; object-fit:cover">
            <span class="profil-name">{{ session()->get('name') }}</span>
            <div class="dropdown-content">
                <a href="{{ config('app.url') }}/logout">
                    <img src="/img/ico/logout.png" alt="" height="25px">
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </header>
    <main class="main-body">
        @yield('content')
    </main>
</body>
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script src="/js/bootstrap.min.js"></script>
@section('footer')
        
@show
</html>