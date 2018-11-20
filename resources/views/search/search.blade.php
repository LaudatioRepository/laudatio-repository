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
                    <!--searchfilterwrapper
                            :corpusresults="corpusresults"
                            v-on:corpus-filter="submitCorpusSearch"></searchfilterwrapper-->
                    <div class="col-3 ">
                        <div class="d-flex justify-content-between mt-7 mb-3">
                            <h3 class="h3 font-weight-normal">Filter</h3>
                        </div>
                        <!--div class="w-100 py-3 px-6 mb-1 bg-corpus-light d-flex flex-column"-->
                        <!--div class="btn btn-sm font-weight-bold text-uppercase btn-outline-corpus-dark align-self-auto disabled py-3 px-6 mb-1">
                            Apply Filter
                        </div-->
                        <!--/div-->
                        <searchfilterwrapper
                                :corpusresults="corpusresults"
                                :activefilters="activefilters"
                                v-on:corpus-filter="submitCorpusFilter"
                                v-on:document-filter="submitDocumentFilter"
                                v-on:annotation-filter="submitAnnotationFilter"></searchfilterwrapper>
                    </div>
                    <searchresultwrapper
                            :corpusresults="corpusresults"
                            :corpussearched="corpussearched"
                            :corpusloading="corpusloading"
                            :documentsbycorpus="documentsByCorpus"
                            :annotationsbycorpus="annotationsByCorpus"
                            :documentresults="documentresults"
                            :documentSearched="documentsearched"
                            :documentloading="documentloading"
                            :annotationsbydocument="annotationsByDocument"
                            :corpusbydocument="corpusByDocument"
                            :annotationresults="annotationresults"
                            :annotationsearched="annotationsearched"
                            :annotationloading="annotationloading"
                            :corpusbyannotation="corpusByAnnotation"
                            :documentsbyannotation="documentsByAnnotation"
                            :searches="searches"
                            :corpusresultcounter="corpusresultcounter"
                            :documentresultcounter="documentresultcounter"
                            :annotationresultcounter="annotationresultcounter"
                            ></searchresultwrapper>
                </div>
            </div>
        </div>
    </div>
@endsection
