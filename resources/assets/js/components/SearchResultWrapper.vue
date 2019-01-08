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
                    v-if="corpusresults != 'undefined' && visibleCorpora.length >= 1 && index >= ((currentCorpusPage*corpusPerPage) - corpusPerPage) && index < (currentCorpusPage*corpusPerPage)"
                    v-for="(corpusresult, index) in visibleCorpora"
                    v-bind:corpusresult="corpusresult"
                    :key="guid(index)"
                    :corpushighlights="corpushighlights"
                    :filteredcorpushighlightmap="filteredcorpushighlightmap"
                    ></corpussearchresult>
                <pagination
                        v-if="corpusresults != 'undefined' && visibleCorpora.length >= 1 && visibleCorpora.length >= corpusPerPage"
                        :totalPages="Math.ceil((visibleCorpora.length / corpusPerPage))"
                        :total="visibleCorpora.length"
                        :currentPage="currentCorpusPage"
                        :perPage="corpusPerPage"
                        :headerType="'corpus'"
                        v-on:corpus_pagechanged="corpusCurrentPageChange"
                        v-on:corpus_resultsperpage="corpusPerPageChange"
                ></pagination>
            </div>
            <div class="tab-pane" id="searchtab-documents" role="tabpanel" aria-labelledby="searchtab-documents">
                <documentsearchresult
                        v-if="documentresults != 'undefined' && visibleDocuments.length >= 1 && documentindex >= ((currentDocumentPage*documentPerPage) - documentPerPage) && documentindex < (currentDocumentPage*documentPerPage)"
                        v-for="(documentresult, documentindex) in visibleDocuments"
                        v-bind:documentresult="documentresult"
                        :key="guid(documentindex)"
                        :documenthighlights="documenthighlights"
                        :filtereddocumenthighlightmap="filtereddocumenthighlightmap"
                        ></documentsearchresult>
                <pagination
                        v-if="documentresults != 'undefined' && visibleDocuments.length >= 1 && visibleDocuments.length >= documentPerPage"
                        :totalPages="Math.ceil((visibleDocuments.length / documentPerPage))"
                        :total="visibleDocuments.length"
                        :currentPage="currentDocumentPage"
                        :perPage="documentPerPage"
                        :headerType="'document'"
                        v-on:document_pagechanged="documentCurrentPageChange"
                        v-on:document_resultsperpage="documentPerPageChange"
                ></pagination>
            </div>

            <div class="tab-pane" id="searchtab-annotations" role="tabpanel" aria-labelledby="searchtab-annotations">
                <annotationsearchresult
                        v-if="annotationresults != 'undefined' && visibleAnnotations.length >= 1 && annotationindex >= ((currentAnnotationPage*annotationPerPage) - annotationPerPage) && annotationindex < (currentAnnotationPage*annotationPerPage)"
                        v-for="(annotationresult, annotationindex) in visibleAnnotations"
                        v-bind:annotationresult="annotationresult"
                        :key="guid(annotationindex)"
                        :annotationhighlights="annotationhighlights"
                        :filteredannotationhighlightmap="filteredannotationhighlightmap"
                        ></annotationsearchresult>
                <pagination
                        v-if="annotationresults != 'undefined' && visibleAnnotations.length >= 1"
                        :totalPages="Math.ceil((visibleAnnotations.length / annotationPerPage))"
                        :total="visibleAnnotations.length"
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
    export default {
        props: ['corpusresults', 'corpushighlights', 'filteredcorpushighlightmap', 'filtereddocumenthighlightmap','filteredannotationhighlightmap', 'documentresults','documenthighlights', 'annotationresults', 'annotationhighlights', 'datasearched','dataloading', 'searches','corpusresultcounter','documentresultcounter','annotationresultcounter','frontpageresultdata'],
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
                this.currentCorpusPage = 1;
            },
            documentPerPageChange: function(perpage) {
                this.documentPerPage = perpage;
                this.currentDocumentPage = 1;
            },
            annotationPerPageChange: function(perpage) {
                this.annotationPerPage = perpage;
                this.currentAnnotationPage = 1;
            },
            setActiveTab: function(header, filters, filtersmap) {
                var corpuselem = document.getElementById( 'searchtab-corpora' );
                var corpustabelem = document.getElementById( 'tab-corpora' );
                var documentelem = document.getElementById( 'searchtab-documents' );
                var documenttabelem = document.getElementById( 'tab-documents' );
                var annotationelem = document.getElementById( 'searchtab-annotations' );
                var annotationtabelem = document.getElementById( 'tab-annotations' );

                var lastValue = filters[filters.length-1]
                var lastKey =  filtersmap[lastValue]

                if(lastKey.indexOf(header) > -1 || (header == 'annotation' && lastKey.indexOf('preparation') > -1)){
                    switch(header) {
                        case 'corpus':
                            corpuselem.classList.add('active'); // Add class
                            corpustabelem.classList.add('active');
                            if ( documentelem.classList.contains('active') ) { // Check for class
                                documentelem.classList.remove('active'); // Remove class
                                documenttabelem.classList.remove('active')
                            }
                            if ( annotationelem.classList.contains('active') ) { // Check for class
                                annotationelem.classList.remove('active'); // Remove class
                                annotationtabelem.classList.remove('active');
                            }
                            break;
                        case 'document':
                            documentelem.classList.add('active'); // Add class
                            documenttabelem.classList.add('active')
                            if ( corpuselem.classList.contains('active') ) { // Check for class
                                corpuselem.classList.remove('active'); // Remove class
                                corpustabelem.classList.remove('active');
                            }
                            if ( annotationelem.classList.contains('active') ) { // Check for class
                                annotationelem.classList.remove('active'); // Remove class
                                annotationtabelem.classList.remove('active');
                            }
                            break;
                        case 'annotation':
                            annotationelem.classList.add('active'); // Add class
                            annotationtabelem.classList.add('active');
                            if ( corpuselem.classList.contains('active') ) { // Check for class
                                corpuselem.classList.remove('active'); // Remove class
                                corpustabelem.classList.remove('active');
                            }
                            if ( documentelem.classList.contains('active') ) { // Check for class
                                documentelem.classList.remove('active'); // Remove class
                                documenttabelem.classList.remove('active')
                            }
                            break;
                    }
                }

            }
        },
        computed: {
            visibleCorpora(){
                var visibleCorpora = []
                for(var i = 0; i < this.corpusresults.length; i++) {
                    if(this.corpusresults[i]._source.visibility == 1) {
                        visibleCorpora.push(this.corpusresults[i])
                    }
                }
                return visibleCorpora;
            },
            visibleDocuments(){
                var visibleDocuments = []
                for(var i = 0; i < this.documentresults.length; i++) {
                    if(this.documentresults[i]._source.visibility == 1) {
                        visibleDocuments.push(this.documentresults[i])
                    }
                }
                return visibleDocuments;
            },
            visibleAnnotations(){
                var visibleAnnotations = []
                for(var i = 0; i < this.annotationresults.length; i++) {
                    if(this.annotationresults[i]._source.visibility == 1) {
                        visibleAnnotations.push(this.annotationresults[i])
                    }
                }
                return visibleAnnotations;
            }
        },
        mounted() {
            //console.log('CorpusResultComponent mounted. datasearched: '+this.datasearched+" dataloading: "+this.dataloading+" THI SEARCHES: "+this.searches.length+" FRONTPAGEDATA: "+this.frontpageresultdata.results.length)
            if(!this.datasearched && !this.dataloading && this.searches.length == 0 && !this.frontpageresultdata) {
                this.$emit('initial-search');
            }
            else if(!this.datasearched && !this.dataloading && this.searches.length == 0 && this.frontpageresultdata){
                console.log("FEPP")
                console.log(this.frontpageresultdata)
                this.$emit('frontpage-search');
                this.$set(this.frontpageresultdata, undefined)
            }

        }
    }
</script>