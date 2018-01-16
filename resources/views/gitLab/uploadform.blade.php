@extends('layouts.admin', ['isLoggedIn' => $isLoggedIn])


@section('content')
    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/admin/upload" method="post" enctype="multipart/form-data">
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
        <input type ="hidden" name="corpusid" value="{{$corpusid}}" />
        <input type ="hidden" name="isCorpusHeader" value="{{$isCorpusHeader}}" />
        <input type ="hidden" name="corpusProjectPath" value="{{$corpusProjectPath}}" />
    </form>
@stop