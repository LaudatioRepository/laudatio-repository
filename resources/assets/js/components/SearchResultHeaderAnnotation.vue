<template lang="html">
    <div id="searchresultheaderannotation">
        Annotation Results
        <span class="searchTotal" v-if="annotationresults[0] != null">{{annotationresults.length}}</span>
    </div>
</template>

<script>
    export default {
        props: ['annotationresults'],
        computed: {
            getTotal: function() {
                if(this.annotationresults.length){
                    return this.annotationresults[0].total
                }
                else{
                    return 0;
                }
            }
        },
        mounted() {
            console.log('AnnotationResultHeaderComponent mounted.')
        }
    }
</script>
