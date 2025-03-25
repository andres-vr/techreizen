<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
   
    <div class= "fixed-top" style="z-index: 100">
        <div class="d-flex flex-row bg-light">
            <div class="p-2"> <img src="{{ asset('images/ucll_logo.png') }}" class="rounded" alt="logo ucll"></div>
            <div class="d-flex flex-column">
                <div class="pt-3">
                    <h1 class="text-danger">TECHNOLOGIE</h1>
                </div>
                <div class="pb-1">
                    <h3 class="text-success">internationalisering - studiereizen</h3>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}" 
                style="padding: 5px; color: black; white-space: nowrap; display: inline-block;">
                 Home
             </a>
             <a class="navbar-brand" href="{{ url('/home') }}" 
             style="padding: 5px; color: black; white-space: nowrap; display: inline-block;">
              Voorbeeldreis
          </a>
          <a class="navbar-brand" href="{{ url('/home') }}" 
          style="padding: 5px; color: black; white-space: nowrap; display: inline-block;">
           Contact
       </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    
                    
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div class = "row justify-content-center">
            <div class="text-center">
                <div id="images" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <!-- slideshow images -->
                    <div class="carousel-inner mx-auto">
                        <div class="carousel-item active">
                            <img src="{{ asset('images/header1.jpg') }}" class="img-fluid " alt="header 1">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/header2.jpg') }}" class="img-fluid " alt="header 2">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/header3.jpg') }}" class="img-fluid " alt="header 2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <main class="py-4">
            {{ $slot }}
        </main>
    </div>

