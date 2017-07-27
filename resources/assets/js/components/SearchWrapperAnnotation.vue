<template lang="html">
<div id="searchwrapper">
    <i v-show="annotationloading" class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
        <span v-show="annotationloading" class="sr-only">Loading...</span>
    <div v-if="annotationresults.length >= 1">
        <searchresultpanel_annotation v-for="annotationresult in annotationresults"  v-bind:annotationresult="annotationresult" :key="annotationresult"></searchresultpanel_annotation>
    </div>

    <div  v-else-if="annotationresults.length == 0 && annotationsearched && !annotationloading" class="alert alert-info" role="alert">
        <strong>Your search returned no results!</strong>
    </div>
</div>
</template>

<script>
    export default {
        props: ['annotationresults', 'annotationsearched','annotationloading'],
        mounted() {
            console.log('AnnotationResultComponent mounted.')
        }
    }
</script>

<style lang="css">

</style>