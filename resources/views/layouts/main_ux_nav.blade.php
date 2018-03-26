<nav class="navbar navbar-expand-lg navbar-light bg-white bsh-1 px-1 py-0">
    <div class="container">
        <a class="navbar-brand" href="index.html">
            <img src="{{ asset('images/logo-laudatio.svg') }}" alt="logo laudatio">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar" aria-controls="mainNavbar"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active text-14 font-weight-bold">
                    <a class="nav-link px-5 pt-4 pb-3 text-dark text-uppercase" href="exploreCorpora.html">Published Corpora</a>
                </li>
                <li class="nav-item text-14 font-weight-bold ">
                    <a class="nav-link px-5 pt-4 pb-3 text-dark text-uppercase" href="search_List.html">Search</a>
                </li>
                <li class="nav-item text-14 font-weight-bold ">
                    <a class="nav-link px-5 pt-4 pb-3 text-dark text-uppercase" href="publish_notSignedIn.html">Publish</a>
                </li>
                <li class="nav-item text-14 font-weight-bold ">
                    <a class="nav-link px-5 pt-4 pb-3 text-dark text-uppercase" href="#">Help</a>
                </li>
            </ul>

            <div class="nav-item text-14 font-weight-bold ">
                <a class="nav-link px-5 pt-4 pb-3 text-dark text-uppercase" href="registration_start.html">Register</a>
            </div>
            <button type="button" data-toggle="modal" data-target="#signInModal" class="btn btn-outline-corpus-dark ml-1 font-weight-bold text-14 rounded text-dark text-uppercase">
                Sign In
            </button>

        </div>
    </div>
    <div class="modal fade" id="signInModal" tabindex="-1" role="dialog" aria-labelledby="signInModal" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content border-0 rounded-lg bsh-1">

                <form id="signInForm">
                    <div class="modal-body px-4">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-close" aria-hidden="true"></i>
                        </button>
                        <h3 class="h3 modal-title mt-3">Sign in</h3>

                        <div class="form-group mt-3">
                            <label class="text-14 text-dark-trans mb-0 pl-3" for="signIn_Username">
                                <small>DFN-AAI or Dariah Username</small>
                            </label>
                            <input type="text" class="toBeValidated form-control" id="signIn_Username" placeholder='"test@dfnaai.de"'
                                   required>
                        </div>
                        <div class="form-group mt-2">
                            <label class="text-14 text-dark-trans mb-0 pl-3" for="signIn_Password">
                                <small>Password</small>
                            </label>
                            <input type="password" class="toBeValidated form-control" id="signIn_Password" placeholder="" required>
                        </div>
                        <p class="mt-4">
                                <span>No account yet?
                                  <a href="#">
                                    Register
                                  </a>
                                </span>
                            <br />
                            <span>Forgot your password?
                                  <a href="#">
                                    Help
                                  </a>
                                </span>
                        </p>

                    </div>
                    <div class="modal-footer bg-corpus-light px-4 rounded-lg-bt">
                        <a href="index_signedIn.html" class="toCheckValidation disabled btn btn-primary rounded text-uppercase font-weight-bold w-30 float-right">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</nav>