<template>
    <div class="container bg-corpus-superlight mt-1 mb-1 p-5" v-if="annotationresult._source.visibility == 1">
        <div class="row">
            <div class="col">
                <h4 class="h4 font-weight-bold">
                    <a class="text-dark" v-bind:href="browseUri(annotationresult._id)" v-if="annotationhighlights.hasOwnProperty(annotationresult._id) && annotationhighlights[annotationresult._id][0].hasOwnProperty('preparation_title')" v-html="annotationhighlights[annotationresult._id][0].preparation_title">
                    </a>
                    <a v-else-if="filteredannotationhighlightmap.hasOwnProperty(annotationresult._id) && filteredannotationhighlightmap[annotationresult._id].hasOwnProperty('preparation_title')" v-html="filteredannotationhighlightmap[annotationresult._id].preparation_title"></a>
                    <a class="text-dark" v-bind:href="browseUri(annotationresult._id)" v-else>
                        {{annotationresult._source.preparation_title | arrayToString}}
                    </a>
                </h4>
                <span class="text-grey text-14">
                    Corpus: {{annotationresult._source.corpus_name}}
                  </span>
            </div>
            <div class="col-2">
                <div class="text-grey text-14" v-if="annotationhighlights.hasOwnProperty(annotationresult._id) && annotationhighlights[annotationresult._id][0].hasOwnProperty('preparation_encoding_annotation_group')" v-html="annotationhighlights[annotationresult._id][0].preparation_encoding_annotation_group"></div>
                <div class="text-grey text-14" v-else-if="filteredannotationhighlightmap.hasOwnProperty(annotationresult._id) && filteredannotationhighlightmap[annotationresult._id].hasOwnProperty('preparation_encoding_annotation_group')" v-html="filteredannotationhighlightmap[annotationresult._id].preparation_encoding_annotation_group"></div>
                <div class="text-grey text-14" v-for="(group, groupindex) in unique(annotationresult._source.preparation_encoding_annotation_group)" v-bind:group="group" :key="groupindex" v-else>{{group}}</div>
            </div>
            <div class="col-2">
                <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                    <i class="fa fa-fw fa-globe mr-1"></i>
                    <span v-if="annotationhighlights.hasOwnProperty(annotationresult._id) && annotationhighlights[corpusresult._id][0].hasOwnProperty('annotation_merged_formats')" v-html="annotationhighlights[annotationresult._id][0].annotation_merged_formats"></span>
                    <span v-else-if="filteredannotationhighlightmap.hasOwnProperty(annotationresult._id) && filteredannotationhighlightmap[annotationresult._id].hasOwnProperty('annotation_merged_formats')" v-html="filteredannotationhighlightmap[annotationresult._id].annotation_merged_formats"></span>
                    <span v-else>{{annotationresult._source.annotation_merged_formats | truncatelist}}</span>
                </div>
            </div>
            <div class="col-4 d-flex justify-content-between align-items-start" v-if="typeof annotationresult._source.in_documents !== 'undefined' && Object.keys(annotationresult._source.in_documents).length > 0">
                <a href="#" class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                    <i class="fa fa-text-height fa-fw fa-file-text-o align-baseline fa-lg text-wine"></i>
                    <span class="text-primary text-14 font-weight-bold">{{annotationresult._source.in_documents.length}}</span>
                </a>
                <!--div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="filtercheck-annotationSearchItem0001">
                    <label class="custom-control-label text-14" for="filtercheck-annotationSearchItem0001">
                        Set as Filter
                    </label>
                </div-->
            </div>
        </div>

    </div>
</template>
<script>
    export default {
        props: ['annotationresult','annotationhighlights','filteredannotationhighlightmap'],
        methods: {
            browseUri: function(id,type) {
                return '/browse/annotation/'.concat(id);
            },
            emitAnnotationRelations: function(annotationId) {
                this.$store.dispatch('clearCorpus',[])
                this.$store.dispatch('clearDocuments',[])
                this.$store.dispatch('corpusByAnnotation',this.corpusbyannotation[annotationId])
                this.$store.dispatch('documentByAnnotation',this.documentsbyannotation[annotationId])
            },
            unique: function (array) {
                return [...new Set(array)]
            }
        },
        mounted() {

        }
    }
</script>