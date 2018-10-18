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
<div id="rootContainer" class="container-fluid m-0 p-0">
    @include ('layouts.main_ux_nav')
    @if($isLoggedIn)
        @include ('layouts.admin_ux_breadcrumb')
    @else
        @include ('layouts.project_ux_breadcrumb')
    @endif
    @if($flash = session('message'))
        <div id="flash-message" class="alert alert-success">
            {{ $flash }}
        </div>
    @endif
    @yield('content')
    @include('layouts.main_ux_footer')
</div>
<script src="{{ asset('js/vendorscripts_old.js') }}"></script>
@if(isset($corpus_data))
<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
        'directorypath' => $corpus_data['filepath'],
        'corpusid' => $corpus->id,
        'filedata' => []
    ]); ?>
</script>
@endif
<script src="{{ asset('js/scripts.js') }}"></script>
<script src="{{ asset('js/jq.js') }}"></script>
</body>

</html>