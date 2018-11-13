<template>
    <div class="col">
        <i v-show="corpusloading" class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
        <span v-show="corpusloading" class="sr-only">Loading...</span>
        <h3 class="h3 font-weight-normal mb-4" v-if="searches != 'undefined' && searches.length >= 1 && corpusresults != 'undefined' && corpusresults.length >= 1">
            Results for the search &quot;{{searches.join(" ")}}&quot;</h3>


        <div  v-else-if="corpusresults != 'undefined' && corpusresults.length < 1 && corpussearched && !corpusloading" class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>The search <i>&quot;{{searches.join(" ")}}&quot;</i> returned no results!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>



        <searchresultheader :corpusresults="corpusresults"></searchresultheader>


        <div class="tab-content">
            <corpussearchresult
                    v-if="corpusresults != 'undefined' && corpusresults.length >= 1"
                    v-for="(corpusresult, index) in corpusresults"
                    v-bind:corpusresult="corpusresult"
                    :key="index"
                    :documentsbycorpus="documentsbycorpus"
                    :annotationsbycorpus="annotationsbycorpus"></corpussearchresult>

            <documentsearchresult></documentsearchresult>
            <annotationsearchresult></annotationsearchresult>
        </div>

    </div>
</template>
<script>
    import { mapState, mapActions, mapGetters } from 'vuex'
    export default {
        props: ['corpusresults','corpussearched','corpusloading','documentsbycorpus','annotationsbycorpus', 'searches', 'corpuspaths'],
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