<template lang="html">
    <div id="searchresultheadercorpus">
        Corpus Results
        <span class="searchTotal" v-if="corpusresults[0] != null">{{getCorpusTotal}}</span>
    </div>
</template>

<script>
    export default {
        props: ['corpusresults'],
        computed: {
            getCorpusTotal: function() {
                if(this.corpusresults.length){
                    return this.corpusresults[0].total
                }
                else{
                    return 0;
                }

            }
        },
        mounted() {
            console.log('CorpusResultHeaderComponent mounted.')
        }
    }
</script>
