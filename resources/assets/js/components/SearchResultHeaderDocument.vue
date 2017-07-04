<template lang="html">
    <div id="searchresultheaderdocument">
        Annotation Results
        <span class="searchTotal" v-if="documentresults[0] != null">{{annotationresults.length}}</span>
    </div>
</template>

<script>
    export default {
        props: ['documentresults'],
        mounted() {
            console.log('DocumentResultHeaderComponent mounted.')
        }
    }
</script>
