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
                    <div class="col-3 ">
                        <div class="d-flex justify-content-between mt-7 mb-3">
                            <h3 class="h3 font-weight-normal">Filter</h3>
                        </div>
                        <searchfilterwrapper
                                :corpusresults="corpusresults"
                                :documentresults="documentresults"
                                :annotationresults="annotationresults"
                                :activefilters="activefilters"
                                v-on:corpus-filter="submitCorpusFilter"
                                v-on:document-filter="submitDocumentFilter"
                                v-on:annotation-filter="submitAnnotationFilter"
                                v-on:corpus-resultcounter="updateCorpusCounter"
                                v-on:document-resultcounter="updateDocumentCounter"
                                v-on:annotation-resultcounter="updateAnnotationCounter"
                                :corpusresultcounter="corpusresultcounter"
                                :documentresultcounter="documentresultcounter"
                                :annotationresultcounter="annotationresultcounter"
                                :corpusformats="corpusformats"
                                :annotationformats="annotationformats"></searchfilterwrapper>
                    </div>
                    <searchresultwrapper
                            :corpusresults="corpusresults"
                            :datasearched="datasearched"
                            :dataloading="dataloading"
                            :documentresults="documentresults"
                            :annotationresults="annotationresults"
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
