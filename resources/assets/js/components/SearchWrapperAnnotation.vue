<template lang="html">
<div id="searchwrapper">
    <i v-show="annotationloading" class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
        <span v-show="annotationloading" class="sr-only">Loading...</span>
    <div v-if="annotationresults && annotationresults.length >= 1">
        <searchresultpanel_annotation v-for="annotationresult in annotationresults"  v-bind:annotationresult="annotationresult" :key="annotationresult"></searchresultpanel_annotation>
    </div>

    <div v-else-if="stateCorpusAnnotationresults && stateCorpusAnnotationresults.length >= 1">
        <searchresultpanel_annotation v-for="annotationresult in stateCorpusAnnotationresults"  v-bind:annotationresult="annotationresult" :key="annotationresult"></searchresultpanel_annotation>
    </div>

     <div v-else-if="stateDocumentAnnotationresults && stateDocumentAnnotationresults.length >= 1">
        <searchresultpanel_annotation v-for="annotationresult in stateDocumentAnnotationresults"  v-bind:annotationresult="annotationresult" :key="annotationresult"></searchresultpanel_annotation>
    </div>

    <div  v-else-if="annotationresults.length == 0 && annotationsearched && !annotationloading" class="alert alert-info" role="alert">
        <strong>Your search returned no results!</strong>
    </div>
</div>
</template>

<script>
    import { mapState, mapActions } from 'vuex'
    export default {
        props: ['annotationresults', 'annotationsearched','annotationloading'],
        computed:
            mapState({
                stateCorpusAnnotationresults: state => state.annotationsByCorpus[0],
                stateDocumentAnnotationresults: state => state.annotationsByDocument[0],
            }),
        mounted() {
            console.log('AnnotationResultComponent mounted.')
        }
    }
</script>

<style lang="css">

</style>