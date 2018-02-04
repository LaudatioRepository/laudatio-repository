@extends('layouts.dashboard', ['isLoggedIn' => $isLoggedIn])
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Dashboard</h1>
        <!-- /.col-lg-12 -->
        <div class="row">

            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bell fa-fw"></i> Memberships in Projects and Corpora
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div>

                                <div class="table-responsive">

                                    @if(count($assignments['corpusProjects']) > 0)
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Corpus Project roles</th>
                                            </tr>
                                            <tr>
                                                <th>Project</th>
                                                <th>Role</th>
                                            </tr>
                                        </thead>
                                        @can('Can create Corpus Project')
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2">{{link_to_route('project.corpusProject.create', $title = "Create a new project", $parameters = [], $attributes = ["class" => "btn btn-default pull-right"])}}</td>
                                                </tr>
                                            </tfoot>
                                        @endcan
                                        <tbody id="projectRoles">
                                        @if(count($assignments['corpusProjects']) > 0)
                                            @foreach($assignments['corpusProjects'] as $projectId => $assignment)
                                                <tr>
                                                    <td>{{link_to_route('project.corpusProject.show', $title = $assignment['name'], $parameters = ['corpusproject' => $projectId], $attributes = [])}}</td>
                                                    <td>{{$assignment['role']}}</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                    @endif
                                    @if(count($assignments['corpora']) > 0)
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th colspan="3">Corpus roles</th>
                                                </tr>
                                                <tr>
                                                    <th>Project</th>
                                                    <th>Corpus</th>
                                                    <th>Role</th>
                                                </tr>
                                            </thead>
                                            <tbody id="projectRoles">
                                                @foreach($assignments['corpora'] as $corpusId => $assignment)
                                                    <tr>
                                                        <td>{{link_to_route('project.corpusProject.show', $title = $assignment['corpus_project']['name'], $parameters = ['corpusproject' => $assignment['corpus_project']['id']], $attributes = [])}}</td>
                                                        <td>{{link_to_route('project.corpora.show', $title = $assignment['corpus_name']['name'], $parameters = ['corpus' => $corpusId, 'path' => $assignment['corpus_project']['directory_path'].'/'.$assignment['corpus_name']['directory_path']], $attributes = [])}}</td>
                                                        <td>{{$assignment['role']}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>

                                <!-- /.table-responsive -->
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bell fa-fw"></i> Message Board
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="list-group">
                            <a href="#" class="list-group-item">
                                <i class="fa fa-comment fa-fw"></i> New Comment
                                <span class="pull-right text-muted small"><em>4 minutes ago</em>
                                </span>
                            </a>
                            <a href="#" class="list-group-item">
                                <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                <span class="pull-right text-muted small"><em>12 minutes ago</em>
                                </span>
                            </a>
                            <a href="#" class="list-group-item">
                                <i class="fa fa-envelope fa-fw"></i> Message Sent
                                <span class="pull-right text-muted small"><em>27 minutes ago</em>
                                </span>
                            </a>
                            <a href="#" class="list-group-item">
                                <i class="fa fa-tasks fa-fw"></i> New Task
                                <span class="pull-right text-muted small"><em>43 minutes ago</em>
                                </span>
                            </a>
                            <a href="#" class="list-group-item">
                                <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                <span class="pull-right text-muted small"><em>11:32 AM</em>
                                </span>
                            </a>
                            <a href="#" class="list-group-item">
                                <i class="fa fa-bolt fa-fw"></i> Server Crashed!
                                <span class="pull-right text-muted small"><em>11:13 AM</em>
                                </span>
                            </a>
                            <a href="#" class="list-group-item">
                                <i class="fa fa-warning fa-fw"></i> Server Not Responding
                                <span class="pull-right text-muted small"><em>10:57 AM</em>
                                </span>
                            </a>
                            <a href="#" class="list-group-item">
                                <i class="fa fa-shopping-cart fa-fw"></i> New Order Placed
                                <span class="pull-right text-muted small"><em>9:49 AM</em>
                                </span>
                            </a>
                            <a href="#" class="list-group-item">
                                <i class="fa fa-money fa-fw"></i> Payment Received
                                <span class="pull-right text-muted small"><em>Yesterday</em>
                                </span>
                            </a>
                        </div>
                        <!-- /.list-group -->
                        <!--a href="#" class="btn btn-default btn-block">View All Alerts</a-->
                    </div>
                    <!-- /.panel-body -->
                    <div class="panel-footer">
                        <div class="input-group">
                            <input id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here..." />
                            <span class="input-group-btn">
                                <button class="btn btn-warning btn-sm" id="btn-chat">
                                    Send
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>


      <!-- ALL CORPORA -->
        @can('Can create corpus project')
        <div class="row">

            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bell fa-fw"></i> All Corpora
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div>

                                <div class="table-responsive">

                                    @if(count($corpora) > 0)
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                            <tr>
                                                <th>Corpus</th>
                                                <th>Corpus Admin

                                                </th>
                                                <th>Corpus collaborators

                                                </th>
                                            </tr>
                                            </thead>

                                            <tfoot>
                                            <tr>
                                                <td colspan="3">{{link_to_route('project.corpusProject.create', $title = "Create a new project", $parameters = [], $attributes = ["class" => "btn btn-default pull-right"])}}</td>
                                            </tr>
                                            </tfoot>

                                            <tbody id="projectRoles">
                                            @if(count($corpora) > 0)
                                                @foreach($corpora as $corpusId => $corpus)
                                                    <tr>
                                                        <td>
                                                            {{link_to_route('project.corpora.show', $title = $corpus['name'], $parameters = ['corpus' => $corpusId,'path' => $corpus['directory_path'].'/'.$corpus['projectPath']], $attributes = [])}}
                                                        </td>
                                                        <td>
                                                            @if(count($corpus['corpusAdmin']) > 0)
                                                                <a href="#" class="list-group-item">
                                                                 <span class="pull-right text-muted small">
                                                                    <i class="fa fa-minus-square fa-fw"></i>
                                                                 </span>
                                                                    {{$corpus['corpusAdmin']['name']}}
                                                                    : {{$corpus['corpusAdmin']['id']}}
                                                                    : {{$corpus['corpusAdmin']['roleId']}}
                                                                </a>
                                                            @endif
                                                            <br />
                                                            <span class="pull-right text-muted small">
                                                                <i class="fa fa-plus-square fa-fw"></i>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="list-group">
                                                                @foreach($corpus['corpusUsers'] as $corpusUser)
                                                                    <a href="#" class="list-group-item">
                                                                         <span class="pull-right text-muted small">
                                                                            <i class="fa fa-minus-square fa-fw"></i>
                                                                         </span>
                                                                        {{$corpusUser['name']}} : {{$corpusUser['role']}}
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                            <span class="pull-right text-muted small">
                                                                <i class="fa fa-plus-square fa-fw"></i>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>

                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    @endif
                                </div>

                                <!-- /.table-responsive -->
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bell fa-fw"></i> All publications in project
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>
<script language="JavaScript">
    (function () {

    })();


</script>
@endsection
