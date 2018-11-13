<template lang="html">
    <div class="col-3 ">
        <div class="d-flex justify-content-between mt-7 mb-3">
            <h3 class="h3 font-weight-normal">Filter</h3>
        </div>
        <div class="mb-4">
            <activefilter :corpusresults="corpusresults"></activefilter>
        </div>
        <div class="mb-4">
            <corpusfilter :corpusresults="corpusresults"></corpusfilter>
        </div>
        <div class="mb-4">
            <documentfilter :corpusresults="corpusresults"></documentfilter>
        </div>
        <div class="mb-4">
            <annotationfilter :corpusresults="corpusresults"></annotationfilter>
        </div>
    </div>
</template>
<script>
    import { mapState, mapActions, mapGetters } from 'vuex'
    export default {
        props: ['corpusresults'],
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