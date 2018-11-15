<template>
    <div class="col">
        <i v-show="corpusloading" class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
        <span v-show="corpusloading" class="sr-only">Loading...</span>
        <h3 class="h3 font-weight-normal mb-4" v-if="searches != 'undefined' && searches.length >= 1 && corpusresults != 'undefined' && corpusresults.length >= 1">
            Results for the search &quot;{{searches.join(" ")}}&quot;</h3>


        <div  v-else-if="corpusresults != 'undefined' && corpusresults.length < 1 && corpussearched && !corpusloading" class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>The search <i>&quot;{{searches.join(" ")}}&quot;</i> returned no results!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>



        <searchresultheader
                :corpusresults="corpusresults"
                :documentresults="documentresults"
                :annotationresults="annotationresults"
                :documentsbycorpus="documentsbycorpus"
                :annotationsbycorpus="annotationsbycorpus"
                :corpusresultcounter="corpusresultcounter"
                :documentresultcounter="documentresultcounter"
                :annotationresultcounter="annotationresultcounter"
                ></searchresultheader>


        <div class="tab-content">
            <div class="tab-pane active" id="searchtab-corpora" role="tabpanel" aria-labelledby="searchtab-corpora">
            <corpussearchresult
                    v-if="corpusresults != 'undefined' && corpusresults.length >= 1"
                    v-for="(corpusresult, index) in corpusresults"
                    v-bind:corpusresult="corpusresult"
                    :key="guid(index)"
                    :documentsbycorpus="documentsbycorpus"
                    :annotationsbycorpus="annotationsbycorpus"></corpussearchresult>
            </div>

            <documentsearchresult
                   :documentresults="documentresults"></documentsearchresult>

            <annotationsearchresult
                   :annotationresults="annotationresults"></annotationsearchresult>
        </div>

        <div class="container d-flex flex-column align-items-center justify-content-center mb-5 mt-5"
             v-if="
                    (corpusresults != 'undefined' && corpusresults.length > 0) ||
                    (documentresults != 'undefined' && documentresults.length > 0) ||
                    (annotationresults != 'undefined' && annotationresults.length > 0)">
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
        </div>
    </div>
</template>
<script>
    import { mapState, mapActions, mapGetters } from 'vuex'
    export default {
        props: ['corpusresults', 'documentresults', 'annotationresults', 'corpussearched','corpusloading','documentsbycorpus','annotationsbycorpus', 'searches','corpusresultcounter','documentresultcounter','annotationresultcounter'],
        methods: {
            guid: function(key) {
                return key + ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, c =>
                    (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16))
            }
        },
        computed:
            mapGetters({
                stateDocumentCorpusresults: 'documentcorpus',
                stateAnnotationCorpusresults: 'annotationcorpus'
            }),
        mounted() {
            console.log('CorpusResultComponent mounted.')
        }
    }
</script>