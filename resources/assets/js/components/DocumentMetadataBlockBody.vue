<template lang="html">
    <div class="tab-content" v-if="header == 'document'">
        <div id="project" class="tab-pane fade in active panel panel-default">
        <div class="panel-body"></div>
        <div id="annotators" class="tab-pane fade in active panel panel-default">
            <ul class="list-group">
                <li v-for="annotation in headerdata.document_list_of_annotations_name" v-bind:annotation="annotation" :key="annotation" class="list-group-item">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{annotation}}
                </li>
            </ul>
        </div>
        <div id="revisions" class="tab-pane fade">

        </div>
        <div id="annotations" class="tab-pane fade">

        </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: ['headerdata','header'],
        data: function(){
            return {
                annotators: [],
                revisions: [],
                documentsByAnnotation: []
            }

        },
        computed: {

        },
        mounted() {
            console.log('CorpusMetadataBlockBody mounted.')
        }
    }
</script>