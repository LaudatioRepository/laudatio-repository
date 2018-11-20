<template>
    <div class="container bg-corpus-superlight mt-1 mb-1 p-5" v-if="documentresult._source.visibility == 1">
        <div class="row">
            <div class="col">
                <h4 class="h4 font-weight-bold">
                    <a class="text-dark" v-bind:href="browseUri(documentresult._id)">
                        {{documentresult._source.document_title | arrayToString}}
                    </a>
                </h4>
                <span class="text-grey text-14">
                    Corpus: {{documentresult._source.corpus_name}}
                    <br> {{documentresult._source.document_author_surname | arrayToString}}, {{documentresult._source.document_author_forename | arrayToString}}</span>
                <div class="row mt-2">
                    <div class="col d-flex flex-wrap justify-content-start">
                        <div class="mr-7">
                            <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                <i class="fa fa-fw fa-clock-o mr-1"></i>
                                <span>{{documentresult._source.document_publication_publishing_date | arrayToString}}</span>
                            </div>
                        </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                        <i class="fa fa-fw fa-cubes mr-1"></i>
                        <span> {{documentresult._source.document_size_extent | arrayToString}} {{documentresult._source.document_size_type | arrayToString}}</span>
                    </div>

                    </div>
                </div>
            </div>
            <div class="col-4 mr-3 d-flex justify-content-between align-items-start">
                <a href="#" class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                    <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                    <span class="text-14 font-weight-bold">{{documentresult._source.document_list_of_annotations_id.length}}</span>
                </a>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="filtercheck-documentSearchItem0001">
                    <label class="custom-control-label text-14" for="filtercheck-documentSearchItem0001">
                        Set as Filter
                    </label>
                </div>
            </div>
        </div>

    </div>

        <!--div class="container d-flex flex-column align-items-center justify-content-center mb-5 mt-5">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <li class="page-item font-weight-bold active">
                    <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item font-weight-bold">
                    <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item font-weight-bold">
                    <a class="page-link" href="#">3</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="form-row">
            <div class="col-auto">

                <select class="custom-select custom-select-sm font-weight-bold text-uppercase">
                    <option selected>6 results / page</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
        </div>
    </div-->
</template>
<script>

    export default {
        props: ['documentresult'],
        methods: {
            browseUri: function(id) {
                return '/browse/document/'.concat(id);
            },
            emitDocumentRelations: function(documentId){
                this.$store.dispatch('clearCorpus',[])
                this.$store.dispatch('clearAnnotations',[])
                this.$store.dispatch('corpusByDocument',this.corpusbydocument[documentId])
                this.$store.dispatch('annotationByDocument',this.annotationsbydocument[documentId])
            }
        },
        mounted() {
            console.log('DocumentResultComponent mounted.')
        }
    }
</script>