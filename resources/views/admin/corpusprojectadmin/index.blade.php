@extends('layouts.admin', ['isLoggedIn' => $isLoggedIn])

@section('content')
    <div id="container">
        <h1>Corpus projects</h1>

        <div class="row">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Corpus projects
                    <div class="pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                Actions
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li><a href="#">Action</a>
                                </li>
                                <li><a href="#">Another action</a>
                                </li>
                                <li><a href="#">Something else here</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-group" id="accordion">
                    @foreach($CorpusProjects as $CorpusProject)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title"  data-toggle="collapse" data-parent="#accordion" data-target="#{{$CorpusProject->id}}">
                                    {{ $CorpusProject->name }}
                                    <span class="p">Created at: {{$CorpusProject->created_at->toFormattedDateString()}}</span>
                                    <i class="fa fa-expand pull-right" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div id="{{$CorpusProject->id}}" class="panel-collapse collapse">
                                <div   class="panel-body">
                                    {{$CorpusProject->description}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- /.panel-body -->
            </div>
        </div>

    </div>
@endsection