<template lang="html">
    <div id="searchresultheaderannotation">
        Annotation Results
        <span class="searchTotal" v-if="annotationresults[0] != null">{{annotationresults.length}}</span>
    </div>
</template>

<script>
    export default {
        props: ['annotationresults'],
        mounted() {
            console.log('AnnotationResultHeaderComponent mounted.')
        }
    }
</script>
