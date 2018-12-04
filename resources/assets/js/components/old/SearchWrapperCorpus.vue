<template lang="html">
<div id="searchwrapper">
        <i v-show="corpusloading" class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
        <span v-show="corpusloading" class="sr-only">Loading...</span>
        <div v-if="corpusresults && corpusresults.length >= 1">
            <searchresultpanel_corpus v-for="(corpusresult, index) in corpusresults"  v-bind:corpusresult="corpusresult" :key="index" :documentsbycorpus="documentsbycorpus" :annotationsbycorpus="annotationsbycorpus"></searchresultpanel_corpus>
        </div>

        <div v-else-if="stateDocumentCorpusresults && stateDocumentCorpusresults.length >= 1">
            <searchresultpanel_corpus v-for="(corpusresult, index) in stateDocumentCorpusresults"  v-bind:corpusresult="corpusresult" :key="index" :documentsbycorpus="documentsbycorpus" :annotationsbycorpus="annotationsbycorpus"></searchresultpanel_corpus>
        </div>

        <div v-else-if="stateAnnotationCorpusresults && stateAnnotationCorpusresults.length >= 1">
            <searchresultpanel_corpus v-for="(corpusresult, index) in stateAnnotationCorpusresults"  v-bind:corpusresult="corpusresult" :key="index" :documentsbycorpus="documentsbycorpus" :annotationsbycorpus="annotationsbycorpus"></searchresultpanel_corpus>
        </div>

        <div  v-else-if="corpusresults.length == 0 && corpussearched && !corpusloading" class="alert alert-info" role="alert">
            <strong>Your search returned no results!</strong>
        </div>
</div>
</template>

<script>
    import { mapState, mapActions, mapGetters } from 'vuex'
    export default {
        props: ['corpusresults','corpussearched','corpusloading','documentsbycorpus','annotationsbycorpus'],
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

<style lang="css">

</style>