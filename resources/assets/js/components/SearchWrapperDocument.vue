<template lang="html">
<div id="searchwrapper">

    <div v-if="documentresults.length >= 1">
        <searchresultpanel_document v-for="documentresult in documentresults"  v-bind:documentresult="documentresult" :key="documentresult"></searchresultpanel_document>
    </div>

    <div  v-else-if="documentresults.length == 0 && documentsearched" class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Your search returned no results!</strong>
    </div>
</div>
</template>

<script>
    export default {
        props: ['documentresults','documentsearched'],
        mounted() {
            console.log('DocumentResultComponent mounted.')
        }
    }
</script>

<style lang="css">

</style>