<template lang="html">
<div id="searchwrapper">
        <i v-show="corpusloading" class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
        <span v-show="corpusloading" class="sr-only">Loading...</span>
    <div v-if="corpusresults.length >= 1">
        <searchresultpanel_corpus v-for="corpusresult in corpusresults"  v-bind:corpusresult="corpusresult" :key="corpusresult"></searchresultpanel_corpus>
    </div>

    <div  v-else-if="corpusresults.length == 0 && corpussearched && !corpusloading" class="alert alert-info" role="alert">
        <strong>Your search returned no results!</strong>
    </div>
</div>
</template>

<script>
    export default {
        props: ['corpusresults','corpussearched','corpusloading'],
        mounted() {
            console.log('CorpusResultComponent mounted.')
        }
    }
</script>

<style lang="css">

</style>