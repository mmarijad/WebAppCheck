<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Web App Check') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
<style>

  body { 
    letter-spacing: .1rem;
  }  
         
  a {
        color: #636b6f;
        font-size: 13px;
        text-decoration: none;
    }

 a:hover {
        color: #000;
        }

  .current-link {
   background: rgba(153, 201, 167,.2);
}

#djelheaderWrapper{
	position: relative;
	padding:0;
	margin:0;
	overflow: hidden;
	height: 200px;
	background-image: url('https://cdn.hipwallpaper.com/i/36/82/akl5Gg.jpg');
	background-repeat: no-repeat;
	background-size: 100% 600px; 
	background-position: top center;
	background-attachment: fixed;
	text-align: center;
	color: white;
    text-shadow: 3px 3px 6px #000000;
	font-size: 500%;
}
  td{
    white-space: nowrap;
}
 </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md shadow-sm" style="  background-image: linear-gradient(to right,  #00cc99 , #ddffcc); height: 120px;">
            <div class="container">
                <a class="navbar-brand" style="color: #fff; height:40px; font-size:30px;" href="{{ url('/') }}">
                   <b> {{ config('app.name', 'Laravel') }} </b>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"  ><a class="nav-link" href="{{ route('apps')}}" style="color: #fff; height:40px; font-size:20px;">Naslovnica</a></li>
                        <li class="nav-item"  ><a class="nav-link" href="#" style="color: #fff; height:40px; font-size:20px;">Povijest aplikacije</a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Odjava') }}
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
        <br><br>
        <div class="container-fluid" style="margin: 20px; ">

           @yield('sadrzaj')
</div>

</body>
</html>
