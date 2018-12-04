@extends('layouts.project_ux', ['isLoggedIn' => $isLoggedIn])
@section('content')

        <div class="container-fluid">
            <div class="container">
                <div class="row mt-5">
                    <div class="col-3 mt-2">
                        <nav class="sidebar text-14 nav flex-column border-top border-light mt-7" role="navigation">
                            <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link" href="{{ route('corpusProject.index') }}">Corpus projects</a>
                            <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link active" href="{{ route('corpusProject.invitations') }}">Invitations</a>
                            <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link" href="{{ route('corpusProject.create') }}">Initiate Project</a>
                        </nav>
                    </div>

                    <div class="col">
                        <div class="d-flex justify-content-between  ">
                            <h3 class="h3 font-weight-normal">Corpus Projects (2)</h3>
                        </div>

                        <div class="mt-4">
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
                                        <img class="w-100" src="/images/placeholder_circle.svg" alt="circle-image">
                                    </div>
                                    <div class="col">
                                        <small class="text-14 text-grey">
                                            Corpus Project
                                        </small>
                                        <h4 class="h4 font-weight-bold">
                                            <a class="text-dark" href="adminPreview_corpus.html">
                                                Register in Diachronic German Science
                                            </a>
                                        </h4>
                                        <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                            <i class="fa fa-user fa-lg mr-2"></i>
                                            <span>
    Amir Zeldes (Corpus Project Administrator)
  </span>
                                        </div>

                                    </div>
                                    <div class="col-2 mr-4">
                                        <button class="btn btn-primary font-weight-bold text-uppercase rounded mb-4">
                                            Accept Invite
                                        </button>
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
                                        <img class="w-100" src="/images/placeholder_circle.svg" alt="circle-image">
                                    </div>
                                    <div class="col">
                                        <small class="text-14 text-grey">
                                            Corpus Project
                                        </small>
                                        <h4 class="h4 font-weight-bold">
                                            <a class="text-dark" href="adminPreview_corpus.html">
                                                Register in Diachronic German Science
                                            </a>
                                        </h4>
                                        <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                            <i class="fa fa-user fa-lg mr-2"></i>
                                            <span>
    Amir Zeldes (Corpus Project Administrator)
  </span>
                                        </div>

                                    </div>
                                    <div class="col-2 mr-4">
                                        <button class="btn btn-primary font-weight-bold text-uppercase rounded mb-4">
                                            Accept Invite
                                        </button>
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