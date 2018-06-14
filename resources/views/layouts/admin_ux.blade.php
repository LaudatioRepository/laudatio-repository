<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laudatio') }}</title>
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('css/ux_style.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/unslider.css') }}" rel="stylesheet">
    <link href="{{ asset('css/laudatio.css') }}" rel="stylesheet">
</head>

<body>
<div class="container-fluid m-0 p-0">
    @include ('layouts.main_ux_nav')
    @yield('content')
    @include('layouts.main_ux_footer')
</div>
<script src="{{ asset('js/vendorscripts.js') }}"></script>
<script src="{{ asset('js/scripts.js') }}"></script>
<script src="{{ asset('js/browseapp.js') }}"></script>
<script src="{{ asset('js/jq.js') }}"></script>

@if (session('openLogin'))
    //some js function that will open your hidden modal
    //if you use bootstrap modal
    <script>
        $('#signInModal').modal('show');
    </script>
@endif
</body>

</html>