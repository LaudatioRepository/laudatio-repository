<template lang="html">
<div id="searchresultpanelannotation">
<!--
        <p class="searchTerm"> Search term: {{annotationresult.search}}</p>
        <p class="searchScope">Scope: {{annotationresult.scope}}</p>
        -->

        <ul class="list-group">
        <li class="list-group-item"  v-for="annotationresultdata in annotationresult.results" v-bind:key="annotationresultdata._id">
            {{ annotationtitle = annotationresultdata._source.preparation_title | arrayToString  }}
            <span class="badge">{{ inDocuments = annotationresult.documentsByAnnotation[annotationtitle] }}</span> <i class="fa fa-external-link pull-left" aria-hidden="true"></i>
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
