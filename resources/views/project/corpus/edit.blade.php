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
                                {{$corpus_data['admin']['user_name']}} ({{$corpus_data['admin']['role_name']}})
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
                            <a href="adminPreview_corpus.html" class="disabled btn btn-primary font-weight-bold text-uppercase rounded small">
                                Preview
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">



                <nav class="navbar navbar-expand-sm navbar-light bg-transparent p-0 container" role="tablist">

                    <div class="navbar-nav nav row w-100 px-5">
                        <div class="nav-item tablink col-2 text-center text-14 font-weight-bold active">
                            <a class=" nav-link tablink text-dark text-uppercase " data-toggle="tab" href="#editCorpus" role="tab">
                                Upload / Edit
                            </a>
                        </div>

                        <div class="nav-item tablink col-auto text-center text-14 font-weight-bold ">
                            <a class="nav-link tablink text-dark text-uppercase " data-toggle="tab" href="#messageBoard" role="tab">Message Board
                                <div class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                    <i class="fa fa-comment-o fa-fw fa-edit align-text-top fa-lg text-wine"></i>
                                    <span class="text-primary text-14 font-weight-bold">5</span>
                                </div>
                            </a>
                        </div>

                        <div class="nav-item tablink col-auto text-center text-14 font-weight-bold ">
                            <a class="nav-link tablink text-dark text-uppercase" data-toggle="tab" href="#corpusCollaborators" role="tab">Collaborator
                                <div class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                    <i class="fa fa-user fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                                    <span class="text-primary text-14 font-weight-bold">4</span>
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
            <div class="container-fluid">
                <div class="container">
                    <div class="row">
                        <div class="col-2">
                            <nav class="sidebar text-14 nav flex-column border-top border-light mt-7" role="navigation">
                                <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link active" href="adminEdit_corpus.html">Corpus ({{$corpus_data['headerdata']['corpusheader']}})</a>
                                <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link" href="adminEdit_documents.html">Documents ({{count($corpus_data['headerdata']['found_documents'])}})</a>
                                <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link" href="#">Annotations ({{count($corpus_data['headerdata']['found_annotations_in_corpus'])}})</a>
                                <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link " href="adminEdit_formatData.html">Format data (4)</a>
                                <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link " href="adminEdit_logoLicense.html">Logo/License (8)</a>
                            </nav>
                        </div>

                        <div class="col">
                            <div class="d-flex justify-content-between mt-7 mb-3">
                                <h3 class="h3 font-weight-normal">File Upload Corpus Header XML</h3>
                            </div>

                            <div class="card border-0 mt-3">
                                <div class="card-body bg-bluegrey-mid py-4 px-3">
                                    <div class="w-100 dashed rounded uploadArea">
                                        <div class="w-100 p-5 bg-white d-flex justify-content-center align-items-center">
                                            <i class="fa fa-upload fa-2x fa-fw text-dark mr-3"></i>
                                            <div>
                                                <p class="m-0">
                                                    Drag and drop or
                                                    <span class="text-primary">browse files</span>
                                                    <br />
                                                    <span class="text-14 text-grey">
                            Accepted file format: .xml
                          </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="uploadActions d-flex justify-content-between mt-3">
                                        <p class="text-14 text-grey">
                                            <span class="uploadLength hidden"></span>
                                        </p>
                                        <div>
                                            <a href="adminEdit_corpus.html" class="btn btn-outline-corpus-dark text-uppercase font-weight-bold rounded px-5 mr-3">
                                                Cancel
                                            </a>
                                            <a href="adminEdit_corpus.html" class="disabled btn btn-primary text-uppercase font-weight-bold rounded">
                                                Finish Upload
                                            </a>
                                            <!-- Submit can happen at this place -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- CARD END  -->

                            <div id="previews">

                                <div id="corpusUploadTemplate" class="uploadItem p-3 mt-3 bg-bluegrey-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="font-weight-bold" data-dz-name></span>
                                        <div class="uploadStatusIcons">
                                            <i class="uploadSuccessIcon hidden fa fa-check-circle text-success fa-fw fa-lg pr-5"></i>
                                            <i class="uploadErrorIcon hidden fa fa-exclamation-triangle text-danger fa-fw fa-lg pr-5"></i>
                                            <button class="uploadCancel hidden btn btn-text bg-transparent p-2">
                                                <i class="uploadCancelIcon fa fa-close text-dark fa-fw fa-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <p class="size hidden" data-dz-size></p>
                                        <span class="uploadStatusText text-14 text-grey"></span>
                                        <span class="error text-14 text-danger" data-dz-errormessage></span>
                                    </div>

                                    <div class="progress progress-striped active w-90 mb-3" role="progressbar" aria-valuemin="0" aria-valuemax="100"
                                         aria-valuenow="0">
                                        <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                    </div>

                                </div>
                            </div>
                            @if(strpos($corpus_data['name'], "Untitled") > -1)
                                <p class="mt-5">
                                    It seems that you just added a new corpus. The name of the new corpus will be defined through the according
                                    .xml file.
                                </p>
                                <p>Within our
                                    <a href="#"></a>Help section you will find detailed instructions how to structure .xml data and upload
                                    files. Following data needs to be provided to be able to publish a corpus to laudatio:
                                </p>
                                <div class="mt-5">


                                    <ul class="list-group list-group-flush mb-3 mt-3">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <b>1 Corpus Header uploaded</b>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <b>According number of Document Header</b>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div class="d-flex flex-column">
                                                <b>According number of Annotation Header</b>
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div class="d-flex flex-column">
                                                <b>at least 1 Corpus Data Format</b>
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <b>Defined License</b>
                                        </li>
                                    </ul>

                                </div>
                            @endif

                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div role="tabpanel"  class="tab-pane fade in" id="messageBoard">
             messageboard
        </div>
        <div role="tabpanel"  class="tab-pane fade in" id="corpusCollaborators">
            collabs
        </div>
    </div>

@endsection