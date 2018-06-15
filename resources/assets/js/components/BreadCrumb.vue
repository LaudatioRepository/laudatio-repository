<template lang="html">
<div v-bind:class="[containerClass, backgroundClass]">
    <div class="py-2 container d-flex justify-content-between align-items-center">

        <nav aria-label="breadcrumb" class="breadcrumbs">
            <ol class="breadcrumb bg-transparent">
                <li class="text-12 text-uppercase breadcrumb-item">
                    <a class="text-dark" href="/">Home</a>
                </li>
                <li class="text-12 text-uppercase breadcrumb-item" v-if="isloggedin">
                    <a class="text-dark" href="/corpusprojects">Publish</a>
                </li>
                <li class="text-12 text-uppercase breadcrumb-item" v-else>
                    <a class="text-dark" href="/browse">Published corpora</a>
                </li>
                <li class="text-12 text-uppercase breadcrumb-item" v-show="isloggedin"><a href="#"  class="text-dark" >Corpora</a></li>

                <li class="text-12 text-uppercase breadcrumb-item text-wine-trans active" v-if="header == 'corpus'">
                    <a v-bind:href="('/browse/corpus/').concat(corpuselasticsearchid)">{{ headerdata.corpus_title | arrayToString | touppercase }}</a>
                </li>
                 <li class="text-12 text-uppercase breadcrumb-item text-wine-trans active" v-else-if="header == 'document' && headerdata.documentCorpusdata  != 'undefined'">
                    <a v-bind:href="('/browse/corpus/').concat(corpuselasticsearchid)" class="text-dark">{{ headerdata.documentCorpusdata.corpus_title | arrayToString | touppercase}}</a> |  Document: <a href="">{{ headerdata.document_title | arrayToString | arrayToString | touppercase }}</a>
                </li>

                <li class="text-12 text-uppercase breadcrumb-item text-wine-trans active" v-else-if="header == 'annotation' && headerdata.annotationCorpusdata  != 'undefined'">
                    <a  v-bind:href="('/browse/corpus/').concat(corpuselasticsearchid)" class="text-dark">{{ headerdata.annotationCorpusdata.corpus_title | arrayToString | touppercase}}</a> |  Annotation: <a href="">{{ headerdata.preparation_title | arrayToString | arrayToString | touppercase }}</a>
                </li>

            </ol>
        </nav>

    </div>
</div>
</template>
<script>
    export default {
        props: ['headerdata','header','user','isloggedin','corpuselasticsearchid','corpusid'],
        methods: {
            corpusAuthors: function(){
                var authorString = "";
                for(var i=0; i < this.headerdata.corpus_editor_forename.length;i++) {
                    authorString += this.headerdata.corpus_editor_forename[i]
                        .concat(' ')
                        .concat(this.headerdata.corpus_editor_surname[i])
                        .concat(',');
                }
                authorString = authorString.substring(0,authorString.lastIndexOf(","));
                return authorString;
            }
        },
        data: function(){
            return {
                containerClass: 'container-fluid',
                backgroundClass: this.isloggedin ? 'bg-bluegrey-dark': 'bg-corpus-mid',
            }
        },
        mounted() {
            console.log('CorpusMetadataBlockHeader mounted.')
        }
    }
</script>