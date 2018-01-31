@extends('layouts.admin', ['isLoggedIn' => $isLoggedIn])

@section('title', '| Add role')
@section('content')
    <!--div class="content">
        <form action="/admin/roles" method="post">
            {{ csrf_field() }}
            <div class="col-lg-12">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h1><i class="fa fa-cogs fa-fw"></i> Create a new Role</h1>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="form-group>">
                                <label for="role_name">Role Name</label>
                                <input type="text" name="role_name" id="role_name" class="form-control" />
                            </div>
                            <br /><br />
                            <div class="form-group>">
                                <label for="role_description">Role Description</label>
                                <textarea name="role_description" id="role_description" placeholder="Write a description for your Role"  class="form-control"></textarea>
                            </div>
                            <br /><br />
                            <div class="form-group>">
                                <label for="role_corpusproject">Corpus project role: <input type="radio" name="role_type" id="role_type" value="corpusproject" /></label>
                            </div>
                            <div class="form-group>">
                                <label for="role_corpus">Corpus role: <input type="radio" name="role_type" id="role_type" value="corpus" /></label>
                            </div>
                            <br /><br />

                            <br /><br />
                            <div class="form-group>">
                                <button type="submit" value="Create" class="btn btn-primary ">Create Role</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div-->
    <div class='col-lg-4 col-lg-offset-4'>

        <h1><i class='fa fa-key'></i> Add Role</h1>
        <hr>

        {{ Form::open(array('url' => 'admin/roles')) }}
        {{ csrf_field() }}
        <div class="form-group">
            {{ Form::label('name', 'Name') }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}
        </div>
        <div class="form-group>">
            {{ Form::label('role_description', 'Role Description') }}
            {{ Form::textarea('role_description', null, array('class' => 'form-control')) }}
        </div>
        <div class="form-group>">
            {{ Form::label('role_superuser', 'Is super user') }}
            {{ Form::checkbox('role_superuser', 'on', false) }}

        </div>

        <h5><b>Assign Permissions</b></h5>

        <div class='form-group'>
            @foreach ($permissions as $permission)
                {{ Form::checkbox('permissions[]',  $permission->id ) }}
                {{ Form::label($permission->name, ucfirst($permission->name)) }}<br>

            @endforeach
        </div>

        {{ Form::submit('Add', array('class' => 'btn btn-primary')) }}

        {{ Form::close() }}

    </div>

    <div class="col-lg-12">
        @include('layouts.errors')
    </div>
@endsection