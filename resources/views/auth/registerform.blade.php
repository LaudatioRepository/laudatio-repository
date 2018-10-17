@extends('layouts.auth_ux')

@section('content')
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-6 offset-2">


                    <div class="d-flex justify-content-between mt-7 mb-3">
                        <h3 class="h3 font-weight-normal">Registration step 2/3</h3>
                    </div>

                    <form role="form" method="POST" action="{{ route('registerconsent') }}" class="w-65">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} mt-3">
                            <label class="text-14 text-dark-trans mb-1 pl-3" for="name">
                                <small>Name</small>
                            </label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>


                        <div class="form-group{{ $errors->has('gitlabemail') ? ' has-error' : '' }} mt-3">
                            <label class="text-14 text-dark-trans mb-1 pl-3" for="email">
                                <small>Your GitLab / HU email address</small>
                            </label>
                            <input id="gitlabemail" type="email" class="form-control" name="gitlabemail" value="{{ old('gitlabemail') }}" required>
                                @if ($errors->has('gitlabemail'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gitlabemail') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('ssh-key') ? ' has-error' : '' }} mt-3">
                            <label class="text-14 text-dark-trans mb-1 pl-3" for="ssh-key">
                                <small>Your SSH public key</small>
                            </label>
                            <textarea id="ssh-key" type="tex" class="form-control" name="ssh-key" value="{{ old('ssh-key') }}" required></textarea>

                            @if ($errors->has('ssh-key'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ssh-key') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('affiliation') ? ' has-error' : '' }} mt-3">
                            <label class="text-14 text-dark-trans mb-1 pl-3" for="affiliation">
                                <small>Your Affiliation</small>
                            </label>

                            <input id="affiliation" type="text" class="form-control" name="affiliation" value="{{ old('affiliation') }}" required>

                            @if ($errors->has('affiliation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('affiliation') }}</strong>
                                </span>
                            @endif
                        </div>


                        <div class="form-group{{ $errors->has('laudatio-password') ? ' has-error' : '' }} mt-3">
                            <label class="text-14 text-dark-trans mb-1 pl-3" for="laudatio-password">
                                <small>Password</small>
                            </label>
                            <input type="password" class="form-control" id="laudatio-password" name="laudatio-password" required>
                            @if ($errors->has('laudatio-password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('laudatio-password') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group mt-3">
                            <label class="text-14 text-dark-trans mb-1 pl-3" for="password-confirm">
                                <small>Confirm Password</small>
                            </label>
                            <input id="password-confirm" type="password" class="form-control" name="password-confirm" required>
                        </div>

                        <br/>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="toBeValidated-checkbox custom-control-input" value="1" id="gitlab-use-check">
                            <label class="custom-control-label font-weight-normal text-14" for="gitlab-use-check">
                                Laudatio is allowed to use my GitLab account data. This entails my, by GitLab registered email, commit information and roles
                            </label>
                        </div>

                        <div class="form-row mt-5">
                            <div class="col">
                                    <input type="submit" class="toCheckValidation disabled btn btn-primary rounded text-uppercase font-weight-bold w-100" value="Continue to Terms Of Use" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
