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
                            <searchwrapper :results="results"></searchwrapper>
                        </div>
                    </div>
                    <div class="Document-results">
                        <div class="Document-header">
                            Document results
                        </div>
                        <div class="Document-body"></div>
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
                <div class="Corpus-box">
                    <div class="Corpus-header">
                      Corpus
                    </div>
                    <div class="Corpus-body">
                        <label>Name <input type="text" name="corpus-name" /></label>
                        <label>Publisher <input type="text" name="corpus-publisher" /></label>
                        <label>Year <input type="text" name="corpus-year-from" /> to <input type="text" name="corpus-year-to" /></label>
                        <label>Size <input type="text" name="corpus-size-from" /> to <input type="text" name="corpus-size-to" /></label>
                        <label>Language <input type="text" name="corpus-language" /></label>
                        <label>Format <input type="text" name="corpus-format" /></label>
                    </div>
                </div>
                <div class="Document-box">
                    <div class="Document-header">
                        Document
                    </div>
                    <div class="Document-body">
                        <label>Name <input type="text" name="document-name" /></label>
                        <label>Author <input type="text" name="document-author" /></label>
                        <label>Place <input type="text" name="document-place" /></label>
                        <label>Year <input type="text" name="document-year-from" /> to <input type="text" name="corpus-year-to" /></label>
                        <label>Size <input type="text" name="document-size-from" /> to <input type="text" name="corpus-size-to" /></label>
                        <label>Language <input type="text" name="document-language" /></label>
                    </div>
                </div>
                <div class="Annotation-box">
                    <div class="Annotation-header">
                        Annotation
                    </div>
                    <div class="Annotation-body">
                        <label>Name <input type="text" name="annotation-name" /></label>
                        <label>Category <input type="text" name="annotation-category" /></label>
                        <label>Format <input type="text" name="annotation-format" /></label>
                    </div>
                </div>
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