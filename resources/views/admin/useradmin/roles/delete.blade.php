@extends('layouts.admin', ['isLoggedIn' => $isLoggedIn])

@section('content')
    <div class="content">
        <form action="/admin/roles/{{$role->id}}" method="post">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <div class="col-lg-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h1><i class="fa fa-cogs fa-fw"></i> Delete Role {{$role->name}}</h1>
                    </div>
                    <div class="panel-body">
                        <p>Are you sure you want to delete {{$role->name}}? </p>
                        @if (count($role->users) > 0)
                            <p> {{count($role->users)}} users are assigned to this role</p>
                        @endif
                        <div class="form-group">
                            <a href="{{ URL::route('admin.roles.index') }}" type="button" class="btn btn-primary"> Cancel </a>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
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