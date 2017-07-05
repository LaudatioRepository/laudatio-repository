<template lang="html">
<div id="searchresultpanelannotation">
<!--
        <p class="searchTerm"> Search term: {{annotationresult.search}}</p>
        <p class="searchScope">Scope: {{annotationresult.scope}}</p>
        -->

        <div class="panel-group" id="accordion">
            <div class="panel panel-default" v-for="annotationresultdata in annotationresult.results" v-bind:key="annotationresultdata._id">
                <div class="panel-heading">
                    <div class="panel-title"  data-toggle="collapse" data-parent="#accordion" v-bind:data-target="annotationresultdata._id | addHash">
                    {{ annotationresultdata._source.preparation_title | arrayToString  }}
                    <i class="fa fa-expand pull-right" aria-hidden="true"></i>
                    </div>
                 </div>
                 <div :id="annotationresultdata._id" class="panel-collapse collapse">
                    <div   class="panel-body">
                        BODHI
                    </div>
                 </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: ['annotationresult'],
        mounted() {
            console.log('AnnotationResultComponent mounted.')
        }
    }
</script>
