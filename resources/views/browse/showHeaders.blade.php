@extends('layouts.browse')

@section('content')

    <div id="browseapp" class="HolyGrail">
        <header class="HolyGrail-header">
            <div class="Header Header--cozy" role="banner">
                <corpusheader :headerdata="headerdata"></corpusheader>
            </div>

        </header>
        <main class="HolyGrail-body">
            <nav class="HolyGrail-nav u-textCenter">
                Menusdf
            </nav>
            <article class="HolyGrail-content">
                <div class="Blockwrapper">
                    <div class="Corpus-MetadataBlock" v-show="header == 'corpus'">
                        <div class="Corpus-MetadataBlock-header">
                            <metadata-block-header-corpus :headerdata="headerdata" :headerid="headerid"></metadata-block-header-corpus>
                        </div>
                        <div class="Corpus-MetadataBlock-body">
                            Corpus-MetadataBlock-body
                        </div>
                    </div>
                    <div class="Document-MetadataBlock" v-show="header == 'document'">
                        <div class="Document-MetadataBlock-header">
                            Document-MetadataBlock-header
                        </div>
                        <div class="Document-MetadataBlock-body">
                            Document-MetadataBlock-body
                        </div>
                    </div>
                    <div class="Annotation-MetadataBlock" v-show="header == 'annotation'">
                        <div class="Annotation-MetadataBlock-header">
                            Annotation metadata-header
                        </div>
                        <div class="Annotation-MetadataBlock-body">
                            Annotation metadata-body
                        </div>
                    </div>
                </div>
            </article>

        </main>
        <footer class="HolyGrail-footer">
            <div class="Footer">
                Institut für deutsche Sprache und Linguistik , Computer- und Medienservice
            </div>
        </footer>
    </div>
@stop