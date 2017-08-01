@extends('layouts.admin', ['isLoggedIn' => $isLoggedIn])

@section('content')
    <div id="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h1>{{$corpusproject->name}}</h1>
                    </div>
                    <div class="panel-body">

                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#description" data-toggle="tab">Description</a>
                            </li>
                            <li><a href="#corpora" data-toggle="tab">Corpora</a>
                            </li>
                            <li><a href="#collaborators" data-toggle="tab">Collaborators</a>
                            </li>
                            <li><a href="#settings" data-toggle="tab">Settings</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="description">
                                <h4>Description</h4>
                                <p>{{$corpusproject->description}}</p>
                            </div>
                            <div class="tab-pane fade" id="corpora">
                                <h4>Corpora</h4>
                                <div class="panel-group" id="accordion">
                                    @foreach($corpusproject->corpora as $corpus)
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                        <span class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#{{$corpus->id}}" aria-expanded="false" class="collapsed">
                                                {{ $corpus->name }}
                                            </a>
                                        </span>
                                                <span class="pull-right">Created at: {{$corpus->created_at->toFormattedDateString()}}
                                                    <button type="button" class="btn btn-success btn-circle">
                                                <a href="/admin/corpora/{{$corpus->id}}"><i class="fa fa-external-link" aria-hidden="true"></i></a>
                                            </button>
                                        </span>
                                            </div>
                                            <div id="{{$corpus->id}}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                                <div class="panel-body">
                                                    {{$corpus->description}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-success btn-circle">
                                    <a href="/admin/corpusprojects/assign/{{$corpusproject->id}}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                </button>
                                Add a corpus to the corpus project
                            </div>
                            <div class="tab-pane fade" id="collaborators">
                                <h4>Collaborators</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            </div>
                            <div class="tab-pane fade" id="settings">
                                <h4>Settings</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            </div>
                        </div>


                    </div>
                    <div class="panel-footer">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection