@extends('layouts.admin', ['isLoggedIn' => $isLoggedIn])

@section('content')
    <div class="content">
        <form action="/project/corpora/{{$corpus->id}}" method="post">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <div class="col-lg-12">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h1><i class="fa fa-cogs fa-fw"></i> Edit Corpus project {{$corpus->name}}</h1>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="form-group>">
                                <label for="corpus_name">Role Name</label>
                                <input type="text" name="corpus_name" id="corpus_name" class="form-control" value="{{$corpus->name}}" />
                            </div>
                            <br /><br />
                            <div class="form-group>">
                                <label for="corpus_description">Corpus project Description</label>
                                <textarea name="corpus_description" id="corpus_description" placeholder="Update the description for your Corpus project"  class="form-control">{{$corpus->description}}</textarea>
                            </div>

                            <div class="form-group>">
                                <button type="submit" value="Update" class="btn btn-primary ">Update Corpus project</button>
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