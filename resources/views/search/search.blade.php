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
                        <a class="text-uppercase btn-outline-corpus-dark align-self-end text-uppercase text-dark text-12 p-2" href="#">
                            Apply Filters
                        </a>
                        <div class="mb-4">
                            <activefilter :corpusresults="corpusresults"></activefilter>
                        </div>
                        <div class="mb-4">
                            <corpusfilter :corpusresults="corpusresults" v-on:corpus-filter="submitCorpusFilter"></corpusfilter>
                        </div>
                        <div class="mb-4">
                            <documentfilter :corpusresults="corpusresults"></documentfilter>
                        </div>
                        <div class="mb-4">
                            <annotationfilter :corpusresults="corpusresults"></annotationfilter>
                        </div>
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
