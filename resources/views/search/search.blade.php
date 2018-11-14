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
                    <searchfilterwrapper
                            :corpusresults="corpusresults"></searchfilterwrapper>
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
