<template lang="html">
    <div>

        <a class="text-uppercase btn-outline-corpus-dark align-self-end text-uppercase text-dark text-12 p-2" href="javascript:" @click="applyFilters">
            Apply Filters
        </a>
        <div class="mb-4">
            <activefilter
                :corpusresults="corpusresults"
                :documentresults="documentresults"
                :annotationresults="annotationresults"
                :corpusresultcounter="corpusresultcounter"
                :documentresultcounter="documentresultcounter"
                :annotationresultcounter="annotationresultcounter"
                :activefilters="activefilters"
                v-on:corpus-resultcounter="emitCorpusResultCounter"
                v-on:document-resultcounter="emitDocumentResultCounter"
                v-on:annotation-resultcounter="emitAnnotationResultCounter"></activefilter>
        </div>
        <div class="mb-4">
            <corpusfilter
                :corpusresults="corpusresults"
                :documentresults="documentresults"
                :annotationresults="annotationresults"
                ref="corpusFilter"
                v-on:corpus-filter="emitCorpusFilter"
                ></corpusfilter>
        </div>
        <div class="mb-4">
            <documentfilter
                :corpusresults="corpusresults"
                :documentresults="documentresults"
                :annotationresults="annotationresults"
                ref="documentFilter"
                v-on:document-filter="emitDocumentFilter"
                ></documentfilter>
        </div>
        <div class="mb-4">
            <annotationfilter
                :corpusresults="corpusresults"
                :documentresults="documentresults"
                :annotationresults="annotationresults"
                ref="annotationFilter"
                v-on:annotation-filter="emitAnnotationFilter"
                ></annotationfilter>
        </div>
    </div>
</template>
<script>
    import { mapState, mapActions, mapGetters } from 'vuex'
    export default {
        props: ['corpusresults','documentresults', 'annotationresults', 'activefilters','corpusresultcounter','documentresultcounter','annotationresultcounter'],
        methods: {
            applyFilters: function (){
                this.$refs.corpusFilter.emitCorpusFilter();
                this.$refs.documentFilter.emitDocumentFilter();
                this.$refs.annotationFilter.emitAnnotationFilter();
            },
            emitCorpusFilter: function (corpusFilterEmitData) {
                this.$emit('corpus-filter',corpusFilterEmitData);
            },
            emitDocumentFilter: function (documentFilterEmitData) {
                this.$emit('document-filter',documentFilterEmitData);
            },
            emitAnnotationFilter: function (annotationFilterEmitData) {
                this.$emit('annotation-filter',annotationFilterEmitData);
            },
            emitCorpusResultCounter: function(emittedCorpusResultCounter) {
                this.$emit('corpus-resultcounter',emittedCorpusResultCounter);
            },
            emitDocumentResultCounter: function(emittedDocumentResultCounter) {
                this.$emit('document-resultcounter',emittedDocumentResultCounter);
            },
            emitAnnotationResultCounter: function(emittedAnnotationResultCounter) {
                this.$emit('annotation-resultcounter',emittedAnnotationResultCounter);
            }
        },
        computed:
            mapGetters({
                stateDocumentCorpusresults: 'documentcorpus',
                stateAnnotationCorpusresults: 'annotationcorpus'
            }),
        mounted() {
            console.log('CorpusResultComponent mounted.')
        }
    }
</script>