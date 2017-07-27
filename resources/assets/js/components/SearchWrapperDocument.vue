<template lang="html">
<div id="searchwrapper">
<i v-show="documentloading" class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
        <span v-show="documentloading" class="sr-only">Loading...</span>
    <div v-if="documentresults.length >= 1">
        <searchresultpanel_document v-for="documentresult in documentresults"  v-bind:documentresult="documentresult" :key="documentresult"></searchresultpanel_document>
    </div>

    <div  v-else-if="documentresults.length == 0 && documentsearched && !documentloading" class="alert alert-info" role="alert">
        <strong>Your search returned no results!</strong>
    </div>
</div>
</template>

<script>
    export default {
        props: ['documentresults','documentsearched','documentloading'],
        mounted() {
            console.log('DocumentResultComponent mounted.')
        }
    }
</script>

<style lang="css">

</style>