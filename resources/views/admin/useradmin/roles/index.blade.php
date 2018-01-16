@extends('layouts.admin', ['isLoggedIn' => $isLoggedIn])

@section('content')
    <div id="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default panel-green">
                    <div class="panel-heading">
                        <h1><i class="fa fa-group fa-suitcase fa-fw"></i> Roles</h1>
                    </div>
                    <!-- .panel-heading -->
                    <div class="panel-body">
                        <div class="panel-group" id="accordion">
                            @foreach($roles as $role)
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <span class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#{{$role->id}}" aria-expanded="false" class="collapsed">
                                                @if($role->super_user == 1)
                                                    <i class="fa fa-superpowers" aria-hidden="true"></i>
                                                @else
                                                    <i class="fa fa-users" aria-hidden="true"></i>
                                                @endif
                                                {{ $role->name }}
                                            </a>
                                        </span>
                                        <span class="pull-right">Created at: {{$role->created_at->toFormattedDateString()}}
                                            <button type="button" class="btn btn-success btn-circle">
                                                <a href="/admin/roles/{{$role->id}}"><i class="fa fa-external-link" aria-hidden="true"></i></a>
                                            </button>
                                        </span>
                                    </div>
                                    <div id="{{$role->id}}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            {{$role->description}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a href="/admin/roles/create"><i class="pull-right fa fa-plus-square fa-2x" aria-hidden="true"></i></a>
                    </div>
                    <!-- .panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        </div>





    </div>
@endsection