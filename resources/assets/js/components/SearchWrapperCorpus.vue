<template lang="html">
<div id="searchwrapper">
    <div v-if="corpusresults.length >= 1">
        <searchresultpanel_corpus v-for="corpusresult in corpusresults"  v-bind:corpusresult="corpusresult" :key="corpusresult"></searchresultpanel_corpus>
    </div>

    <div  v-else-if="corpusresults.length == 0 && corpussearched" class="alert alert-info alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Your search returned no results!</strong>
    </div>
</div>
</template>

<script>
    export default {
        props: ['corpusresults','corpussearched'],
        mounted() {
            console.log('CorpusResultComponent mounted.')
        }
    }
</script>

<style lang="css">

</style>