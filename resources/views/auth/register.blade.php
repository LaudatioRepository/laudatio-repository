@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('affiliation') ? ' has-error' : '' }}">
                            <label for="affiliation" class="col-md-4 control-label">Affiliation</label>

                            <div class="col-md-6">
                                <input id="affiliation" type="tex" class="form-control" name="affiliation" value="{{ old('affiliation') }}" required>

                                @if ($errors->has('affiliation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('affiliation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-footer">
                    <span class="form-group">
                        <label for="name" class="col-md-4 control-label">Register With</label>
                        <a href="https://gitlab.com/users/sign_in"><div id="gitlab-login-button" ng-click="$ctrl.oauthLogin('gitlab')" role="button" class="btn btn-success btn-signup"><svg width="18px" height="16px" viewBox="0 0 18 16" version="1.1"><g stroke="none" stroke-width="1" fill-rule="evenodd"><g transform="translate(-772.000000, -229.000000)"><g transform="translate(110.000000, 212.000000)"><g transform="translate(609.000000, 0.000000)"><g transform="translate(53.000000, 14.000000)"><g transform="translate(9.000000, 11.000000) scale(1, -1) translate(-9.000000, -11.000000) translate(0.000000, 3.000000)"><path d="M17.8120288,6.83207372 L16.8158018,9.81465593 L14.8414223,15.7259463 C14.7398669,16.0300608 14.2975438,16.0300608 14.1959401,15.7259463 L12.2215125,9.81465593 L5.66523085,9.81465593 L3.69075502,15.7259463 C3.58919953,16.0300608 3.14687646,16.0300608 3.04527277,15.7259463 L1.07089333,9.81465593 L0.0747144813,6.83207372 C-0.0161890077,6.56003046 0.0833903182,6.26201137 0.321252841,6.09387159 L8.94334756,0 L17.5654905,6.09387159 C17.803353,6.26201137 17.9028841,6.56003046 17.8120288,6.83207372" fill="#E7643E"></path><polygon fill-opacity="0.949999988" points="8.92512396 0.00926657387 8.92512396 0.00926657387 12.2032889 9.8239225 5.64695906 9.8239225 8.92512396 0.00926657387"></polygon><polygon fill-opacity="0.75" points="8.92512396 0.00924778843 5.64695907 9.82385683 1.05266973 9.82385683 8.92512396 0.00924778843"></polygon><path d="M1.05266973,9.82384278 L1.05266973,9.82384278 L0.0564426844,6.84126052 C-0.0344126057,6.5692173 0.0651185209,6.27119821 0.303029243,6.10310532 L8.92512396,0.00923372572 L1.05266973,9.82384278 L1.05266973,9.82384278 L1.05266973,9.82384278 Z" fill-opacity="0.5"></path><path d="M1.03579715,9.83615369 L5.63008647,9.83615369 L3.65565884,15.7474441 C3.55405515,16.0516055 3.11173208,16.0516055 3.01017659,15.7474441 L1.03579715,9.83615369 L1.03579715,9.83615369 L1.03579715,9.83615369 Z"></path><polygon fill-opacity="0.75" points="8.92512396 0.00924778843 12.2032889 9.82385683 16.7975782 9.82385683 8.92512396 0.00924778843"></polygon><path d="M16.7975734,9.82384278 L16.7975734,9.82384278 L17.7938004,6.84126052 C17.8846557,6.5692173 17.7851246,6.27119821 17.5472139,6.10310532 L8.92511914,0.00923372572 L16.7975734,9.82384278 L16.7975734,9.82384278 L16.7975734,9.82384278 Z" fill-opacity="0.5"></path><path d="M16.8166957,9.83615369 L12.2224064,9.83615369 L14.196834,15.7474441 C14.2984377,16.0516055 14.7407608,16.0516055 14.8423163,15.7474441 L16.8166957,9.83615369 L16.8166957,9.83615369 L16.8166957,9.83615369 Z"></path></g></g></g></g></g></g></svg> <span class="txt">GitLab</span></div></a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
