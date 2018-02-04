@extends('layouts.admin', ['isLoggedIn' => $isLoggedIn])

@section('content')
    <div id="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default panel-green">
                    <div class="panel-heading">
                        <h1><i class="fa fa-group fa-fw"></i> Corpus projects</h1>
                    </div>
                    <!-- .panel-heading -->
                    <div class="panel-body">
                        <div class="panel-group" id="accordion">
                            @foreach($CorpusProjects as $CorpusProject)
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <span class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#{{$CorpusProject->id}}" aria-expanded="false" class="collapsed">
                                                {{ $CorpusProject->name }}
                                            </a>
                                        </span>
                                        <span class="pull-right">Created at: {{$CorpusProject->created_at->toFormattedDateString()}}
                                            <button type="button" class="btn btn-success btn-circle">
                                                <a href="/project/corpusprojects/{{$CorpusProject->id}}"><i class="fa fa-external-link" aria-hidden="true"></i></a>
                                            </button>
                                        </span>
                                    </div>
                                    <div id="{{$CorpusProject->id}}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            {{$CorpusProject->description}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- .panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        </div>






    </div>
@endsection