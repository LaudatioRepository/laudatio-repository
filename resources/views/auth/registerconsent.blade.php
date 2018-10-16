    @extends('layouts.auth_ux')

@section('content')


    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-8 offset-2">


                    <div class="d-flex justify-content-between mt-7 mb-3">
                        <h3 class="h3 font-weight-normal">Registration step 3/3 - Laudatio terms of use</h3>
                    </div>

                    <h6 class="font-weight-bold mt-6">
                        §1 Dolor sit amet
                    </h6>
                    <br />
                    <p>
                        Nullam volutpat consequat justo ut scelerisque. Curabitur et gravida eros. Sed vehicula pretium feugiat.
                        Curabitur consequat neque arcu, vel sollicitudin dui maximus nec. Aliquam rhoncus dui
                        sit amet odio dapibus dapibus. Donec non tortor eget sapien elementum hendrerit ac et
                        lorem. Vivamus a lacinia mi. Quisque eu leo tortor. Maecenas euismod sem id eros tincidunt
                        finibus. Aenean sit amet nulla ut mauris congue tincidunt ut eget turpis. Sed suscipit
                        posuere lacus in fringilla. Maecenas odio enim, suscipit a cursus ut, pharetra eu arcu.
                        Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis
                        egestas. Quisque at faucibus ipsum, a scelerisque tortor. Vivamus sit amet eros eget
                        felis fringilla rhoncus eget eget magna.
                    </p>

                    <h6 class="font-weight-bold mt-6">
                        §2 Dolor sit amet
                    </h6>
                    <br />
                    <p>
                        Nullam volutpat consequat justo ut scelerisque. Curabitur et gravida eros. Sed vehicula pretium feugiat.
                        Curabitur consequat neque arcu, vel sollicitudin dui maximus nec. Aliquam rhoncus dui
                        sit amet odio dapibus dapibus. Donec non tortor eget sapien elementum hendrerit ac et
                        lorem. Vivamus a lacinia mi. Quisque eu leo tortor. Maecenas euismod sem id eros tincidunt
                        finibus. Aenean sit amet nulla ut mauris congue tincidunt ut eget turpis. Sed suscipit
                        posuere lacus in fringilla. Maecenas odio enim, suscipit a cursus ut, pharetra eu arcu.
                        Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis
                        egestas. Quisque at faucibus ipsum, a scelerisque tortor. Vivamus sit amet eros eget
                        felis fringilla rhoncus eget eget magna.
                    </p>

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="toBeValidated-checkbox custom-control-input" value="" id="registerCheck_2">
                                <label class="custom-control-label font-weight-normal text-14" for="registerCheck_2">
                                    I agree with Laudatio terms of use
                                </label>
                            </div>
                            <div class="form-row mt-5">
                                <div class="col">
                                    <a href="registration_withDFNAAI_2.html" class="btn btn-outline-corpus-mid text-uppercase font-weight-bold rounded w-100">Back</a>
                                </div>
                                <div class="col">
                                    <a href="registration_success.html" class="toCheckValidation disabled btn btn-primary rounded text-uppercase font-weight-bold w-100">Finish registration</a>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection