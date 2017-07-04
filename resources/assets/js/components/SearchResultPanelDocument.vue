<template lang="html">
<div id="searchresultpaneldocument">
        <p class="searchTerm"> Search term: {{documentresult.search}}</p>
        <p class="searchScope">Scope: {{documentresult.scope}}</p>
        <ul>
            <li v-for="documentresultdata in documentresult.results" v-bind:key="documentresultdata._id">
                {{ documentresultdata._source.document_title | arrayToString  }}
            </li>
        </ul>

    </div>
</template>

<script>
    export default {
        props: ['documentresult'],
        mounted() {
            console.log('DocumentResultComponent mounted.')
        }
    }
</script>
