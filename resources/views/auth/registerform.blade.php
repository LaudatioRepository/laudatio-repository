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
                                <small>Name <span style="color: red">*</span></small>
                            </label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" >
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>


                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} mt-3">
                            <label class="text-14 text-dark-trans mb-1 pl-3" for="email">
                                <small>Your GitLab / HU email address <span style="color: red">*</span></small>
                            </label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" >
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('gitlab_ssh_pubkey') ? ' has-error' : '' }} mt-3">
                            <label class="text-14 text-dark-trans mb-1 pl-3" for="gitlab_ssh_pubkey">
                                <small>Your SSH public key <span style="color: red">*</span></small>
                            </label>
                            <textarea id="gitlab_ssh_pubkey" class="form-control" name="gitlab_ssh_pubkey">{{ old('gitlab_ssh_pubkey') }}</textarea>

                            @if ($errors->has('gitlab_ssh_pubkey'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('gitlab_ssh_pubkey') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('affiliation') ? ' has-error' : '' }} mt-3">
                            <label class="text-14 text-dark-trans mb-1 pl-3" for="affiliation">
                                <small>Your Affiliation <span style="color: red">*</span></small>
                            </label>

                            <input id="affiliation" type="text" class="form-control" name="affiliation" value="{{ old('affiliation') }}" >

                            @if ($errors->has('affiliation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('affiliation') }}</strong>
                                </span>
                            @endif
                        </div>


                        <div class="form-group{{ $errors->has('laudatiopassword') ? ' has-error' : '' }} mt-3">
                            <label class="text-14 text-dark-trans mb-1 pl-3" for="laudatiopassword">
                                <small>Password <span style="color: red">*</span></small>
                            </label>
                            <input type="password" class="form-control" id="laudatiopassword" name="laudatiopassword" >
                            @if ($errors->has('laudatiopassword'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('laudatiopassword') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group mt-3">
                            <label class="text-14 text-dark-trans mb-1 pl-3" for="laudatiopassword_confirmation">
                                <small>Confirm Password <span style="color: red">*</span></small>
                            </label>
                            <input id="laudatiopassword_confirmation" type="password" class="form-control" name="laudatiopassword_confirmation" >
                            @if ($errors->has('laudatiopassword_confirmation'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('laudatiopassword_confirmation') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <br/>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="toBeValidated-checkbox custom-control-input" value="1" id="gitlab-use-check">
                            <label class="custom-control-label font-weight-normal text-14" for="gitlab-use-check">
                                Laudatio is allowed to use my GitLab account data. This entails my, by GitLab registered email, commit information and roles. <span style="color: red">*</span>
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
