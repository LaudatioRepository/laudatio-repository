@extends('layouts.flexsearch')

@section('content')
    <div id="searchapp" class="HolyGrail">
        <header class="HolyGrail-header">
            <div class="Header Header--cozy" role="banner">
                <searchpanel_general v-on:searchedgeneral="askElastic"></searchpanel_general>
            </div>

        </header>
        <main class="HolyGrail-body">
            <article class="HolyGrail-content">
                <div class="result-box">
                    <div class="Corpus-results">
                        <div class="Corpus-header">
                            <searchresultheader_corpus :corpusresults="corpusresults"></searchresultheader_corpus>
                        </div>
                        <div class="Corpus-result-body">
                            <searchwrapper_corpus :corpusresults="corpusresults" :corpussearched="corpussearched" :corpusloading="corpusloading" :documentsbycorpus="documentsByCorpus"  :annotationsbycorpus="annotationsByCorpus"></searchwrapper_corpus>
                        </div>
                    </div>
                    <div class="Document-results">
                        <div class="Document-header">
                            <searchresultheader_document :documentresults="documentresults"></searchresultheader_document>
                        </div>
                        <div class="Document-result-body">
                            <searchwrapper_document :documentresults="documentresults" :documentSearched="documentsearched" :documentloading="documentloading" :annotationsbydocument="annotationsByDocument" :corpusbydocument="corpusByDocument"></searchwrapper_document>
                        </div>
                    </div>
                    <div class="Annotation-results">
                        <div class="Annotation-header">
                            <searchresultheader_annotation :annotationresults="annotationresults"></searchresultheader_annotation>
                        </div>
                        <div class="Annotation-result-body">
                            <searchwrapper_annotation :annotationresults="annotationresults" :annotationsearched="annotationsearched" :annotationloading="annotationloading" :corpusbyannotation="corpusByAnnotation" :documentsbyannotation="documentsByAnnotation"></searchwrapper_annotation>
                        </div>
                    </div>
                </div>
            </article>
            <nav class="HolyGrail-nav u-textCenter">
                <searchpanel_corpus v-on:corpus-search="submitCorpusSearch"></searchpanel_corpus>
                <searchpanel_document v-on:document-search="submitDocumentSearch"></searchpanel_document>
                <searchpanel_annotation v-on:annotation-search="submitAnnotationSearch"></searchpanel_annotation>
            </nav>
            <aside class="HolyGrail-filters u-textCenter">
                <strong>Filters</strong>
            </aside>
        </main>
        <footer class="HolyGrail-footer">
            <div class="Footer">
                Institut für deutsche Sprache und Linguistik , Computer- und Medienservice
            </div>
        </footer>
    </div>
@stop