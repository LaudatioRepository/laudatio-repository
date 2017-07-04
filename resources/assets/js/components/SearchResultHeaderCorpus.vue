<template lang="html">
    <div id="searchresultheadercorpus">
        Corpus Results
        <span class="searchTotal" v-if="corpusresults[0] != null">{{corpusresults.length}}</span>
    </div>
</template>

<script>
    export default {
        props: ['corpusresults'],
        mounted() {
            console.log('CorpusResultHeaderComponent mounted.')
        }
    }
</script>
