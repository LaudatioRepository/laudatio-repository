<template lang="html">
 <div class="resultbar" role="breadcrumb">
            <div class="headerBreadCrumb" v-show="header == 'corpus'">HOME | PUBLISHED CORPORA | {{ headerdata.corpus_title | arrayToString | touppercase }}
                <span v-show="header == 'document'">| {{ headerdata.document_title | arrayToString | arrayToString | touppercase }}</span>
                <span v-show="header == 'annotation'">| {{ headerdata.annotation_title | arrayToString | arrayToString | touppercase }}</span>
            </div>
            <div class="prevNextBreadCrumb">
                <span>PREVIOUS CORPUS | </span>
                <span> 10 / 10</span>
                <span> | NEXT CORPUS</span>
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