@extends('layouts.admin', ['isLoggedIn' => $isLoggedIn])

@section('content')
    <div id="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h1>{{$corpus->name}}</h1>
                    </div>
                    <div class="panel-body">
                        <p>{{$corpus->description}}</p>
                    </div>
                    <div class="panel-footer">
                        footie
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection