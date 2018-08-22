@extends('layouts.project_ux', ['isLoggedIn' => $isLoggedIn])

@section('content')
    <div class="container-fluid bg-bluegrey-mid bsh-1">
        <div class="container pt-5">
            <div class="row">

                <div class="col-2 pl-7 pr-7">
                    <img class="w-100" src="/images/placeholder_circle.svg" alt="circle-image">
                </div>
                <div class="col">
                    <small class="text-14 text-grey">
                        {{$corpus_data['project_name']}}
                    </small>
                    <h3 class="h3 font-weight-bold text-grey">
                        @if(strpos($corpus_data['name'], "Untitled") > -1)
                            no name defined yet
                        @else
                            {{$corpus_data['name']}}
                        @endif
                    </h3>
                    <div class="mt-1">
                        <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                            <i class="fa fa-user fa-lg mr-2"></i>
                            <span>
                                {{$corpus_data['corpus_admin']['user_name']}} ({{$corpus_data['corpus_admin']['role_name']}})
                            </span>
                        </div>
                    </div>

                </div>

                <div class="col-2">
                    <div class="card text-white bg-transparent">
                        <h6 class="corpus-title h6 text-uppercase text-12 text-wine-trans">
                            Corpus
                        </h6>
                        <div class="card-body d-flex flex-column">
                            <a href="/browse/corpus/{{$corpus->elasticsearch_id}}" class="btn btn-primary font-weight-bold text-uppercase rounded small">
                                Preview
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">

                <nav class="navbar navbar-expand-sm navbar-light bg-transparent p-0 container" role="tablist">

                    <div class="navbar-nav nav row w-100 px-5">

                        <div class="nav-item maintablink col-2 text-center text-14 font-weight-bold active">
                            <a class=" nav-link maintablink text-dark text-uppercase " data-toggle="tab" href="#editCorpus" role="tab">
                                Upload / Edit
                            </a>
                        </div>

                        <div class="nav-item maintablink col-auto text-center text-14 font-weight-bold ">
                            <a class="nav-link maintablink text-dark text-uppercase " data-toggle="tab" href="#messageBoard" role="tab">Message Board
                                <div class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                    <i class="fa fa-comment-o fa-fw fa-edit align-text-top fa-lg text-wine"></i>
                                    <span class="text-primary text-14 font-weight-bold">{{$corpus_data['messagecount']}}</span>
                                </div>
                            </a>
                        </div>

                        <div class="nav-item maintablink col-auto text-center text-14 font-weight-bold ">
                            <a class="nav-link maintablink text-dark text-uppercase" data-toggle="tab" href="#corpusCollaborators" role="tab">Collaborators
                                <div class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                    <i class="fa fa-user fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                                    <span class="text-primary text-14 font-weight-bold">{{count($corpus_data['user_roles'])}}</span>
                                </div>
                            </a>
                        </div>

                    </div>

                </nav>

            </div>
        </div>
    </div>


    <!-- Tab panes -->

    <div class="container-fluid tab-content content">

        <div role="tabpanel"  class="tab-pane active" id="editCorpus">
            @include('project.corpus.headerFiles')
            <input type="hidden" name="auth_user_name" id="auth_user_name" value="{{Auth::user()->name}}" />
            <input type="hidden" name="auth_user_id" id="auth_user_id" value="{{Auth::user()->id}}" />
            <input type="hidden" name="auth_user_email" id="auth_user_email" value="{{Auth::user()->email}}" />
        </div>
        <div role="tabpanel"  class="tab-pane fade in" id="messageBoard">
            @include('project.corpus.messageboard')
        </div>
        <div role="tabpanel"  class="tab-pane fade in" id="corpusCollaborators">
            <div class="container-fluid">
                <div class="container">
                    <div class="row">

                        <div class="col">
                            <div class="d-flex justify-content-between mt-7 mb-3">
                                <h3 class="h3 font-weight-normal">Corpus Collaborator</h3>
                                @if (Auth::user()->can('Can assign users to corpus'))
                                <a href="#" class="btn btn-primary font-weight-bold text-uppercase rounded">
                                    Invite Collaborator
                                </a>
                                @else
                                    &nbsp;
                                @endif
                            </div>

                            <table class="documents-table table table-bluegrey-dark  table-striped">
                                <thead class="bg-bluegrey-mid">
                                <tr class="text-14 text-grey-light">
                                    <th scope="col">Collaborator</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Institute</th>
                                    @if (Auth::user()->can('Can assign users to corpus'))
                                        <th scope="col">Delete</th>
                                    @else
                                        <th scope="col" colspan="2">&nbsp;</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($corpus_data['user_roles'] as $user_id => $role_datas)
                                    @foreach($role_datas as $role_data)
                                <tr>
                                    <td>
                                        @if (Auth::user()->can('Can assign users to corpus'))
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="corpusEditItem_0001">

                                                <label class="custom-control-label font-weight-bold" for="corpusEditItem_0001">
                                                    <i class="fa fa-user fa-fw"></i>
                                                    {{$role_data['user_name']}}
                                                </label>
                                            </div>
                                        @else
                                            <label class="custom-control-label font-weight-bold" for="corpusEditItem_0001">
                                                <i class="fa fa-user fa-fw"></i>
                                                {{$role_data['user_name']}}
                                            </label>
                                        @endif
                                    </td>

                                    @if (Auth::user()->can('Can assign users to corpus'))
                                        <td>
                                            {{ Form::select('role', $corpus_data['roles'], $role_data['role_id'],['class' => 'custom-select custom-select-sm font-weight-bold text-uppercase']) }}
                                        </td>
                                    @else
                                        <td>
                                            <span class="font-weight-bold text-uppercase">{{$corpus_data['roles'][$role_data['role_id']]}}</span>
                                        </td>
                                    @endif
                                    <td class="text-14 text-grey-light">{{$role_data['user_affiliation']}}</td>
                                    @if (Auth::user()->can('Can assign users to corpus'))
                                        <td>
                                            <a href="#">
                                                <i class="fa fa-trash-o fa-fw fa-lg text-dark"></i>
                                            </a>
                                        </td>
                                    @else
                                        <td>
                                            <a href="#">
                                                &nbsp;
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                                <tfoot class="bg-bluegrey-mid">
                                <tr>
                                    <td colspan="2">
                                        @if (Auth::user()->can('Can assign users to corpus'))
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="selectAll_corpusUserEdit">
                                                <label class="custom-control-label text-14" for="selectAll_corpusUserEdit">
                                                    Select all
                                                </label>
                                            </div>
                                        @else
                                            <div class="custom-control custom-checkbox">&nbsp;</div>
                                        @endif
                                    </td>
                                    <td colspan="2">
                                        @if (Auth::user()->can('Can assign users to corpus'))
                                            <button class="float-right disabled btn btn-outline-corpus-dark font-weight-bold text-uppercase btn-sm">
                                                Delete Selected Files
                                            </button>
                                        @else
                                            &nbsp;
                                        @endif

                                    </td>
                                </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection