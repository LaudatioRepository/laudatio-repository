@extends('layouts.admin', ['isLoggedIn' => $isLoggedIn])

@section('content')
    <div class="content">
        <form action="/admin/corpusprojects/{{$corpusproject->id}}/corpora" method="post">
            {{ csrf_field() }}
            <div class="col-lg-12">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h1><i class="fa fa-cogs fa-fw"></i>   Assign corpora to the  {{$corpusproject->name}} Corpus Project</h1>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="col-lg">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h2>Corpus project info</h2>
                                        </div>
                                        <div class="panel-body">
                                            <p>{{$corpusproject->description}}</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.col-lg-6 (nested) -->
                            <div class="col-lg-6">
                                <div class="col-lg">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h2>Corpora</h2>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                @foreach($corpora as $corpus)
                                                    <div class="checkbox">
                                                        <label for="corpora">
                                                            <input type="checkbox" name="corpora[]" value="{{$corpus->id}}">{{$corpus->name}}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <button type="reset" class="btn btn-default">Reset Button</button>
                                            <button type="submit" class="btn btn-default">Assign chosen corpora</button>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <!-- /.col-lg-6 (nested) -->
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