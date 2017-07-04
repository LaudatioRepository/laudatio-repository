<template lang="html">
<div id="searchwrapper">

    <searchresultpanel_annotation v-for="annotationresult in annotationresults"  v-bind:annotationresult="annotationresult" :key="annotationresult"></searchresultpanel_annotation>
</div>
</template>

<script>
    export default {
        props: ['annotationresults'],
        mounted() {
            console.log('AnnotationResultComponent mounted.')
        }
    }
</script>

<style lang="css">

</style>