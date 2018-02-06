@extends('layouts.admin', ['isLoggedIn' => $isLoggedIn])

@section('content')
    <!--div class="content">
        <form action="/admin/roles/{{$role->id}}" method="post">

            <div class="col-lg-12">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h1><i class="fa fa-cogs fa-fw"></i> Edit Role {{$role->name}}</h1>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="form-group>">
                                <label for="corpus_name">Role Name</label>
                                <input type="text" name="role_name" id="role_name" class="form-control" value="{{$role->name}}" />
                            </div>
                            <br /><br />
                            <div class="form-group>">
                                <label for="corpus_description">Role Description</label>
                                <textarea name="role_description" id="role_description" placeholder="Write a description for your Role"  class="form-control">{{$role->description}}</textarea>
                            </div>

                            <div class="form-group>">
                                <button type="submit" value="Create" class="btn btn-primary ">Update Role</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div-->
    <div class='col-lg-4 col-lg-offset-4'>
        <h1><i class='fa fa-key'></i> Edit Role: {{$role->name}}</h1>
        <hr>

        {{ Form::model($role, array('route' => array('admin.roles.update', $role->id), 'method' => 'post')) }}
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <div class="form-group">
            {{ Form::label('name', 'Role Name') }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}
        </div>
        <div class="form-group>">
            {{ Form::label('description', 'Role Description') }}
            {{ Form::textarea('description', null, array('class' => 'form-control')) }}
        </div>
        <h5><b>Assign Permissions</b></h5>
        @foreach ($permissions as $permission)

            {{Form::checkbox('permissions[]',  $permission->id, $role->permissions ) }}
            {{Form::label($permission->name, ucfirst($permission->name)) }}<br>

        @endforeach
        <br>
        {{ Form::submit('Edit', array('class' => 'btn btn-primary')) }}

        {{ Form::close() }}
    </div>


    <div class="col-lg-12">
        @include('layouts.errors')
    </div>
@endsection