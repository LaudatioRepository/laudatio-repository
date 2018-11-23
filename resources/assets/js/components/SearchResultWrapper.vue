<template>
    <div class="col">
        <i v-show="dataloading" class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
        <span v-show="dataloading" class="sr-only">Loading...</span>

        <div v-if="
            searches != 'undefined' &&
            searches.length >= 1 &&
            searches[0] == 'laudatio_init'"
        >&nbsp;</div>

        <h3 class="h3 font-weight-normal mb-4" v-else-if="
            searches != 'undefined' &&
            searches.length >= 1 &&
            !datasearched &&
            !dataloading &&
            (corpusresults != 'undefined' &&
            corpusresults.length >= 1) ||
            (documentresults != 'undefined' &&
            documentresults.length >= 1) ||
            (annotationresults != 'undefined' &&
            annotationresults.length >= 1)">
            Results for the search &quot;{{searches.join(" ")}}&quot;</h3>

        <div  v-else-if="
            corpusresults != 'undefined' &&
            corpusresults.length < 1 &&
            documentresults != 'undefined' &&
            documentresults.length < 1 &&
            annotationresults != 'undefined' &&
            annotationresults.length < 1 &&
            datasearched &&
            !dataloading &&
            searches != 'undefined' &&
            searches.length >= 1"
              class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>The search <i>&quot;{{searches.join(" ")}}&quot;</i> returned no results!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <searchresultheader
                :corpusresults="corpusresults"
                :documentresults="documentresults"
                :annotationresults="annotationresults"
                :corpusresultcounter="corpusresultcounter"
                :documentresultcounter="documentresultcounter"
                :annotationresultcounter="annotationresultcounter"
                ></searchresultheader>


        <div class="tab-content">
            <div class="tab-pane active" id="searchtab-corpora" role="tabpanel" aria-labelledby="searchtab-corpora">
            <corpussearchresult
                    v-if="corpusresults != 'undefined' && corpusresults.length >= 1 && index >= ((currentCorpusPage*corpusPerPage) - corpusPerPage) && index < (currentCorpusPage*corpusPerPage)"
                    v-for="(corpusresult, index) in corpusresults"
                    v-bind:corpusresult="corpusresult"
                    :key="guid(index)"
                    ></corpussearchresult>
                <pagination
                        v-if="corpusresults != 'undefined' && corpusresults.length >= 1 && corpusresults.length >= corpusPerPage"
                        :totalPages="(corpusresults.length / corpusPerPage)"
                        :total="corpusresults.length"
                        :currentPage="currentCorpusPage"
                        :perPage="corpusPerPage"
                        :headerType="'corpus'"
                        v-on:corpus_pagechanged="corpusCurrentPageChange"
                        v-on:corpus_resultsperpage="corpusPerPageChange"
                ></pagination>
            </div>
            <div class="tab-pane" id="searchtab-documents" role="tabpanel" aria-labelledby="searchtab-documents">
                <documentsearchresult
                        v-if="documentresults != 'undefined' && documentresults.length >= 1 && documentindex >= ((currentDocumentPage*documentPerPage) - documentPerPage) && documentindex < (currentDocumentPage*documentPerPage)"
                        v-for="(documentresult, documentindex) in documentresults"
                        v-bind:documentresult="documentresult"
                        :key="guid(documentindex)"
                        ></documentsearchresult>
                <pagination
                        v-if="documentresults != 'undefined' && documentresults.length >= 1 && documentresults.length >= documentPerPage"
                        :totalPages="(documentresults.length / documentPerPage)"
                        :total="documentresults.length"
                        :currentPage="currentDocumentPage"
                        :perPage="documentPerPage"
                        :headerType="'document'"
                        v-on:document_pagechanged="documentCurrentPageChange"
                        v-on:document_resultsperpage="documentPerPageChange"
                ></pagination>
            </div>

            <div class="tab-pane" id="searchtab-annotations" role="tabpanel" aria-labelledby="searchtab-annotations">
                <annotationsearchresult
                        v-if="annotationresults != 'undefined' && annotationresults.length >= 1 && annotationindex >= ((currentAnnotationPage*annotationPerPage) - annotationPerPage) && annotationindex < (currentAnnotationPage*annotationPerPage)"
                        v-for="(annotationresult, annotationindex) in annotationresults"
                        v-bind:annotationresult="annotationresult"
                        :key="guid(annotationindex)"
                        ></annotationsearchresult>
                <pagination
                        v-if="annotationresults != 'undefined' && annotationresults.length >= 1 && annotationresults.length >= annotationPerPage"
                        :totalPages="(annotationresults.length / annotationPerPage)"
                        :total="annotationresults.length"
                        :currentPage="currentAnnotationPage"
                        :perPage="annotationPerPage"
                        :headerType="'annotation'"
                        v-on:annotation_pagechanged="annotationCurrentPageChange"
                        v-on:annotation_resultsperpage="annotationPerPageChange"
                ></pagination>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapState, mapActions, mapGetters } from 'vuex'
    export default {
        props: ['corpusresults', 'documentresults', 'annotationresults', 'datasearched','dataloading', 'searches','corpusresultcounter','documentresultcounter','annotationresultcounter'],
        data: function (){
            return{
                currentCorpusPage: 1,
                currentDocumentPage: 1,
                currentAnnotationPage: 1,
                corpusPerPage: 5,
                documentPerPage: 5,
                annotationPerPage: 5,
            }
        },
        methods: {
            guid: function(key) {
                return key + ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, c =>
                    (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16))
            },
            corpusCurrentPageChange: function(page) {
                this.currentCorpusPage = page;
            },
            documentCurrentPageChange: function(page) {
                this.currentDocumentPage = page;
            },
            annotationCurrentPageChange: function(page) {
                this.currentAnnotationPage = page;
            },
            corpusPerPageChange: function(perpage) {
                this.corpusPerPage = perpage;
            },
            documentPerPageChange: function(perpage) {
                this.documentPerPage = perpage;
            },
            annotationPerPageChange: function(perpage) {
                this.annotationPerPage = perpage;
            }
        },
        computed:
            mapGetters({
                stateDocumentCorpusresults: 'documentcorpus',
                stateAnnotationCorpusresults: 'annotationcorpus'
            }),
        mounted() {
            console.log('CorpusResultComponent mounted.')
            if(!this.datasearched && !this.dataloading && this.searches.length == 0) {
                this.$emit('initial-search');
            }

        }
    }
</script>