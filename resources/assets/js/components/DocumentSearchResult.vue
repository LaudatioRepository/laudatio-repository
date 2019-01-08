<template>
    <div class="container bg-corpus-superlight mt-1 mb-1 p-5" v-if="documentresult._source.visibility == 1">
        <div class="row">
            <div class="col">
                <h4 class="h4 font-weight-bold">


                    <a class="text-dark" v-bind:href="browseUri(documentresult._id)" v-if="documenthighlights.hasOwnProperty(documentresult._id) && documenthighlights[documentresult._id][0].hasOwnProperty('document_title')" v-html="documenthighlights[documentresult._id][0].document_title">
                    </a>
                    <a v-else-if="filtereddocumenthighlightmap.hasOwnProperty(documentresult._id) && filtereddocumenthighlightmap[documentresult._id].hasOwnProperty('document_title')" v-html="filtereddocumenthighlightmap[documentresult._id].document_title"></a>
                    <a class="text-dark" v-bind:href="browseUri(documentresult._id)" v-else>
                        {{documentresult._source.document_title | arrayToString}}
                    </a>


                </h4>
                <span class="text-grey text-14">
                    Corpus: {{documentresult._source.corpus_name}}
                    <br>
                    <span v-if="documenthighlights.hasOwnProperty(documentresult._id) && documenthighlights[documentresult._id][0].hasOwnProperty('document_author_surname')" v-html="documenthighlights[documentresult._id][0].document_author_surname"></span>
                    <span v-else-if="filtereddocumenthighlightmap.hasOwnProperty(documentresult._id) && filtereddocumenthighlightmap[documentresult._id].hasOwnProperty('document_merged_authors')" v-html="highlightName(documentresult._source.document_author_surname[0],filtereddocumenthighlightmap[documentresult._id].document_merged_authors)"></span>
                    <span v-else>{{documentresult._source.document_author_surname | arrayToString}}</span>,
                    <span v-if="documenthighlights.hasOwnProperty(documentresult._id) && documenthighlights[documentresult._id][0].hasOwnProperty('document_author_forename')" v-html="documenthighlights[documentresult._id][0].document_merged_authors"></span>
                    <span v-else-if="filtereddocumenthighlightmap.hasOwnProperty(documentresult._id) && filtereddocumenthighlightmap[documentresult._id].hasOwnProperty('document_merged_authors')" v-html="highlightName(documentresult._source.document_author_forename[0],filtereddocumenthighlightmap[documentresult._id].document_merged_authors)"></span>
                    <span v-else>{{documentresult._source.document_author_forename | arrayToString}}</span>
                </span>
                <div class="row mt-2">
                    <div class="col d-flex flex-wrap justify-content-start">
                        <div class="mr-7">
                            <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                <i class="fa fa-fw fa-clock-o mr-1"></i>
                                <span>{{documentresult._source.document_publication_publishing_date | arrayToString}}</span>
                            </div>
                        </div>
                        <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                            <i class="fa fa-fw fa-cubes mr-1"></i>
                            <span> {{documentresult._source.document_size_extent | arrayToString}} {{documentresult._source.document_size_type | arrayToString}}</span>
                        </div>
                        <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap" v-if="documentresult._source.document_merged_languages != 'undefined'">
                            <i class="fa fa-fw fa-globe mr-1"></i>
                            <span v-if="documenthighlights.hasOwnProperty(documentresult._id) && documenthighlights[documentresult._id][0].hasOwnProperty('document_merged_languages')" v-html="documenthighlights[documentresult._id][0].document_merged_languages"></span>
                            <span v-else-if="filtereddocumenthighlightmap.hasOwnProperty(documentresult._id) && filtereddocumenthighlightmap[documentresult._id].hasOwnProperty('document_merged_languages')" v-html="filtereddocumenthighlightmap[documentresult._id].document_merged_languages"></span>
                            <span v-else>{{documentresult._source.document_merged_languages}}</span>
                        </div>
                        <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap" v-if="documentresult._source.document_publication_place != 'undefined'">
                            <i class="fa fa-fw fa-map-marker mr-1"></i>
                            <span v-if="documenthighlights.hasOwnProperty(documentresult._id) && documenthighlights[documentresult._id][0].hasOwnProperty('document_publication_place')" v-html="documenthighlights[documentresult._id][0].document_publication_place"></span>
                            <span v-else-if="filtereddocumenthighlightmap.hasOwnProperty(documentresult._id) && filtereddocumenthighlightmap[documentresult._id].hasOwnProperty('document_publication_place')" v-html="filtereddocumenthighlightmap[documentresult._id].document_publication_place"></span>
                            <span v-else>{{documentresult._source.document_publication_place | arrayToString}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4 mr-3 d-flex justify-content-between align-items-start">
                <a href="#" class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                    <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                    <span class="text-14 font-weight-bold">{{documentresult._source.document_list_of_annotations_id.length}}</span>
                </a>
                <!--div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="filtercheck-documentSearchItem0001">
                    <label class="custom-control-label text-14" for="filtercheck-documentSearchItem0001">
                        Set as Filter
                    </label>
                </div-->
            </div>
        </div>

    </div>
</template>
<script>

    export default {
        props: ['documentresult','documenthighlights','filtereddocumenthighlightmap'],
        methods: {
            browseUri: function(id) {
                return '/browse/document/'.concat(id);
            },
            highlightName: function(name, markup){
                var returnedName = name;
                if(markup.indexOf(name) > -1){
                    returnedName = markup;
                }
                return returnedName;
            },
            emitDocumentRelations: function(documentId){
                this.$store.dispatch('clearCorpus',[])
                this.$store.dispatch('clearAnnotations',[])
                this.$store.dispatch('corpusByDocument',this.corpusbydocument[documentId])
                this.$store.dispatch('annotationByDocument',this.annotationsbydocument[documentId])
            }
        },
        mounted() {

        }
    }
</script>