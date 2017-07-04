<template lang="html">
<div id="searchwrapper">
    <searchresultpanel_document v-for="documentresult in documentresults"  v-bind:documentresult="documentresult" :key="documentresult"></searchresultpanel_document>
</div>
</template>

<script>
    export default {
        props: ['documentresults'],
        mounted() {
            console.log('DocumentResultComponent mounted.')
        }
    }
</script>

<style lang="css">

</style>