<template lang="html">
<div id="searchresultpanelannotation">
        <p class="searchTerm"> Search term: {{annotationresult.search}}</p>
        <p class="searchScope">Scope: {{annotationresult.scope}}</p>
        <ul>
            <li v-for="annotationresultdata in annotationresult.results" v-bind:key="annotationresultdata._id">
                {{ annotationresultdata._source.preparation_title | arrayToString  }}
            </li>
        </ul>

    </div>
</template>

<script>
    export default {
        props: ['annotationresult'],
        mounted() {
            console.log('AnnotationResultComponent mounted.')
        }
    }
</script>
