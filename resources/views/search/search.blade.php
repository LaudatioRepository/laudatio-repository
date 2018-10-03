@extends('layouts.search_ux')

@section('content')
    <div id="searchApp">
        <div class="container-fluid bg-corpus-light">
            <div class="serviceBar withSearch container d-flex justify-content-between align-items-center py-3">

                <div class="container">
                    <div class="row">
                        <div class="col-6 d-flex justify-content-center align-items-center ml-auto mr-auto">

                            <form class="form-group serviceBarSearch w-100">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search metadata (German or English)" aria-label="search metadata"
                                           aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button type="button" class="clear-search close" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <button class="btn btn-outline-corpus-dark pl-4 pr-4" type="button">
                                            <i class="text-primary fa fa-fw fa-search fa-lg "></i>
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <i class="btn p-0 fa fa-info-circle fa-fw fa-lg ml-3" data-toggle="tooltip" role="button" data-placement="bottom"
                               title="Get help how to search"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="container-fluid">
            <div class="container">
                <div class="row mt-5">
                    <searchfilterwrapper></searchfilterwrapper>
                    <searchresultwrapper></searchresultwrapper>
                </div>

            </div>

        </div>
    </div>
@endsection
