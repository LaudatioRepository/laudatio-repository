<template lang="html">
<div id="searchwrapper">

    <div v-if="annotationresults.length >= 1">
        <searchresultpanel_annotation v-for="annotationresult in annotationresults"  v-bind:annotationresult="annotationresult" :key="annotationresult"></searchresultpanel_annotation>
    </div>

    <div  v-else-if="annotationresults.length == 0 && annotationsearched" class="alert alert-info" role="alert">
        <strong>Your search returned no results!</strong>
    </div>
</div>
</template>

<script>
    export default {
        props: ['annotationresults', 'annotationsearched'],
        mounted() {
            console.log('AnnotationResultComponent mounted.')
        }
    }
</script>

<style lang="css">

</style>