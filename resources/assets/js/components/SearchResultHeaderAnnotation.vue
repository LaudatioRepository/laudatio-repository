<template lang="html">
    <div id="searchresultheaderannotation">
        Annotation Results
        <span class="searchTotal" v-if="annotationresults[0] != null">{{getAnnotationTotal}}</span>
    </div>
</template>

<script>
    export default {
        props: ['annotationresults'],
        computed: {
            getAnnotationTotal: function() {
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
