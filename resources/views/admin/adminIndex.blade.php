@extends('layouts.admin_ux', ['isLoggedIn' => $isLoggedIn])

@section('content')
    <div class="container-fluid">
        <div class="container">
            <div class="row mt-5">

                <div class="col-3 mt-2">
                    <nav class="sidebar text-14 nav flex-column border-top border-light mt-7" role="navigation">
                        <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link active" href="publish_projects.html">Corpus projects</a>
                        <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link" href="publish_invitations.html">Invitations</a>
                        <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link " href="publish_initiate.html">Initiate Project</a>
                    </nav>
                </div>

                <div class="col">
                    <div class="d-flex justify-content-between  ">
                        <h3 class="h3 font-weight-normal">Corpus Projects (2)</h3>
                    </div>

                    <div class="mt-4">
                        <div id="corpusProject_0001" class="corpusProject container bg-bluegrey-middark mt-1 mb-1 p-5">
                            <div class="row corpusProject-save">
                                <div class="col">
                                    <small class="text-14 text-grey">
                                        Corpus Project
                                    </small>

                                    <h4 class="h4 font-weight-bold corpusProject-title">
                                        Register in Diachronic German Science
                                    </h4>
                                    <div class="mt-2">
                                        <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                            <i class="fa fa-user fa-lg mr-2"></i>
                                            <span>
    Amir Zeldes (Corpus Project Administrator)
  </span>
                                        </div></div>

                                    <p class="mt-3 text-14 mb-0 corpusProject-description">
                                        Morbi lobortis rhoncus risus nec faucibus. Morbi a aliquam ligula. Maecenas placerat, lorem ac mollis
                                        suscipit, ante ex convallis massa, id mollis magna lacus vitae odio. Morbi eget augue ante. Nullam
                                        sit amet hendrerit enim, a hendrerit mauris. Morbi sem elit, ultrices vitae convallis vitae,
                                        ultricies ut arcu. Vestibulum feugiat faucibus ex, eget vehicula libero. Donec mattis magna vitae
                                        risus porta, et fermentum diam suscipit. Duis a tempor justo, vel facilisis orci. Etiam pulviar
                                        dolor non felis gravida tristique. In hac habitasse platea dictumst.
                                    </p>

                                </div>
                                <div class="col-2 p-0 mr-2">
                                    <button class="corpusProject-startEdit btn btn-outline-corpus-dark font-weight-bold text-uppercase rounded mb-4 w-100">
                                        Edit project
                                    </button>
                                    <a href="adminEdit_corpus-new.html" class="btn btn-outline-corpus-dark font-weight-bold text-uppercase rounded mb-4 w-100">
                                        Add Corpus
                                    </a>
                                </div>
                            </div>
                            <div class="row corpusProject-edit hidden">
                                <form id="editCorpusProject" class="w-100">
                                    <div class="form-group">
                                        <label class="text-14 text-dark-trans mb-1 pl-3" for="editCorpusProject_Title">
                                            <small>Corpus Project title</small>
                                        </label>
                                        <input type="text" class="corpusProject-title-edit form-control" id="editCorpusProject_Title" required
                                               placeholder="What's the project title?">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label class="text-14 text-dark-trans mb-1 pl-3" for="editCorpusProject_Description">
                                            <small>Corpus Project description</small>
                                        </label>
                                        <textarea id="editCorpusProject_Description" class="corpusProject-description-edit form-control py-3"
                                                  cols="30" rows="8" placeholder="here you can describe the purpose of your project. We recommend between 300 and max. 500 chars."></textarea>
                                    </div>
                                    <div class="form-row mt-3">
                                        <div class="col offset-7">
                                            <button class="corpusProject-endEdit btn btn-outline-corpus-mid text-uppercase font-weight-bold rounded w-100">Cancel</button>
                                        </div>
                                        <div class="col">
                                            <button class="corpusProject-saveEdit btn btn-primary rounded text-uppercase font-weight-bold w-100">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div> <div class="container bg-bluegrey-midlight mt-1 mb-1 p-5">
                            <div class="row">
                                <div class="col-2 pl-4">
                                    <img class="w-100" src="./dist/images/placeholder_circle.svg" alt="circle-image">
                                </div>
                                <div class="col">
                                    <small class="text-14 text-grey">
                                        Corpus
                                    </small>
                                    <h4 class="h4 font-weight-bold">
                                        <a class="text-dark" href="adminEdit_corpus.html">
                                            RIDGES-Herbology Version 9.0
                                        </a>
                                    </h4>
                                    <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                        <i class="fa fa-user fa-lg mr-2"></i>
                                        <span>
    Amir Zeldes (Corpus Project Administrator)
  </span>
                                    </div>

                                </div>
                                <div class="col-2 p-0 mr-2">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-corpus-dark dropdown-toggle font-weight-bold text-uppercase rounded mb-4 w-100 text-left"
                                                type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Edit
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item text-14" href="adminEdit_corpus.html">Edit Corpus</a>
                                            <a class="dropdown-item text-14" href="adminPreview_corpus.html">Preview Corpus</a>
                                            <a class="dropdown-item text-14" href="#" data-toggle="modal" data-target="#publishCorpusModal">Publish Corpus</a>
                                            <a class="dropdown-item text-14" href="#" data-toggle="modal" data-target="#deleteCorpusModal">Delete Corpus</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div> <div class="container bg-bluegrey-midlight mt-1 mb-1 p-5">
                            <div class="row">
                                <div class="col-2 pl-4">
                                    <img class="w-100" src="./dist/images/placeholder_circle.svg" alt="circle-image">
                                </div>
                                <div class="col">
                                    <small class="text-14 text-grey">
                                        Corpus
                                    </small>
                                    <h4 class="h4 font-weight-bold">
                                        <a class="text-dark" href="adminEdit_corpus.html">
                                            RIDGES-Herbology Version 9.0
                                        </a>
                                    </h4>
                                    <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                        <i class="fa fa-user fa-lg mr-2"></i>
                                        <span>
    Amir Zeldes (Corpus Project Administrator)
  </span>
                                    </div>

                                </div>
                                <div class="col-2 p-0 mr-2">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-corpus-dark dropdown-toggle font-weight-bold text-uppercase rounded mb-4 w-100 text-left"
                                                type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Edit
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item text-14" href="adminEdit_corpus.html">Edit Corpus</a>
                                            <a class="dropdown-item text-14" href="adminPreview_corpus.html">Preview Corpus</a>
                                            <a class="dropdown-item text-14" href="#" data-toggle="modal" data-target="#publishCorpusModal">Publish Corpus</a>
                                            <a class="dropdown-item text-14" href="#" data-toggle="modal" data-target="#deleteCorpusModal">Delete Corpus</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div> <div class="container bg-bluegrey-midlight mt-1 mb-1 p-5">
                            <div class="row">
                                <div class="col-2 pl-4">
                                    <img class="w-100" src="./dist/images/placeholder_circle.svg" alt="circle-image">
                                </div>
                                <div class="col">
                                    <small class="text-14 text-grey">
                                        Corpus
                                    </small>
                                    <h4 class="h4 font-weight-bold">
                                        <a class="text-wine-trans" href="adminEdit_corpus-new.html">
                                            no name defined yet
                                        </a>
                                    </h4>
                                    <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                        <i class="fa fa-user fa-lg mr-2"></i>
                                        <span>
    Amir Zeldes (Corpus Project Administrator)
  </span>
                                    </div>

                                </div>
                                <div class="col-2 p-0 mr-2">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-corpus-dark dropdown-toggle font-weight-bold text-uppercase rounded mb-4 w-100 text-left"
                                                type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Edit
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item text-14" href="adminEdit_corpus-new.html">Edit Corpus</a>
                                            <a class="dropdown-item text-14" href="adminPreview_corpus.html">Preview Corpus</a>
                                            <a class="dropdown-item text-14" href="#" data-toggle="modal" data-target="#publishCorpusModal">Publish Corpus</a>
                                            <a class="dropdown-item text-14" href="#" data-toggle="modal" data-target="#deleteCorpusModal">Delete Corpus</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="mt-10">
                        <div class="container bg-bluegrey-middark mt-1 mb-1 p-5">
                            <div class="row">
                                <div class="col-9">
                                    <small class="text-14 text-grey">
                                        Corpus Project
                                    </small>
                                    <h4 class="h4 font-weight-bold">
                                        Register in Diachronic German Science
                                    </h4>
                                    <div class="mt-2">
                                        <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                            <i class="fa fa-user fa-lg mr-2"></i>
                                            <span>
    Amir Zeldes (Corpus Project Administrator)
  </span>
                                        </div></div>

                                    <p class="mt-3 text-14 mb-0">
                                        Morbi lobortis rhoncus risus nec faucibus. Morbi a aliquam ligula. Maecenas placerat, lorem ac mollis
                                        suscipit, ante ex convallis massa, id mollis magna lacus vitae odio. Morbi eget augue ante. Nullam
                                        sit amet hendrerit enim, a hendrerit mauris. Morbi sem elit, ultrices vitae convallis vitae,
                                        ultricies ut arcu. Vestibulum feugiat faucibus ex, eget vehicula libero. Donec mattis magna vitae
                                        risus porta, et fermentum diam suscipit. Duis a tempor justo, vel facilisis orci. Etiam pulvinar
                                        dolor non felis gravida tristique. In hac habitasse platea dictumst.
                                    </p>

                                </div>
                            </div>

                        </div> <div class="container bg-bluegrey-midlight mt-1 mb-1 p-5">
                            <div class="row">
                                <div class="col-2 pl-4">
                                    <img class="w-100" src="./dist/images/placeholder_circle.svg" alt="circle-image">
                                </div>
                                <div class="col">
                                    <small class="text-14 text-grey">
                                        Corpus
                                    </small>
                                    <h4 class="h4 font-weight-bold">
                                        <a class="text-dark" href="adminEdit_corpus.html">
                                            RIDGES-Herbology Version 9.0
                                        </a>
                                    </h4>
                                    <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                        <i class="fa fa-user fa-lg mr-2"></i>
                                        <span>
    Amir Zeldes (Corpus Project Administrator)
  </span>
                                    </div>

                                </div>
                                <div class="col-2 p-0 mr-2">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-corpus-dark dropdown-toggle font-weight-bold text-uppercase rounded mb-4 w-100 text-left"
                                                type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Edit
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item text-14" href="adminEdit_corpus.html">Edit Corpus</a>
                                            <a class="dropdown-item text-14" href="adminPreview_corpus.html">Preview Corpus</a>
                                            <a class="dropdown-item text-14" href="#" data-toggle="modal" data-target="#publishCorpusModal">Publish Corpus</a>
                                            <a class="dropdown-item text-14" href="#" data-toggle="modal" data-target="#deleteCorpusModal">Delete Corpus</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div> <div class="container bg-bluegrey-midlight mt-1 mb-1 p-5">
                            <div class="row">
                                <div class="col-2 pl-4">
                                    <img class="w-100" src="./dist/images/placeholder_circle.svg" alt="circle-image">
                                </div>
                                <div class="col">
                                    <small class="text-14 text-grey">
                                        Corpus
                                    </small>
                                    <h4 class="h4 font-weight-bold">
                                        <a class="text-dark" href="adminEdit_corpus.html">
                                            RIDGES-Herbology Version 9.0
                                        </a>
                                    </h4>
                                    <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                        <i class="fa fa-user fa-lg mr-2"></i>
                                        <span>
    Amir Zeldes (Corpus Project Administrator)
  </span>
                                    </div>

                                </div>
                                <div class="col-2 p-0 mr-2">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-corpus-dark dropdown-toggle font-weight-bold text-uppercase rounded mb-4 w-100 text-left"
                                                type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Edit
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item text-14" href="adminEdit_corpus.html">Edit Corpus</a>
                                            <a class="dropdown-item text-14" href="adminPreview_corpus.html">Preview Corpus</a>
                                            <a class="dropdown-item text-14" href="#" data-toggle="modal" data-target="#publishCorpusModal">Publish Corpus</a>
                                            <a class="dropdown-item text-14" href="#" data-toggle="modal" data-target="#deleteCorpusModal">Delete Corpus</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

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