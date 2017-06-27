<template lang="html">
<div id="searchresultpanelcorpus">
        <p>{{result.search}}</p>
        <p>{{result.result}}</p>
    </div>
</template>

<script>
    export default {
        props: ['result'],
        mounted() {
            console.log('ResultComponent mounted.')
        }
    }
</script>
