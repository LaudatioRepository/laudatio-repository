<template lang="html">
<div id="searchresultpaneldocument">
<!--
        <p class="searchTerm"> Search term: {{documentresult.search}}</p>
        <p class="searchScope">Scope: {{documentresult.scope}}</p>
        -->


        <div class="panel-group" id="accordion">
            <div class="panel panel-default" v-for="documentresultdata in documentresult.results" v-bind:key="documentresultdata._id">
                <div class="panel-heading">
                    <div class="panel-title"  data-toggle="collapse" data-parent="#accordion" v-bind:data-target="documentresultdata._id | addHash">
                        {{ documentresultdata._source.document_title | arrayToString  }}
                    <i class="fa fa-expand pull-right" aria-hidden="true"></i>
                    </div>
                 </div>
                 <div :id="documentresultdata._id" class="panel-collapse collapse">
                    <div   class="panel-body">
                        <span class="iconwrapper"><i class="fa fa-university" aria-hidden="true"></i> Published: {{documentresultdata._source.document_publication_publishing_date | latestDate}}</span>
                            <span class="iconwrapper"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Annotations: {{documentresultdata._source.document_list_of_annotations_name.length}}</span>
                        <br /> <i class="fa fa-external-link pull-right" aria-hidden="true"></i>
                    </div>
                 </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: ['documentresult'],
        mounted() {
            console.log('DocumentResultComponent mounted.')
        }
    }
</script>
