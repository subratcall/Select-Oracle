<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS -->
    <link href={{ asset('css/bootstrap.min.css') }} rel="stylesheet">
    <link href={{ asset('css/datatables.css') }} rel="stylesheet">
    <link href={{ asset('css/datatables_bootstrap.css') }} rel="stylesheet">
    <link href="{{ asset('css/stylee.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('/css/bootstrap-select.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/jquery-ui.css') }}">

    <link rel="stylesheet" href="{{ asset('/selectize/selectize.bootstrap3.min.css') }}" />


    {{-- JS --}}
    <script src={{asset('/js/jquery.js')}}></script>
    <script src={{asset('/js/bootstrap.bundle.js')}}></script>
{{--    <script src={{asset('/js/moment.min.js')}}></script>--}}
    <script src={{asset('/js/sweetalert.js')}}></script>
    <script src={{asset('/js/datatables.js')}}></script>
    <script src="{{asset('/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('/js/jquery-ui.js')}}"></script>
    <script src={{asset('/js/datatables_bootstrap.js')}}></script>
    <script src={{asset('/js/script.js')}}></script>

    <script src="{{ asset('/selectize/selectize.min.js') }}"></script>

    <title>Select Oracle</title>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        {{--<div class="row justify-content-center">--}}
        {{--<div class="col-sm-11">--}}
        <a class="navbar-brand" href="{{url("/select-oracle/index")}}"><img src="{{asset('image/Indogrosir_logo.jpg')}}" width=100px">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
            </div>
        </div>
        <div class="navbar-nav" style="margin-right: 200px;">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ $_SESSION['user'] }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    @if($_SESSION['status'] == 'select')
                    <a class="dropdown-item" href="{{url("/select-oracle/logout")}}">Logout</a>
                    @else
                    <a class="dropdown-item" href="{{url("/password-generator/logout")}}">Logout</a>
                    @endif
                </div>
            </li>
        </div>
    </div>
</nav>


<main class="py-4">
    @yield('content')

    {{--NAVBAR--}}
    <div class="modal fade" id="modal-loader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true" style="vertical-align: middle;" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="loader" id="loader"></div>
                            <div class="col-sm-12 text-center">
                                <label for="">LOADING...</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--NAVBAR--}}

</main>


</body>

{{--<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>--}}
{{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>--}}
{{--<script src={{asset('/js/jquery.js')}}></script>--}}
{{--<script src={{asset('/js/bootstrap.bundle.js')}}></script>--}}
{{--<script src={{asset('/js/moment.min.js')}}></script>--}}
{{--<script src={{asset('/js/script.js')}}></script>--}}
</html>
