@extends('layouts.browse')

@section('content')

    <div class="HolyGrail">
        <header class="HolyGrail-header">
            <div class="overlay">
                <div class="Header Header--cozy" role="banner" v-show="header == 'corpus'">
                    <corpusheader :headerdata="headerdata" :header="header"></corpusheader>
                </div>
                <div class="Header Header--cozy" role="banner" v-show="header == 'document'">
                    <documentheader :headerdata="headerdata" :header="header"></documentheader>
                </div>
            </div>


        </header>
        <main class="HolyGrail-body">
            <nav class="HolyGrail-nav u-textCenter">
               <div class="list-group">
                   <a href="#" class="list-group-item">Corpus</a>
                   <a href="#" class="list-group-item">Document</a>
                   <a href="#" class="list-group-item">Annotation</a>
               </div>
            </nav>
            <article class="HolyGrail-content">
                <div class="Blockwrapper">
                    <div class="Corpus-MetadataBlock" v-show="header == 'corpus'">
                        <div class="Corpus-MetadataBlock-header">
                            <metadata-block-header-corpus :headerdata="headerdata" :headerid="headerid" :header="header"></metadata-block-header-corpus>
                        </div>
                        <div class="Corpus-MetadataBlock-body">
                            <metadata-block-body-corpus :headerdata="headerdata" :headerid="headerid" :header="header"></metadata-block-body-corpus>
                        </div>
                    </div>
                    <div class="Document-MetadataBlock" v-show="header == 'document'">
                        <div class="Document-MetadataBlock-header">
                            <metadata-block-header-document :headerdata="headerdata" :headerid="headerid" :header="header"></metadata-block-header-document>
                        </div>
                        <div class="Document-MetadataBlock-body">
                            <metadata-block-body-document :headerdata="headerdata" :headerid="headerid" :header="header"></metadata-block-body-document>
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