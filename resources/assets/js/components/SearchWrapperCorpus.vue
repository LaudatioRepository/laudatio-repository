<template lang="html">
<div id="searchwrapper">
    <searchresultpanel_corpus v-for="corpusresult in corpusresults"  v-bind:corpusresult="corpusresult" :key="corpusresult"></searchresultpanel_corpus>
</div>
</template>

<script>
    export default {
        props: ['corpusresults'],
        mounted() {
            console.log('CorpusResultComponent mounted.')
        }
    }
</script>

<style lang="css">

</style>