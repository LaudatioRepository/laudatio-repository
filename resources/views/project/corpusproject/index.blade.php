@extends('layouts.project_ux', ['isLoggedIn' => $isLoggedIn])

@section('content')
        <div class="container-fluid">
            <div class="container">
                <div class="row mt-5">
                    <div class="col-3 mt-2">
                        <nav class="sidebar text-14 nav flex-column border-top border-light mt-7" role="navigation">
                            <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link active">Corpus projects</a>
                            <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link" href="{{ route('corpusProject.invitations') }}">Invitations</a>
                            <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link " href="{{ route('corpusProject.create') }}">Initiate Project</a>
                        </nav>
                    </div>

                    <div class="col">
                        <div class="alert alert-dismissible fade show" role="alert" id="alert-laudatio">
                            <span class="alert-laudatio-message"></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="d-flex justify-content-between  ">
                            <h3 class="h3 font-weight-normal">Corpus Projects ({{count($corpusProjects)}})</h3>
                        </div>

                        <div class="mt-4">
                            @foreach($corpusProjects as $corpusProjectId => $corpusProject)
                            <div id="corpusProject_{{$corpusProjectId}}" class="corpusProject container bg-bluegrey-middark mt-1 mb-1 p-5">

                                <div class="row corpusProject-save">
                                    <div class="col">
                                        <small class="text-14 text-grey">
                                            Corpus Project
                                        </small>

                                        <div class="h4 font-weight-bold corpusProject-title" id="corpusProject-title_{{$corpusProjectId}}">
                                            {{$corpusProject['name']}}
                                        </div>
                                        <div class="mt-2">
                                            @if (count($corpusProject['user_roles']) > 0)
                                                @foreach($corpusProject['user_roles'] as $projectRole)
                                                <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                    <i class="material-icons  mr-2">person</i>
                                                    <span>{{$projectRole['user_name']}} ({{$projectRole['role_name']}})</span>
                                                </div>
                                                @endforeach
                                            @endif
                                        </div>

                                        <p class="mt-3 text-14 mb-0 corpusProject-description" id="corpusProject-description_{{$corpusProjectId}}">
                                            {{$corpusProject['description']}}
                                        </p>

                                    </div>
                                    <div class="col-2 p-0 mr-2">
                                        <button  class="corpusProject-startEdit btn btn-outline-corpus-dark font-weight-bold text-uppercase rounded mb-4 w-100">
                                            Edit project
                                        </button>
                                        <a href="{{ route('corpus.create',['corpusproject' => $corpusProjectId]) }}" class="btn btn-outline-corpus-dark font-weight-bold text-uppercase rounded mb-4 w-100">
                                            Add Corpus
                                        </a>
                                    </div>
                                </div>

                                <div class="row corpusProject-edit hidden">
                                    <form id="editCorpusProject_{{$corpusProjectId}}" method="POST" action="api/adminapi/updateCorpusProject/{{$corpusProjectId}}" class="w-100 updateform">
                                        <div class="form-group">
                                            <label class="text-14 text-dark-trans mb-1 pl-3" for="corpusproject_name_{{$corpusProjectId}}">
                                                <small>Corpus project Title</small>
                                            </label>
                                            <input type="text" class="corpusProject-title-edit form-control" name="corpusproject_name_{{$corpusProjectId}}" id="corpusproject_name_{{$corpusProjectId}}" required
                                                   placeholder="What's the project title?" value="{{$corpusProject['name']}}">
                                        </div>
                                        <div class="form-group mt-3">
                                            <label class="text-14 text-dark-trans mb-1 pl-3" for="corpusproject_description">
                                                <small>Corpus Project Description</small>
                                            </label>
                                            <textarea id="corpusproject_description_{{$corpusProjectId}}" name="corpusproject_description_{{$corpusProjectId}}" class="corpusProject-description-edit form-control py-3"
                                                      cols="30" rows="8" placeholder="here you can describe the purpose of your project. We recommend between 300 and max. 500 chars.">{{$corpusProject['description']}}</textarea>
                                        </div>
                                        <div class="form-row mt-3">
                                            <div class="col offset-7">
                                                <button class="corpusProject-endEdit btn btn-outline-corpus-mid text-uppercase font-weight-bold rounded w-100">Cancel</button>
                                            </div>
                                            <div class="col">
                                                <button  class="corpusProject-saveEdit btn btn-primary rounded text-uppercase font-weight-bold w-100">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>


                             <!-- CORPO-->
                            @foreach($corpusProject['corpora'] as $corpus)
                                @if ($corpus['workflow_status'] == 0)
                                    <div class="container bg-bluegrey-midlight mt-1 mb-1 p-5">
                                        <div class="row">
                                            <div class="col-2 pl-4">
                                                <img class="w-100" src="/images/placeholder_circle.svg" alt="circle-image">
                                            </div>
                                            <div class="col">
                                                <small class="text-14 text-grey">
                                                    Corpus
                                                </small>
                                                <div class="h4 font-weight-bold">
                                                    <a class="text-dark" href="adminEdit_corpus.html">
                                                        {{$corpus['name']}}
                                                    </a>
                                                </div>
                                                @if (count($corpus['user_roles']) > 0)
                                                    @foreach($corpus['user_roles'] as $corpusRole)
                                                    <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                        <i class="material-icons  mr-2">person</i>
                                                        <span>{{$corpusRole['user_name']}} ({{$corpusRole['role_name']}})</span>
                                                    </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="col-2 p-0 mr-2">
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-corpus-dark dropdown-toggle font-weight-bold text-uppercase rounded mb-4 w-100 text-left"
                                                            type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Edit
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item text-14" href="{{ route('corpus.edit',['corpus' => $corpus['id']]) }}">Edit Corpus</a>
                                                        <a class="dropdown-item text-14" href="{{route('browse.showHeaders.get', ['header' => 'corpus', 'id' => $corpus['elasticsearch_id']])}}">Preview Corpus</a>
                                                        <a class="dropdown-item text-14" href="#" data-toggle="modal" data-target="#publishCorpusModal" id="publishCorpusButton">Publish Corpus</a>
                                                        <a class="dropdown-item text-14" href="#" data-toggle="modal" data-target="#deleteCorpusModal">Delete Corpus</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 @endif
                            @endforeach
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="publishCorpusModal" tabindex="-1" role="dialog" aria-labelledby="publishCorpusModalTitle"
             aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content border-0 rounded-lg bsh-1">

                    <div class="modal-body px-5">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-close" aria-hidden="true"></i>
                        </button>
                        <h3 class="h3 modal-title mt-3 w-75" id="publishCorpusModalTitle">
                        </h3>

                        <p class="mt-3 mb-1" id="publishCorpusModalSubtitle">
                        </p>

                        <div id="publishCorpusModalSubtitleContent"></div>

                    </div>
                    <div class="modal-footer bg-corpus-light px-4 rounded-lg-bt">
                        <button class="btn btn-outline-corpus-dark font-weight-bold text-uppercase rounded px-5" data-dismiss="modal"
                                aria-label="Close">
                            Cancel
                        </button>
                        <button class="btn btn-primary font-weight-bold text-uppercase rounded px-5" data-dismiss="modal"
                                data-toggle="modal" data-target="#publishSuccessCorpusModal" id="doPublish">
                            Publish
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteCorpusModal" tabindex="-1" role="dialog" aria-labelledby="deleteCorpusModal"
             aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content border-0 rounded-lg bsh-1">

                    <div class="modal-body px-5">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-close" aria-hidden="true"></i>
                        </button>
                        <h3 class="h3 modal-title mt-3">
                            Do you really want to delete corpus "no name defined yet" ?
                        </h3>

                        <p class="mt-3 mb-1">
                            It includes:
                        </p>

                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item">
                                <b>(0) Corpus Header</b>
                            </li>
                            <li class="list-group-item">
                                <b>(0) Document Header</b>
                            </li>
                            <li class="list-group-item">
                                <b>(0) Annotation Header</b>
                            </li>
                            <li class="list-group-item">
                                <b>(0) Corpus Data Format</b>
                            </li>
                            <li class="list-group-item">
                                <b>(0) Defined License</b>
                            </li>
                        </ul>

                    </div>
                    <div class="modal-footer bg-corpus-light px-4 rounded-lg-bt">
                        <button class="btn btn-outline-corpus-dark font-weight-bold text-uppercase rounded px-5" data-dismiss="modal"
                                aria-label="Close">
                            Cancel
                        </button>
                        <button class="btn btn-primary font-weight-bold text-uppercase rounded px-5">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
@endsection