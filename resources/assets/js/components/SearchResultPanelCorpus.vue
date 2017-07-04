<template lang="html">
<div id="searchresultpanelcorpus">
<!--
        <p class="searchTerm"> Search term: {{corpusresult.search}}</p>
        <p class="searchScope">Scope: {{corpusresult.scope}}</p>
        -->
        <div class="list-group">
            <a href="" class="list-group-item"  v-for="corpusresultdata in corpusresult.results" v-bind:key="corpusresultdata._id">
                {{ corpusresultdata._source.corpus_title | arrayToString }}
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['corpusresult'],
        mounted() {
            console.log('CorpusResultComponent mounted.')
        }
    }
</script>
