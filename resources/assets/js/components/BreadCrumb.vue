<template lang="html">
 <div class="resultbar" role="breadcrumb">
            <div class="headerBreadCrumb">HOME |  PUBLISHED CORPORA
                <span v-if="header == 'corpus'"> |  {{ headerdata.corpus_title | arrayToString | touppercase }}</span>
                <span v-if="header == 'document'"><span v-if="headerdata.documentCorpusdata  != 'undefined'"> |  {{ headerdata.documentCorpusdata.corpus_title | arrayToString | touppercase}}</span> |  {{ headerdata.document_title | arrayToString | arrayToString | touppercase }}</span>
                <span v-if="header == 'annotation'"><span  v-if="headerdata.annotationCorpusdata  != 'undefined'"> |  {{ headerdata.annotationCorpusdata.corpus_title | arrayToString | touppercase}}</span> |  {{ headerdata.preparation_title | arrayToString | arrayToString | touppercase }}</span>
            </div>
            <div class="prevNextBreadCrumb">
                <span v-show="header == 'corpus'">
                    <span>PREVIOUS CORPUS | </span>
                    <span> 10 / 10</span>
                    <span> | NEXT CORPUS</span>
                </span>
                <span v-show="header == 'document'">
                    <span>PREVIOUS DOCUMENT | </span>
                    <span> 10 / 10</span>
                    <span> | NEXT DOCUMENT</span>
                </span>
                <span v-show="header == 'annotation'">
                    <span>PREVIOUS ANNOTAION | </span>
                    <span> 10 / 10</span>
                    <span> | NEXT ANNOTATION</span>
                </span>
            </div>
        </div>
</template>
<script>
    export default {
        props: ['headerdata','header'],
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
        mounted() {
            console.log('CorpusMetadataBlockHeader mounted.')
        }
    }
</script>