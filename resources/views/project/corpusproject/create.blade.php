@extends('layouts.project_ux', ['isLoggedIn' => $isLoggedIn])
@section('content')

        <div class="container-fluid">
            <div class="container">
                <div class="row mt-5">
                    <div class="col-3 mt-2">
                        <nav class="sidebar text-14 nav flex-column border-top border-light mt-7" role="navigation">
                            <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link" href="{{ route('corpusProject.index') }}">Corpus projects</a>
                            <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link" href="{{ route('corpusProject.invitations') }}">Invitations</a>
                            <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link active">Initiate Project</a>
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
                            <h3 class="h3 font-weight-normal">Initiate a new Corpus Project</h3>
                        </div>
                        <div class="mt-4">
                            <p>
                                Every Laudatio member is allowed to initiate a new Corpus Project. The Person who is initiating, will
                                be in the role of a Project Corpus Administrator and will have wide range of editing
                                rights following resposibilities: Lorem ipsum dolor sit amet, consetetur sadipscing
                                elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,
                                sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.
                                <a href="#">more details</a>
                            </p>
                            <p>
                                Please describe your new corpus project. The Laudatio Team will check it and will get in touch with you
                                for upcoming steps.
                            </p>
                        </div>


                        <div class="card border-0 mt-7">
                            <div class="card-body bg-bluegrey-dark p-5 ">
                                <form action="/corpusprojects/createproject" id="editCorpusProject" method="post">
                                        {{ csrf_field() }}
                                    <div class="form-group">
                                        <label class="text-14 text-dark-trans mb-1 pl-3" for="corpusproject_name">
                                            <small>Corpus Project title <span style="color: red">*</span></small>
                                        </label>
                                        <input type="text" class="form-control" id="corpusproject_name" name="corpusproject_name" required placeholder="What's the project title?">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label class="text-14 text-dark-trans mb-1 pl-3" for="editCorpusProject_Description">
                                            <small>Corpus Project description <span style="color: red">*</span></small>
                                        </label>
                                        <textarea id="corpusproject_description" name="corpusproject_description" class="form-control py-3" cols="30" rows="8" placeholder="here you can describe the purpose of your project. We recommend between 300 and max. 500 chars."></textarea>
                                    </div>
                                    <div class="form-row mt-3">
                                        <div class="col offset-7">
                                            <a href="#" class="btn btn-outline-corpus-mid text-uppercase font-weight-bold rounded w-100">Cancel</a>
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary rounded text-uppercase font-weight-bold w-100">Initiate</button>
                                            <!--a href="#" class="btn btn-primary rounded text-uppercase font-weight-bold w-100">Initiate</a-->
                                        </div>
                                    </div>
                                </form>
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