<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Minut</title>
<link rel="icon" href="{{asset('/storage/image/icon.png')}}" type="image/icon type">

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">


<link type="text/css" rel="stylesheet" href="{{asset('/storage/css/sidebar.css')}}" />
<script type="text/javascript" src="{{asset('/storage/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/storage/js/printThis.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.8/jquery.jgrowl.min.js" integrity="sha512-h77yzL/LvCeAE601Z5RzkoG7dJdiv4KsNkZ9Urf1gokYxOqtt2RVKb8sNQEKqllZbced82QB7+qiDAmRwxVWLQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{{asset('/storage/js/datatables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/storage/js/basic.js')}}"></script>

<script type="text/javascript" src="{{asset('/storage/js/extensions/fixed_columns.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/storage/js/extensions/col_reorder.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/storage/js/extensions/buttons.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('/storage/css/icons/icomoon/styles.min.css')}}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css" integrity="sha384-wESLQ85D6gbsF459vf1CiZ2+rr+CsxRY0RpiF1tLlQpDnAgg6rwdsUF1+Ics2bni" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">

</head>

<body>

    <div id="app">
        <nav class="navbar navbar-expand-md shadow-sm nav">
            <div class="container d-flex">
                @if(Auth::user())
                <div id="sidebar" class="d-flex justify-content-end" style="flex-grow:8;">
                    <a href="{{ route('groups.index') }}" style="color:{{Route::is('groups.index')?'black':'white'}}">{{ __('sidebar.group') }}</a>
                    <a href="">{{ __('sidebar.friend') }}</a>
                    <a href="">{{ __('sidebar.schedule') }}</a>
                </div>
                @endif
                <div class="collapse navbar-collapse" id="" style="flex-grow:4">
                    <!-- Left Side Of Navbar -->
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

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
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
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
        <script>


        </script>
        @if(session()->has('message'))
        <div class="alert alert-success" style="position:block;width:100%">
            <script>
                swal("{{ session()->get('message') }}", "", "success");
            </script>

        </div>
        @endif

        @if(session()->has('error'))
        <div class="alert alert-danger" style="position:block;width:100%">
            <script>
                swal("{{ session()->get('error') }}", "", "error");
            </script>

        </div>
        @endif
        <main>
            <!-- Page Content -->
            <div id="page-content-wrapper">

                @yield('content')
            </div>
    </div>
    </div>


    </main>
    </div>
</body>
<script>
    $(document).ready(function() {
        $('.alert').fadeIn().delay(1000).fadeOut();
    });
</script>

</html>