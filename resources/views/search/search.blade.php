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
                                :activefiltersmap="activefiltersmap"
                                :activefilterhits="activefilterhits"
                                v-on:corpus-filter="submitCorpusFilter"
                                v-on:document-filter="submitDocumentFilter"
                                v-on:annotation-filter="submitAnnotationFilter"
                                v-on:corpus-resultcounter="updateCorpusCounter"
                                v-on:document-resultcounter="updateDocumentCounter"
                                v-on:annotation-resultcounter="updateAnnotationCounter"
                                v-on:reset-activefilter="resetActiveFilter"
                                v-on:reset-activefilters="resetActiveFilters"
                                v-on:reset-activefilterhighlight="resetActiveFilterHighlight"
                                :corpusresultcounter="corpusresultcounter"
                                :documentresultcounter="documentresultcounter"
                                :annotationresultcounter="annotationresultcounter"
                                :corpusformats="corpusformats"
                                ref="filterwrapper"
                                :annotationformats="annotationformats"></searchfilterwrapper>
                    </div>
                    <searchresultwrapper
                            :corpusresults="corpusresults"
                            :corpushighlights="corpushighlights"
                            :datasearched="datasearched"
                            :dataloading="dataloading"
                            :documentresults="documentresults"
                            :documenthighlights="documenthighlights"
                            :annotationresults="annotationresults"
                            :annotationhighlights="annotationhighlights"
                            :filteredcorpushighlightmap="filteredcorpushighlightmap"
                            :filtereddocumenthighlightmap="filtereddocumenthighlightmap"
                            :filteredannotationhighlightmap="filteredannotationhighlightmap"
                            :searches="searches"
                            :corpusresultcounter="corpusresultcounter"
                            :documentresultcounter="documentresultcounter"
                            :annotationresultcounter="annotationresultcounter"
                            v-on:initial-search="initialSearch"
                            v-on:frontpage-search="frontpageSearch"
                            ref="searchwrapper"
                            :frontpageresultdata="frontPageResultData"
                            ></searchresultwrapper>
                </div>
            </div>
        </div>
    </div>
@endsection
