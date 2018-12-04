<template lang="html">
<div id="searchwrapper">
<i v-show="documentloading" class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
        <span v-show="documentloading" class="sr-only">Loading...</span>
    <div v-if="documentresults && documentresults.length >= 1">
        <searchresultpanel_document v-for="(documentresult, index) in documentresults"  v-bind:documentresult="documentresult" :key="index" :annotationsbydocument="annotationsbydocument" :corpusbydocument="corpusbydocument"></searchresultpanel_document>
    </div>

    <div v-else-if="statedocumentresults && statedocumentresults.length >= 1">
        <searchresultpanel_document v-for="(documentresult, index) in statedocumentresults"  v-bind:documentresult="documentresult" :key="index" :annotationsbydocument="annotationsbydocument" :corpusbydocument="corpusbydocument"></searchresultpanel_document>
    </div>

    <div v-else-if="stateannotationdocumentresults && stateannotationdocumentresults.length >= 1">
        <searchresultpanel_document v-for="(documentresult, index) in stateannotationdocumentresults"  v-bind:documentresult="documentresult" :key="index" :annotationsbydocument="annotationsbydocument" :corpusbydocument="corpusbydocument"></searchresultpanel_document>
    </div>

    <div  v-else-if="documentresults.length == 0 && documentsearched && !documentloading" class="alert alert-info" role="alert">
        <strong>Your search returned no results!</strong>
    </div>
</div>
</template>

<script>
    import { mapState, mapActions, mapGetters } from 'vuex'
    export default {
        props: ['documentresults','documentsearched','documentloading','annotationsbydocument', 'corpusbydocument'],
        computed:
            mapGetters({
                statedocumentresults: 'corpusdocuments',
                stateannotationdocumentresults: 'annotationdocuments'
            }),
        mounted() {
            console.log('DocumentResultComponent mounted.')
        }
    }
</script>

<style lang="css">

</style>