<template lang="html">
    <div id="searchresultheaderdocument">
        Document Results
        <span class="searchTotal" v-if="documentresults[0] != null">{{documentresults.length}}</span>
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
