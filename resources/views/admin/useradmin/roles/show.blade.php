@extends('layouts.admin', ['isLoggedIn' => $isLoggedIn])

@section('content')
    <div id="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <button type="button" class="btn btn-danger btn-circle btn-xl pull-right">
                            <a href="/admin/roles/{{$role->id}}/delete"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></a>
                        </button>

                        <button type="button" class="btn btn-primary btn-circle btn-xl pull-right">
                            <a href="/admin/roles/{{$role->id}}/edit"><i class="fa fa-edit fa-2x" aria-hidden="true"></i></a>
                        </button>
                        <h1>
                            {{$role->name}}</h1>
                    </div>
                    <div class="panel-body">

                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#description" data-toggle="tab">Description</a>
                            </li>
                            @if (count($role->users) > 0 || count($project_user_roles) > 0 || count($corpus_user_roles) > 0)
                                <li><a href="#users" data-toggle="tab">Users</a></li>
                            @endif
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="description">
                                <br />
                                <p>{{$role->description}}</p>
                            </div>
                            @if (count($role->users) > 0)
                                <div class="tab-pane fade" id="users">
                                    <br />
                                    <div class="panel-group" id="accordion">
                                        @foreach($role->users as $user)
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <span class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#{{$user->id}}" aria-expanded="false" class="collapsed">
                                                            {{ $user->name }}
                                                        </a>
                                                        <span class="pull-right"> <a href="/admin/userroles/{{$role->id}}/{{$user->id}}/delete"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></a></span>
                                                    </span>
                                                </div>
                                                <div id="{{$user->id}}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                                    <div class="panel-body">
                                                        {{$user->email}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @elseif(count($project_user_roles) > 0 || count($corpus_user_roles) > 0)
                                <div class="tab-pane fade" id="users">
                                    <br />

                                            @if(count($project_user_roles) > 0)
                                                            @foreach($project_user_roles as $project_user_role)
                                                                <div class="panel-group" id="accordion_project_roles">
                                                                    <div class="panel panel-default">
                                                                        <div class="panel-heading">
                                                                            <span class="panel-title">
                                                                                <a data-toggle="collapse" data-parent="#accordion_project_roles" href="#accordion_project_roles_{{$project_user_role['user_id']}}" aria-expanded="false" class="collapsed">
                                                                                    {{$project_user_role['user_name']}}
                                                                                </a>
                                                                            </span>
                                                                        </div>
                                                                        <div id="accordion_project_roles_{{$project_user_role['user_id']}}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                                                            <div class="panel-body">
                                                                                <ul class="list-group">
                                                                                    @foreach($project_user_role['role_data'] as $project_role_data)
                                                                                        <li class="list-group-item">{{$project_role_data['project_name']}}<span class="pull-right"> <a href="/admin/corpusprojects/{{$project_role_data['project_id']}}/{{$project_user_role['user_id']}}/delete"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></a></span></li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                            @endif

                                            @if(count($corpus_user_roles) > 0)

                                                            @foreach($corpus_user_roles as $corpus_user_role)
                                                                <div class="panel-group" id="accordion_corpus_roles">
                                                                    <div class="panel panel-default">
                                                                        <div class="panel-heading">
                                                                            <span class="panel-title">
                                                                                <a data-toggle="collapse" data-parent="#accordion_corpus_roles" href="#accordion_corpus_roles_{{$corpus_user_role['user_id']}}" aria-expanded="false" class="collapsed">
                                                                                    {{$corpus_user_role['user_name']}}
                                                                                </a>
                                                                            </span>
                                                                        </div>
                                                                        <div id="accordion_corpus_roles_{{$corpus_user_role['user_id']}}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                                                            <div class="panel-body">
                                                                                <ul class="list-group">
                                                                                    @foreach($corpus_user_role['role_data'] as $corpus_role_data)
                                                                                        <li class="list-group-item">{{$corpus_role_data['corpus_name']}} <span class="pull-right"><a href="/admin/corpora/{{$corpus_role_data['corpus_id']}}/{{$corpus_user_role['user_id']}}/delete"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></a></span></li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                            @endif


                                    </div>
                                @endif
                            </div>

                        </div>
                        <div class="panel-footer">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection