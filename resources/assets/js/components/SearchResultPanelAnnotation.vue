<template lang="html">
<div id="searchresultpanelannotation">
<!--
        <p class="searchTerm"> Search term: {{annotationresult.search}}</p>
        <p class="searchScope">Scope: {{annotationresult.scope}}</p>
        -->
         <div class="list-group">
            <a href="" class="list-group-item" v-for="annotationresultdata in annotationresult.results" v-bind:key="annotationresultdata._id">
                {{ annotationresultdata._source.preparation_title | arrayToString  }}
            </a>
        </div>

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
