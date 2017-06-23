@extends('layouts.app', ['isLoggedIn' => $isLoggedIn])

@section('content')
    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/commit" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        Commit message:
        <br />
        <textarea name="commitmessage" rows="4" cols="50"></textarea>
        <br /><br />
        <br /><br />

        <input type="submit" value="Add Version" />
        <input type ="hidden" name="directorypath" value="{{$dirname}}" />
    </form>
@stop