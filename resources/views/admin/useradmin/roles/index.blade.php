@extends('layouts.admin', ['isLoggedIn' => $isLoggedIn])
@section('title', '| Roles')
@section('content')
    <!--div id="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default panel-green">
                    <div class="panel-heading">
                        <h1><i class="fa fa-group fa-suitcase fa-fw"></i> Roles</h1>
                    </div>
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
                </div>
            </div>
        </div>
    </div-->
    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-key"></i> Roles


            <a href="{{ route('permissions.index') }}" class="btn btn-default pull-right">Permissions</a></h1>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Role</th>
                    <th>Permissions</th>
                    <th>Operation</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($roles as $role)
                    <tr>

                        <td>{{ $role->name }}</td>

                        <td>{{ str_replace(array('[',']','"'),'', $role->permissions()->pluck('name')) }}</td>{{-- Retrieve array of permissions associated to a role and convert to string --}}
                        <td>
                            <a href="{{ URL::to('admin/roles/'.$role->id.'/edit') }}" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>

                            {!! Form::open(['method' => 'DELETE', 'route' => ['admin.roles.destroy', $role->id] ]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}

                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>

        <a href="{{ URL::to('admin/roles/create') }}" class="btn btn-success">Add Role</a>

    </div>
@endsection