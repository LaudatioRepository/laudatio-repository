@extends('layouts.admin', ['isLoggedIn' => $isLoggedIn])

@section('content')
    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif


    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Commit your files
                </div>
                <div class="panel-body">
                    <form action="/admin/commit" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        Commit message:
                        <br />
                        <textarea name="commitmessage" rows="4" cols="50"></textarea>
                        <br /><br />
                        <br /><br />

                        <input type="submit" value="Add Version" />
                        <input type ="hidden" name="directorypath" value="{{$dirname}}" />
                        <input type ="hidden" name="corpusid" value="{{$corpusid}}" />
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop