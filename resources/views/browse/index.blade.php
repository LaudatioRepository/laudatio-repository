@extends('layouts.project_ux')

@section('content')
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="">

                        <div class="mt-6">
                            <div class="d-flex justify-content-between mt-7 mb-1">
                                @if(count($corpusdata) <= 1 )
                                    <div class="h2 font-weight-normal">{{count($corpusdata)}} published corpora</div>
                                 @else
                                    <div class="h2 font-weight-normal">{{count($corpusdata)}} published corpus</div>
                                @endif
                                <div class="form-row ">
                                    <div class="col-auto">
                                        <div class="dropdown">
                                            <button class="btn btn-outline-corpus-dark rounded dropdown-toggle font-weight-bold text-uppercase "
                                                    type="button" id="searchSort" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Title - Alphabetical
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="searchSort">
                                                <a class="dropdown-item text-14" href="#">Title - alphabetical</a>
                                                <a class="dropdown-item text-14" href="#">Tokens - ascending</a>
                                                <a class="dropdown-item text-14" href="#">Tokens - descending</a>
                                                <a class="dropdown-item text-14" href="#">Corpus release - oldest</a>
                                                <a class="dropdown-item text-14" href="#">Corpus release - newest</a>
                                                <a class="dropdown-item text-14" href="#">Date Document - oldest</a>
                                                <a class="dropdown-item text-14" href="#">Date Document - newest</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="container p-0">
                                <div class="row">
                                    @foreach($corpusdata as $index => $corpus)
                                    <div class="col-6">
                                        <div class="container bg-corpus-superlight mt-3 mb-3">
                                            <div class="row d-flex flex-column p-3">
                                                <div class="align-self-end d-flex justify-content-end align-items-center">
                                                    <img class="py-1" src="/images/license-cc.svg" alt="license cc" /> <img class="py-1" src="/images/license-by.svg" alt="license by" />
                                                </div>
                                            </div>
                                            <div class="row px-3">
                                                <div class="col-4">
                                                    <img class="w-100" src="/images/placeholder_circle.svg" alt="circle-image">
                                                </div>
                                                <div class="col">
                                                    <h4 class="h4 font-weight-bold">
                                                        <a class="text-dark" href="/browse/corpus/{{$corpus['elasticid']}}">
                                                            {{$corpus['corpus_title']}}
                                                        </a>
                                                    </h4>
                                                    <p class="text-wine text-14">
                                                        {{$corpus['authors']}}
                                                    </p>
                                                    <div class="row mt-2">
                                                        <div class="col-auto">
                                                            <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                                <i class="fa fa-fw fa-clock-o mr-1"></i>
                                                                <span>
                                                                    D. from 1945 - 1950
                                                                </span>
                                                            </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                                <i class="fa fa-fw fa-globe mr-1"></i>
                                                                <span>
                                                                    {{$corpus['corpus_languages_language']}}
                                                                  </span>
                                                            </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                                <i class="fa fa-fw fa-th-list  mr-1"></i>
                                                                <span>
                                                                    Herbology
                                                                  </span>
                                                            </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                                <i class="fa fa-fw fa-cubes mr-1"></i>
                                                                <span>
                                                                {{$corpus['corpus_size_value']}}
                                                              </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex align-items-center px-4 mt-2">
                                                <div class="col-4">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-corpus-dark w-100 dropdown-toggle font-weight-bold text-uppercase rounded "
                                                                type="button" id="serviceRowDownload" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Download
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item text-14" href="#">TEI-Header</a>
                                                            <a class="dropdown-item text-14" href="#">EXCEL</a>
                                                            <a class="dropdown-item text-14" href="#">PAULA</a>
                                                            <a class="dropdown-item text-14" href="#">ANNIS</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                                        <i class="fa fa-text-height fa-fw fa-file-text-o align-baseline fa-lg text-wine"></i>
                                                        <span class="text-primary text-14 font-weight-bold">{{$corpus['documentcount']}}</span>
                                                    </a>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="# " class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                                        <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                                                        <span class="text-14 font-weight-bold">{{$corpus['annotationcount']}}</span>
                                                    </a>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="corpusProp smaller text-14 d-flex align-items-center align-self-start my-1 flex-nowrap">
                                                        <i class="fa fa-fw fa-arrow-up mr-1 border-top border-dark"></i>
                                                        <span>
                                                        2017
                                                      </span>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row p-6">
                                                <p class="text-14">
                                                    {{$corpus['corpus_encoding_project_description']}}
                                                    <a href="#">MORE</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="container d-flex flex-column align-items-center justify-content-center mb-5 mt-5">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <li class="page-item font-weight-bold active">
                        <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item font-weight-bold">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item font-weight-bold">
                        <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="form-row">
                <div class="col-auto">

                    <select class="custom-select custom-select-sm font-weight-bold text-uppercase">
                        <option selected>6 results / page</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
@stop