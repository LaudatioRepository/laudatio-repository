@extends('layouts.search_ux')

@section('content')
    <div id="searchApp">
        <div class="container-fluid bg-corpus-light">
            <div class="serviceBar withSearch container d-flex justify-content-between align-items-center py-3">

                <div class="container">
                    <div class="row">
                        <generalsearchwrapper  v-on:searchedgeneral="askElastic"></generalsearchwrapper>
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
