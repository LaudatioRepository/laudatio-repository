@extends('layouts.main_ux')

@section('content')
    <div class="home-fold container-fluid" style="background-image: url({{ asset('images/placeholder_header.jpg') }});">
        <div class="container h-100 d-flex flex-column align-items-center justify-content-center">
            <div class="row w-100 mb-4">
                <div class="col-3 ml-auto mr-auto">
                    <img class="w-100" src="{{ asset('images/logo-laudatio.svg') }}" alt="">
                </div>
            </div>
            <div class="row w-100">
                <div class="col-6 offset-3">
                    <h3 class="h2 font-weight-normal mb-5 text-center">
                        <strong>L</strong>ong-term
                        <strong>A</strong>ccess and
                        <strong>U</strong>sage of
                        <strong>D</strong>eeply
                        <strong>A</strong>nno
                        <strong>t</strong>ated
                        <strong>I</strong>nformation
                    </h3>
                </div>
            </div>
            <div class="w-100 mt-3">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-5 ml-auto mr-auto">


                            <form class="home-fold-search bsh-2 form-group p-1 rounded bg-white ">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search metadata (German or English)" aria-label="search metadata"
                                           aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <span class="text-secondary m-0 h3 font-weight-normal bg-white">|</span>
                                        <button class="btn btn-outline-secondary pl-3 pr-3" type="button">
                                            <i class="text-primary fa fa-fw fa-search "></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="container">
            <div class="row my-5 pt-5 pb-3">
                <div class="col">

                    <div class="homeCarousel matchedHeight">
                        @if (null != $corpusdata)
                            <ul class="homeCarouselContainer px-4">
                                @foreach($corpusdata as $index => $corpus)
                                    <li class="homeCarouselSlide">
                                        <div class="card bg-corpus-superlight border-0 px-4 pb-7">
                                            <div class="card-body p-6">
                                                <div class="d-flex flex-column align-items-center">
                                                    @if (isset($corpus['corpus_logo']) && $corpus['corpus_logo'] != "")
                                                        <img class="w-30" src="/images/corpuslogos/{{$corpus['corpus_project_directorypath']}}_{{$corpus['corpus_directorypath']}}_{{$corpus['corpus_logo']}}" alt="corpus-logo">
                                                    @else
                                                        <img class="rounded-circle w-30 bg-white" src="{{ asset('images/placeholder_flower.svg') }}" alt="circle-image">
                                                    @endif

                                                    <div class="h4 font-weight-bold text-center mt-4">
                                                        <a class="text-dark" href="/browse/corpus/{{$corpus['elasticid']}}">
                                                            {{$corpus['corpus_title']}} (Version {{$corpus['corpus_version']}})
                                                        </a>
                                                    </div>
                                                    <p class="text-center text-grey my-2">
                                                        {{$corpus['authors']}}
                                                    </p>
                                                    <div class="d-flex">
                                                        <div class="corpusProp text-16 d-flex align-items-center align-self-start pr-1 my-1 mr-3 flex-nowrap">
                                                            <i class="fa fa-fw fa-cubes mr-1"></i>
                                                            <span>{{$corpus['corpus_size_value']}} Tokens</span>
                                                        </div>
                                                        <div class="corpusProp smaller text-16 d-flex align-items-center align-self-start my-1 pl-2 flex-nowrap">
                                                            <i class="fa fa-fw fa-arrow-up mr-1 border-top border-dark"></i>
                                                            <span>{{$corpus['corpus_publication_date']}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <div class="col">

                    <div class="matchedHeight card bg-bluegrey-mid border-0 px-7">
                        <div class="card-body p-6">
                            <div class="d-flex flex-column align-items-center">
                                <img class="rounded-circle w-30 bg-white" src="{{ asset('images/placeholder_circle.svg') }}" alt="circle-image">
                                <h4 class="h4 font-weight-bold text-center mt-4">
                                    Take part and publish a corpus within the Laudatio repository
                                </h4>
                                <p class="text-center mt-4 text-wine">
                                    Integer volutpat risus non mauris ultricies euismod. Cras tincidunt bibendum urna, et eleifend felis.
                                    Fusce viverra ultricies interdum. Aliquam pharetra enim a tortor eleifend, vel
                                    varius lectus.
                                    <a href="#">More...</a>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop