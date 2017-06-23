@extends('layouts.app', ['isLoggedIn' => $isLoggedIn])

@section('content')
    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/upload" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <!--p>Directory name:
        <br />
        <input type="text" name="dirname" /></p-->
        Upload file format (can attach more than one):
        <br />
        <input type="file" name="formats[]" multiple />
        <br /><br />
        <input type="submit" value="Upload" />
        <input type ="hidden" name="directorypath" value="{{$dirname}}" />
    </form>
@stop