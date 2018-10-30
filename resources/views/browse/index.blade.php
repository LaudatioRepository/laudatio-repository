@extends('layouts.project_ux')

@section('content')
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="">

                        <div class="mt-6">
                            <div class="d-flex justify-content-between mt-7 mb-1">
                                @if($totalCount == 0 || $totalCount > 1 )
                                    <div class="h2 font-weight-normal">{{$totalCount}} published corpora</div>
                                 @else
                                    <div class="h2 font-weight-normal">{{$totalCount}} published corpus</div>
                                @endif
                                <div class="form-row ">
                                    <div class="col-auto">
                                        <div class="dropdown">
                                            <button class="btn btn-outline-corpus-dark rounded dropdown-toggle font-weight-bold text-uppercase "
                                                    type="button" id="searchSort" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Title - Alphabetical
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="searchSort" id="pageSort">
                                                <a class="dropdown-item text-14" href="javascript:" data-sort="1">Title - alphabetical</a>
                                                <a class="dropdown-item text-14" href="javascript:" data-sort="2">Tokens - ascending</a>
                                                <a class="dropdown-item text-14" href="javascript:" data-sort="3">Tokens - descending</a>
                                                <a class="dropdown-item text-14" href="javascript:" data-sort="4">Corpus release - oldest</a>
                                                <a class="dropdown-item text-14" href="javascript:" data-sort="5">Corpus release - newest</a>
                                                <a class="dropdown-item text-14" href="javascript:" data-sort="6">Date Document - oldest</a>
                                                <a class="dropdown-item text-14" href="javascript:" data-sort="7">Date Document - newest</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="container p-0">
                                <div class="row">
                                    @if (null != $corpusdata)
                                        @foreach($corpusdata as $index => $corpus)
                                            <div class="col-6">
                                                <div class="container bg-corpus-superlight mt-3 mb-3">
                                                    <div class="row d-flex flex-column p-3">
                                                        <div class="align-self-end d-flex justify-content-end align-items-center licenseContainer" data-publicationlicense="{{$corpus['corpus_publication_license']}}"></div>
                                                    </div>
                                                    <div class="row px-3">
                                                        <div class="col-4">
                                                            @if (isset($corpus['corpus_logo']) && $corpus['corpus_logo'] != "")
                                                                <img class="w-100" src="/images/corpuslogos/{{$corpus['corpus_project_path']}}_{{$corpus['corpus_logo']}}" alt="corpus-logo">
                                                            @else
                                                                <img class="w-100" src="/images/placeholder_circle.svg" alt="circle-image">
                                                            @endif
                                                        </div>
                                                        <div class="col">
                                                            <div class="h4 font-weight-bold">
                                                                <a class="text-dark" href="/browse/corpus/{{$corpus['elasticid']}}">
                                                                    {{$corpus['corpus_title']}} (Version {{$corpus['corpus_version']}})
                                                                </a>
                                                            </div>
                                                            <p class="text-wine text-14">
                                                                {{$corpus['authors']}}
                                                            </p>
                                                            <div class="row mt-2">
                                                                <div class="col-auto">
                                                                    <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                                        <i class="fa fa-fw fa-clock-o mr-1"></i>
                                                                        <span>
                                                                    @if(strpos($corpus['document_publication_range'],"-") !== false)
                                                                        D. from {{$corpus['document_publication_range']}}
                                                                    @else
                                                                        D. {{$corpus['document_publication_range']}}
                                                                    @endif
                                                                </span>
                                                                    </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                                        <i class="fa fa-fw fa-globe mr-1"></i>
                                                                        <span>
                                                                    {{ StringHelper::truncate($corpus['corpus_languages_language'], 40) }}
                                                                  </span>
                                                                    </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                                                        <i class="fa fa-fw fa-th-list  mr-1"></i>
                                                                        <span>
                                                                    {{$corpus['document_genre']}}
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
                                                                    <a class="dropdown-item text-14" href="/download/tei/{{$corpus['download_path']}}">TEI-Header</a>
                                                                    <!--a class="dropdown-item text-14" href="#">EXCEL</a>
                                                                    <a class="dropdown-item text-14" href="#">PAULA</a>
                                                                    <a class="dropdown-item text-14" href="#">ANNIS</a-->
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
                                                        {{$corpus['corpus_publication_date']}}
                                                      </span>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row p-6">
                                                        <p class="text-14">
                                                            {{ StringHelper::truncate($corpus['corpus_encoding_project_description'], 300) }}
                                                            <a href="/browse/corpus/{{$corpus['elasticid']}}">MORE</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
        </div>
        <div class="container d-flex flex-column align-items-center justify-content-center mb-5 mt-5">
            @if (null != $corpusdata)
                {!! $corpusdata->appends(Request::capture()->except('page'))->render() !!}
                <div class="form-row">
                    <div class="col-auto">
                        <select class="custom-select custom-select-sm font-weight-bold text-uppercase" id="pageResultButton">
                            @foreach($perPageArray as $item => $value)

                                @if ($value == "selected")
                                    <option value="{{$item}}" selected>{{$item}} results / page</option>
                                @else
                                    <option value="{{$item}}"{{$item}}>{{$item}} results / page</option>
                                @endif

                            @endforeach
                        </select>
                    </div>
                </div>
            @endif

            <input type="hidden" name="pageTotal" id="pageTotal" value="{{$totalCount}}" />
        </div>
    </div>
@endsection