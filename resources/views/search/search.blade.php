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
                            Corpus results
                        </div>
                        <div class="Corpus-body">
                            <!--searchwrapper :results="results"></searchwrapper-->
                            <searchwrappercorpus :corpusresults="corpusresults"></searchwrappercorpus>
                        </div>
                    </div>
                    <div class="Document-results">
                        <div class="Document-header">
                            Document results
                        </div>
                        <div class="Document-body">
                            <searchwrapperdocument :documentresults="documentresults"></searchwrapperdocument>
                        </div>
                    </div>
                    <div class="Annotation-results">
                        <div class="Annotation-header">
                            Annotation results
                        </div>
                        <div class="Annotation-body"></div>
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
                Footer
            </div>
        </footer>
    </div>
@stop