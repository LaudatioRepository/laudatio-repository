<template lang="html">
<div v-bind:class="[containerClass, backgroundClass]">
    <div class="py-2 container d-flex justify-content-between align-items-center">

        <nav aria-label="breadcrumb" class="breadcrumbs">
            <ol class="breadcrumb bg-transparent">
                <li class="text-12 text-uppercase breadcrumb-item">
                    <a class="text-dark" href="#">Home</a>
                </li>
                <li class="text-12 text-uppercase breadcrumb-item">
                    <a class="text-dark" href="#">Publish</a>
                </li>
                <li class="text-12 text-uppercase breadcrumb-item text-wine-trans active" aria-current="page">Corpus projects</li>
                <li class="text-12 text-uppercase breadcrumb-item" v-if="header == 'corpus'">
                    <a class="text-dark" v-bind:href="('/browse/corpus/').concat(corpusid)">{{ headerdata.corpus_title | arrayToString | touppercase }}</a>
                </li>
                 <li class="text-12 text-uppercase breadcrumb-item" v-if="header == 'document' && headerdata.documentCorpusdata  != 'undefined'">
                    <a class="text-dark" href="#">{{ headerdata.documentCorpusdata.corpus_title | arrayToString | touppercase}}</a> |  {{ headerdata.document_title | arrayToString | arrayToString | touppercase }}</a>
                </li>

                <li class="text-12 text-uppercase breadcrumb-item" v-if="header == 'annotation' && headerdata.annotationCorpusdata  != 'undefined'">
                    <a class="text-dark" href="#">{{ headerdata.annotationCorpusdata.corpus_title | arrayToString | touppercase}}</a> |  {{ headerdata.preparation_title | arrayToString | arrayToString | touppercase }}</a>
                </li>

            </ol>
        </nav>

    </div>
</div>
</template>
<script>
    export default {
        props: ['headerdata','header','user','isloggedin','corpusid'],
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