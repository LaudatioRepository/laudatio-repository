<template lang="html">
<div id="searchresultpanelcorpus">
        <p class="searchTerm"> Search term: {{result.search.generalSearchTerm}}</p>
        <p class="searchScope">Scope: {{result.search.scope}}</p>
        <ul>
            <li v-for="corpusresult in result.results" v-bind:key="corpusresult._id">
                {{ corpusresult._source.corpus_title | arrayToString }}
            </li>
        </ul>

    </div>
</template>

<script>
    export default {
        props: ['result'],
        mounted() {
            console.log('ResultComponent mounted.')
            console.log('Result: '+this.result);
        }
    }
</script>
