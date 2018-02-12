@extends('layouts.browse')

@section('content')

    <div class="HolyGrail">
        <breadcrumb :headerdata="headerdata" :header="header"></breadcrumb>
        <header class="HolyGrail-header">
            <div class="overlay">
                <div class="Header Header--cozy" role="banner" v-show="header == 'corpus'">
                    <corpusheader :headerdata="headerdata" :header="header"></corpusheader>
                </div>
                <div class="Header Header--cozy" role="banner" v-show="header == 'document'">
                    <documentheader :headerdata="headerdata" :header="header"></documentheader>
                </div>
                <div class="Header Header--cozy" role="banner" v-show="header == 'annotation'">
                    <annotationheader :headerdata="headerdata" :header="header"></annotationheader>
                </div>
            </div>
            <div class="Corpus-MetadataBlock-header" v-show="header == 'corpus'">
                <metadata-block-header-corpus :headerdata="headerdata" :headerid="headerid" :header="header"></metadata-block-header-corpus>
            </div>
            <div class="Corpus-MetadataBlock-header" v-show="header == 'document'">
                <metadata-block-header-document :headerdata="headerdata" :headerid="headerid" :header="header"></metadata-block-header-document>
            </div>
        </header>
        <main class="HolyGrail-body">
            <article class="HolyGrail-content">
                <div class="Blockwrapper">
                    <div class="Corpus-MetadataBlock" v-show="header == 'corpus'">
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
    </div>
@stop