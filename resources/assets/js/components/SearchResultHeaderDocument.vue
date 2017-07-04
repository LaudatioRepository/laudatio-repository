<template lang="html">
    <div id="searchresultheaderdocument">
        Document Results
        <span class="searchTotal" v-if="documentresults[0] != null">{{getTotal}}</span>
    </div>
</template>

<script>
    export default {
        props: ['documentresults'],
        computed: {
            getTotal: function() {
                if(this.documentresults.length){
                    return this.documentresults[0].total
                }
                else{
                    return 0;
                }
            }
        },
        mounted() {
            console.log('DocumentResultHeaderComponent mounted.')
        }
    }
</script>
