<template lang="html">
    <div id="searchresultpanelcorpus">
<!--
        <p class="searchTerm"> Search term: {{corpusresult.search}}</p>
        <p class="searchScope">Scope: {{corpusresult.scope}}</p>
        -->
        <div class="panel-group" id="accordion">
            <div v-if="corpusresult.results.length > 0" class="panel panel-default" v-for="corpusresultdata in corpusresult.results" v-bind:key="corpusresultdata._id">
                <div class="panel-heading">
                    <div class="panel-title"  data-toggle="collapse" data-parent="#accordion" v-bind:data-target="corpusresultdata._id | addHash" v-on:click="emitCorpusRelations(corpusresultdata._id)">
                    {{ corpusresultdata._source.corpus_title | arrayToString }}
                    <i class="fa fa-expand pull-right" aria-hidden="true"></i>
                    </div>
                 </div>
                 <div :id="corpusresultdata._id" class="panel-collapse collapse">
                    <div   class="panel-body">
                        <span class="iconwrapper"><i class="fa fa-university" aria-hidden="true"></i> Published: {{corpusresultdata._source.corpus_publication_publication_date | lastElement}}</span>
                        <span class="iconwrapper"><i class="fa fa-file-text" aria-hidden="true" v-if="typeof corpusresultdata._source.corpus_documents != 'undefined'"></i> Documents: {{corpusresultdata._source.corpus_documents.length}}</span>
                        <span class="iconwrapper"><i class="fa fa-pencil-square-o" aria-hidden="true" v-if="typeof corpusresultdata._source.annotation_name != 'undefined'"></i> Annotations: {{corpusresultdata._source.annotation_name.length}}</span>
                        <br />
                        <span v-if="corpusresultdata._source.corpus_publication_license_description"><i class="fa fa-creative-commons" aria-hidden="true"></i>: {{corpusresultdata._source.corpus_publication_license_description | arrayToString}}</span>
                        <br /> <a v-bind:href="browseUri(corpusresultdata._id)" ><i class="fa fa-external-link pull-right" aria-hidden="true"></i></a>
                    </div>
                 </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState, mapActions } from 'vuex'
    export default {
        props: ['corpusresult','documentsbycorpus','annotationsbycorpus'],
        methods: {
            browseUri: function(id) {
                return '/browse/corpus/'.concat(id);
            },
            emitCorpusRelations: function(corpusId){
                this.$store.dispatch('clearCorpus',[])
                this.$store.dispatch('clearDocuments',[])
                this.$store.dispatch('clearAnnotations',[])
                this.$store.dispatch('documentByCorpus',this.documentsbycorpus[corpusId])
                this.$store.dispatch('annotationByCorpus',this.annotationsbycorpus[corpusId])
            }
        },
        mounted() {
            console.log('CorpusResultComponent mounted.')
        }
    }
</script>
