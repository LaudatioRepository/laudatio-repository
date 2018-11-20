<template>
    <div class="container bg-corpus-superlight mt-1 mb-1 p-5" v-if="annotationresult._source.visibility == 1">
        <div class="row">
            <div class="col">
                <h4 class="h4 font-weight-bold">
                    <a class="text-dark" v-bind:href="browseUri(annotationresult._id)">
                        {{annotationresult._source.preparation_title | arrayToString}}
                    </a>
                </h4>
                <span class="text-grey text-14">
                    Corpus: {{annotationresult._source.corpus_name}}
                  </span>
            </div>
            <div class="col-2">
                <span class="text-grey text-14">{{annotationresult._source.preparation_encoding_annotation_group | lastElement}}</span>
            </div>
            <div class="col-4 d-flex justify-content-between align-items-start">
                <a href="#" class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                    <i class="fa fa-text-height fa-fw fa-file-text-o align-baseline fa-lg text-wine"></i>
                    <span class="text-primary text-14 font-weight-bold">{{annotationresult._source.in_documents.length}}</span>
                </a>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="filtercheck-annotationSearchItem0001">
                    <label class="custom-control-label text-14" for="filtercheck-annotationSearchItem0001">
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
        props: ['annotationresult'],
        methods: {
            browseUri: function(id,type) {
                return '/browse/annotation/'.concat(id);
            },
            emitAnnotationRelations: function(annotationId) {
                this.$store.dispatch('clearCorpus',[])
                this.$store.dispatch('clearDocuments',[])
                this.$store.dispatch('corpusByAnnotation',this.corpusbyannotation[annotationId])
                this.$store.dispatch('documentByAnnotation',this.documentsbyannotation[annotationId])
            }
        },
        mounted() {
            console.log('AnnotationResultComponent mounted.')
        }
    }
</script>