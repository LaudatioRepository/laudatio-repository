@extends('layouts.admin', ['isLoggedIn' => $isLoggedIn])

@section('content')
    <div class="content">
        <form action="/admin/roles/{{$role->id}}" method="post">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
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
                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        </form>
    </div>
    <div class="col-lg-12">
        @include('layouts.errors')
    </div>
@endsection