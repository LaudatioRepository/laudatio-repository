<template lang="html">
    <div>

        <a class="text-uppercase btn-outline-corpus-dark align-self-end text-uppercase text-dark text-12 p-2" href="javascript:" @click="applyFilters">
            Apply Filters
        </a>
        <div class="mb-4">
            <activefilter :corpusresults="corpusresults" :activefilters="activefilters"></activefilter>
        </div>
        <div class="mb-4">
            <corpusfilter :corpusresults="corpusresults" ref="corpusFilter" v-on:corpus-filter="emitCorpusFilter"></corpusfilter>
        </div>
        <div class="mb-4">
            <documentfilter :corpusresults="corpusresults" ref="documentFilter" v-on:document-filter="emitDocumentFilter"></documentfilter>
        </div>
        <div class="mb-4">
            <annotationfilter :corpusresults="corpusresults" ref="annotationFilter" v-on:annotation-filter="emitAnnotationFilter"></annotationfilter>
        </div>
    </div>
</template>
<script>
    import { mapState, mapActions, mapGetters } from 'vuex'
    export default {
        props: ['corpusresults','activefilters'],
        methods: {
            applyFilters: function (){
                this.$refs.corpusFilter.emitCorpusFilter()
            },
            emitCorpusFilter: function (corpusFilterEmitData) {
                this.$emit('corpus-filter',corpusFilterEmitData);
            },
            emitDocumentFilter: function (documentFilterEmitData) {
                this.$emit('document-filter',documentFilterEmitData);
            },
            emitAnnotationFilter: function (annotaitonFilterEmitData) {
                this.$emit('annotation-filter',annotaitonFilterEmitData);
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