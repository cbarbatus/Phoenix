<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-CTZCPCHVZ5"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-CTZCPCHVZ5');
    </script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> Phoenix Raven's Cry Grove, ADF</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!--
    <script>
        $(function() {
            $( "#accordion-1" ).accordion();
        });
    </script>

    <script src="https://kwes.io/js/kwes.js"></script>
    -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=cabin" rel="stylesheet">

    <!-- Styles -->
    <style>
        #accordion-1{font-size: 12px;}
    </style>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="{{ asset('css/rcg.css') }}" rel="stylesheet">

</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
            </a>
            <button class="navbar-toggler ms-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span >Menu</span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a  class="nav-link text-white" href="/"> Home </a>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/slideshows/0/list') }}"> Photos </a></li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/rituals/0/list') }}"> Past Rituals </a></li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/books') }}"> Books </a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Member Login') }}</a>
                        </li>
                    @else


                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu " aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                @role(['SeniorDruid', 'admin'])
                                $ SeniorDruid:
                                <a  class="dropdown-item" href="/rituals/1/list"> $ Rituals </a>
                                <a  class="dropdown-item" href="/announcements"> $ Announcements </a>
                                <a  class="dropdown-item" href="/schedule"> $ Schedule </a>
                                <a  class="dropdown-item" href="/venues"> $ Venues </a>
                                <a  class="dropdown-item" href="/books/list"> $ Books </a>
                                <a  class="dropdown-item" href="/contacts"> $ Contacts </a>
                                <a  class="dropdown-item" href="/slideshows/1/list"> $ Photos </a>
                                @endrole

                                @role('admin')
                                * Admin:
                                <a  class="dropdown-item" href="/books/list"> * Books </a>
                                <a  class="dropdown-item" href="/users"> * Users </a>
                                <a  class="dropdown-item" href="/sections"> * Sections </a>
                                <a  class="dropdown-item" href="/grove/upload"> * Upload </a>
                                <a  class="dropdown-item" href="/roles"> * Roles </a>

                                @endrole

                                @role('joiner')
                                <a  class="dropdown-item" href="/members/join"> Join Us! </a>
                                @endrole

                                @role('member')
                                Members Only:

                                <a  class="dropdown-item" href="/members"> Members </a>
                                <a  class="dropdown-item" href="/liturgy/find"> Liturgy </a>
                                <a  class="dropdown-item" href="/grove/bylaws"> Bylaws </a>
                                <a  class="dropdown-item" href="/grove/pay"> Pay Dues </a>
                                <a  class="dropdown-item" href="/votes"> Vote </a>
                                @endrole

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>

            </div>
        </div>
    </nav>

    <div class="startpad">
        <div class="content">
            @if (Session::has('message'))
                <div class="flash alert-info">
                    <p>{{ Session::get('message') }}</p>
                </div>
            @endif
            @if (Session::has('warning'))
                <div class="flash alert-danger">
                    <p>{{ Session::get('warning') }}</p>
                </div>
            @endif
            @if ($errors->any())
                <div class='flash alert-danger'>
                    @foreach ( $errors->all() as $error )
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <main class="py-4">
                <div class="container" >
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

