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
                :activefiltersmap="activefiltersmap"
                v-on:corpus-resultcounter="emitCorpusResultCounter"
                v-on:document-resultcounter="emitDocumentResultCounter"
                v-on:annotation-resultcounter="emitAnnotationResultCounter"
                v-on:clear-all-filters="clearAllFilters"
                v-on:reset-activefilter="resetActiveFilter"
                v-on:reset-corpus-filter="resetCorpusFilter"
                v-on:reset-document-filter="resetDocumentFilter"
                v-on:reset-annotation-filter="resetAnnotationFilter"
                ></activefilter>
        </div>
        <div class="mb-4">
            <corpusfilter
                :corpusresults="corpusresults"
                :documentresults="documentresults"
                :annotationresults="annotationresults"
                :corpusformats="corpusformats"
                ref="corpusFilter"
                v-on:corpus-filter="emitCorpusFilter"
                v-on:apply-filters="applyFilters"
                v-on:remove-corpus-filter="removeFilter"
                ></corpusfilter>
        </div>
        <div class="mb-4">
            <documentfilter
                :corpusresults="corpusresults"
                :documentresults="documentresults"
                :annotationresults="annotationresults"
                ref="documentFilter"
                v-on:document-filter="emitDocumentFilter"
                v-on:apply-filters="applyFilters"
                v-on:remove-document-filter="removeFilter"
                ></documentfilter>
        </div>
        <div class="mb-4">
            <annotationfilter
                :corpusresults="corpusresults"
                :documentresults="documentresults"
                :annotationresults="annotationresults"
                ref="annotationFilter"
                v-on:annotation-filter="emitAnnotationFilter"
                :annotationformats="annotationformats"
                v-on:apply-filters="applyFilters"
                ></annotationfilter>
        </div>
    </div>
</template>
<script>
    import { mapState, mapActions, mapGetters } from 'vuex'
    export default {
        props: ['corpusresults','documentresults', 'annotationresults', 'activefilters','activefiltersmap','corpusresultcounter','documentresultcounter','annotationresultcounter','corpusformats','annotationformats'],
        methods: {
            applyFilters: function (){
                this.$refs.corpusFilter.emitCorpusFilter();
                this.$refs.documentFilter.emitDocumentFilter();
                this.$refs.annotationFilter.emitAnnotationFilter();
            },
            clearAllFilters: function(){
                this.$refs.corpusFilter.clearCorpusFilter();
                this.$refs.documentFilter.clearDocumentFilter();
                this.$refs.annotationFilter.clearAnnotationFilter();
                this.$emit('reset-activefilters');
            },
            removeFilter: function(field) {
                for(var val in this.activefiltersmap) {
                    var key = this.activefiltersmap[val]
                    if(key == field) {
                        this.activefilters.splice(this.activefilters.indexOf(key),1);
                        delete this.activefiltersmap[val];
                    }
                }
            },
            resetActiveFilter: function(filter){
                this.$emit('reset-activefilter',filter);
            },
            resetCorpusFilter: function(filter) {
                var key = this.activefiltersmap[filter];
                console.log("CORPOUSRESET: "+key+" => "+filter)
                this.$refs.corpusFilter.resetFilterField(key,filter);
            },
            resetDocumentFilter: function(filter) {
                var key = this.activefiltersmap[filter];
                console.log("DOCRESET: "+key+" => "+filter)
                this.$refs.documentFilter.resetFilterField(key,filter);
            },
            resetAnnotationFilter: function(filter) {
                var key = this.activefiltersmap[filter];
                this.$refs.annotationFilter.resetFilterField(key,filter);
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