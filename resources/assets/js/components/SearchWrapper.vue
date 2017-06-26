<template lang="html">
<div id="searchwrapper">
    <searchresultpanel_corpus v-for="result in results"  v-bind:result="result" :key="result"></searchresultpanel_corpus>
</div>
</template>

<script>
    export default {
        props: ['results'],
        mounted() {
            console.log('RESULTComponent mounted.')
        }
    }
</script>

<style lang="css">

</style>