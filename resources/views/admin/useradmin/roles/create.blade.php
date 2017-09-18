@extends('layouts.admin', ['isLoggedIn' => $isLoggedIn])

@section('content')
    <div class="content">
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
                            <div class="form-group>">
                                <label for="role_superuser"><i class="fa fa-superpowers" aria-hidden="true"></i> Is super user <input type="checkbox" name="role_superuser" id="role_superuser" /></label>
                            </div>
                            <br /><br />
                            <div class="form-group>">
                                <button type="submit" value="Create" class="btn btn-primary ">Create Role</button>
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