@extends('layouts.project_ux', ['isLoggedIn' => $isLoggedIn])
@section('title', '| Roles')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mt-7 mb-3">
            <h3 class="h3 font-weight-normal"><i class="fa fa-key"></i> Roles </h3>
        </div>
        <div class="container">
            <div class="row mt-5">
                <div class="col-3 mt-2">
                    <nav class="sidebar text-14 nav flex-column border-top border-light mt-7" role="navigation">´
                        <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link" href="{{ route('permissions.index') }}">Permissions</a>
                    </nav>
                </div>

                <div class="col">
                    <table class="custom-table table table-bluegrey-dark table-striped">
                        <thead class="bg-bluegrey-mid">
                        <tr class="text-14 text-grey">
                            <th scope="col">Role</th>
                            <th scope="col">Permissions</th>
                            <th scope="col">Operation</th>
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
                        <tfoot class="bg-bluegrey-mid">
                            <tr>
                                <td colspan="3"><a href="{{ URL::to('admin/roles/create') }}" class="btn btn-success">Add Role</a></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection