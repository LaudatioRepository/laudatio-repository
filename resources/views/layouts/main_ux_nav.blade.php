<nav class="navbar navbar-expand-lg navbar-light bg-white bsh-1 px-1 py-0">
    <div class="container">
        <a class="navbar-brand" href="{{ route('frontpage') }}">
            <img src="{{ asset('images/logo-laudatio.svg') }}" alt="logo laudatio">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar" aria-controls="mainNavbar"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active text-14 font-weight-bold">
                    <a class="nav-link px-5 pt-4 pb-3 text-dark text-uppercase" href="{{ route('browse') }}">Published Corpora</a>
                </li>
                <li class="nav-item text-14 font-weight-bold ">
                    <a class="nav-link px-5 pt-4 pb-3 text-dark text-uppercase" href="{{ route('search') }}">Search</a>
                </li>
                <li class="nav-item text-14 font-weight-bold ">
                    <a class="nav-link px-5 pt-4 pb-3 text-dark text-uppercase" href="{{ route('project.corpusProject.index') }}">Publish</a>
                </li>
                <li class="nav-item text-14 font-weight-bold ">
                    <a class="nav-link px-5 pt-4 pb-3 text-dark text-uppercase" href="#">Help</a>
                </li>
            </ul>

            @if (Auth::guest())
            <div class="nav-item text-14 font-weight-bold ">
                <a class="nav-link px-5 pt-4 pb-3 text-dark text-uppercase" href="{{ route('register') }}">Register</a>
            </div>
            <button type="button" data-toggle="modal" data-target="#signInModal" class="btn btn-outline-corpus-dark ml-1 font-weight-bold text-14 rounded text-dark text-uppercase">
                Sign In
            </button>
            @else
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item  text-14 font-weight-bold  dropdown">
                        <a class="nav-link px-5 pt-4 pb-3 text-dark text-uppercase dropdown-toggle" href="#" id="navlink-user"
                           role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{Auth::user()->name}}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item text-14" href="{{ route('logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                </ul>
            @endif

        </div>
    </div>

    <div class="modal fade" id="signInModal" tabindex="-1" role="dialog" aria-labelledby="signInModal" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content border-0 rounded-lg bsh-1">
                <form class="form-horizontal" id="signInForm" role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="modal-body px-4">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-close" aria-hidden="true"></i>
                        </button>
                        <h3 class="h3 modal-title mt-3">Sign in</h3>
                        <div id="login-error-message" class="alert alert-danger" role="alert"></div>
                        <div class="form-group mt-3">
                            <label for="email" class="text-14 text-dark-trans mb-0 pl-3">
                                <small>DFN-AAI or Dariah Username / Email</small>
                            </label>
                            <input id="email" type="text" class="toBeValidated form-control" name="email" value="{{ old('email') }}" required autofocus>

                        </div>

                        <div class="form-group mt-2">
                            <label class="text-14 text-dark-trans mb-0 pl-3" for="password">
                                <small>Password</small>
                            </label>
                            <input id="password" type="password" class="toBeValidated form-control" name="password" required>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>
                        <p class="mt-4">
                                <span>No account yet?
                                  <a href="{{ route('register') }}">
                                    Register
                                  </a>
                                </span>
                            <br />
                            <span>Forgot Your Password?
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Help
                                </a>
                            </span>
                        </p>
                    </div>
                    <div class="modal-footer bg-corpus-light px-4 rounded-lg-bt">
                        <button type="submit" class="toCheckValidation disabled btn btn-primary rounded text-uppercase font-weight-bold w-30 float-right">
                            Login
                        </button>
                        <!--a href="{{ route('dashboard') }}" class="toCheckValidation disabled btn btn-primary rounded text-uppercase font-weight-bold w-30 float-right">Login</a-->
                    </div>
                </form>
            </div>
        </div>
    </div>
</nav>