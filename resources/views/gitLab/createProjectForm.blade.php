@extends('layouts.app', ['isLoggedIn' => $isLoggedIn])

@section('content')
    <div id="container">
    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/createproject" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        Project name:
        <br />
        <input type="text" name="projectname" />
        <input type="submit" value="Create" />
        <input type ="hidden" name="directorypath" value="{{$dirname}}" />
    </form>
    </div>
@stop