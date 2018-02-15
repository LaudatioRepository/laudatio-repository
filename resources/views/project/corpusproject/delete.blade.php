@extends('layouts.admin', ['isLoggedIn' => $isLoggedIn])

@section('content')
    <div class="content">
        <form action="/project/corpusprojects/{{$corpusproject->id}}" method="post">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <div class="col-lg-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h1><i class="fa fa-cogs fa-fw"></i> Delete Corpus project {{$corpusproject->name}}</h1>
                    </div>
                    <div class="panel-body">
                        <p>Are you sure you want to delete {{$corpusproject->name}}? </p>
                        @if (count($corpusproject->corpora) > 0)
                            <p> {{count($corpusproject->corpora)}} corpora are assigned to this Corpus project</p>
                        @endif

                        @if (count($corpusproject->users) > 0)
                            <p> {{count($corpusproject->users)}} users are assigned to this Corpus project</p>
                        @endif
                        <div class="form-group">
                            <a href="{{ URL::route('project.corpusProject.index') }}" type="button" class="btn btn-primary"> Cancel </a>
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