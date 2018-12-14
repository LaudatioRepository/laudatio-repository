<template>
    <div class="card">
        <div class="card-header btn bg-corpus-mid font-weight-bold text-uppercase d-flex justify-content-between align-items-center"
             data-toggle="collapse" data-target="#formPanelDocuments" aria-expanded="true" aria-controls="formPanelDocuments">
            <span>Documents</span>
            <i class="collapse-indicator fa fa-chevron-circle-down fa-fw fa-lg text-16"></i>
        </div>
        <div v-bind:class="getClass()" id="formPanelDocuments">
            <div class="card-body px-2">
                <!--form action=""-->
                    <div class="form-group mb-3">
                        <label class="mb-0 text-14 " for="formDocumentsTitle">Title</label>
                        <input type="text" class="form-control" id="formDocumentsTitle" aria-describedby="inputTitle" placeholder='"Document title"'  v-model="documentFilterData.document_title" @keyup.enter="emitApplyFilters">
                    </div>

                    <div class="form-group mb-3">
                        <label class="mb-0 text-14 " for="formDocumentsAuthor">Author</label>
                        <input type="text" class="form-control" id="formDocumentsAuthor" aria-describedby="inputAuthor" placeholder='"Frank Mann"'  v-model="documentFilterData.document_merged_authors"  @keyup.enter="emitApplyFilters">
                    </div>



                    <div class="d-flex flex-column">
                        <a class="align-self-end text-uppercase text-dark text-14 filter-expander" data-toggle="collapse" href="#"
                           data-target=".formPanelDocuments-all" role="button" aria-expanded="false" aria-controls="#formPanelDocuments-all1 #formPanelDocuments-all2">
                            + Show all Documentsfilter
                        </a>
                    </div>

                    <div id="formPanelDocuments-all1" class="collapse formPanelDocuments-all">

                        <div class="form-group mb-3">
                            <label class="mb-0 text-14 " for="formDocumentsLanguage">Language</label>
                            <input type="text" class="form-control" id="formDocumentsLanguage" aria-describedby="inputLanguage" placeholder='"German"'  v-model="documentFilterData.document_languages_language" @keyup.enter="emitApplyFilters">
                        </div>

                        <div class="form-group mb-3">
                            <label class="mb-0 text-14 " for="formDocumentsPlace">Place</label>
                            <input type="text" class="form-control" id="formDocumentsPlace" aria-describedby="inputPlace" placeholder='"Mannheim"'  v-model="documentFilterData.document_publication_place" @keyup.enter="emitApplyFilters">
                        </div>

                    </div>
                <!--/form-->

                <div id="formPanelDocuments-all2" class="collapse formPanelDocuments-all">


                    <!--form action=""-->
                        <div class="form-group mb-3">
                            <label class="mb-2 text-14 " for="dd">Documents size (Tokens, Words)</label>
                            <div class="d-flex justify-content-between">
                                <div class="w-75">
                                    <div id="documentSize"></div>
                                    <div class="d-flex justify-content-between w-100 text-dark font-weight-bold text-14">
                                        <span id="documentSize-minVal">
                                        </span>
                                        <span id="documentSize-maxVal">
                                        </span>
                                    </div>
                                </div>
                                <!--button type="submit" class="disabled btn btn-sm btn-corpus-dark p-0">
                                    <i class="fa fa-angle-right fa-fw fa-2x py-1"></i>
                                </button-->
                            </div>
                        </div>
                    <!--/form-->

                    <!--form action=""-->
                        <div class="form-group mb-3">
                            <label class="mb-0 text-14 " for="formDocumentsYear">Year of Publication</label>
                            <div class="d-flex justify-content-between">
                                <div class="d-flex flex-column w-35">
                                    <small id="yearFromHelp" class="form-text text-muted">from</small>
                                    <input class="toBeValidated form-control" placeholder="J J J J" type="number" min="1" max="9999" step="1"
                                           name="yearFrom" id="formDocumentsYearFrom"  v-model="documentFilterData.document_publication_publishing_date"  />
                                </div>
                                <div class="d-flex flex-column w-35">
                                    <small id="yearToHelp" class="form-text text-muted">to</small>
                                    <input class="toBeValidated form-control" placeholder="J J J J" type="number" min="1" max="9999" step="1"
                                           name="yearTo" id="formDocumentsYearTo" v-model="documentFilterData.document_publication_publishing_date_to" />
                                </div>
                                <!--button type="submit" class="toCheckValidation disabled btn btn-sm btn-corpus-dark ml-3 p-0 align-self-end">
                                    <i class="fa fa-angle-right fa-fw fa-2x py-1"></i>
                                </button-->
                            </div>
                        </div>
                    <!--/form-->

                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapState, mapActions, mapGetters } from 'vuex'
    export default {
        props: ['corpusresults','documentresults','annotationresults'],
        data: function(){
            return {
                documentFilterData : {
                    document_title: '',
                    document_author_forename: '',
                    document_author_surname: '',
                    document_merged_authors: '',
                    document_publication_place: '',
                    document_publication_publishing_date: '',
                    document_publication_publishing_date_to: '',
                    document_size_extent: '',
                    document_size_extent_to: '',
                    document_languages_language: '',
                    document_merged_languages: ''
                },
                scope: 'document'
            }
        },
        computed:
            mapGetters({
                stateDocumentCorpusresults: 'documentcorpus',
                stateAnnotationCorpusresults: 'annotationcorpus'
            }),
        methods: {
            getClass: function () {
                var classes = "collapse";
                if(
                    this.corpusresults.length >= 1 ||
                    this.documentresults.length >= 1 ||
                    this.annotationresults.length >= 1
                ){
                    classes += " show"
                }
                return classes;
            },
            emitApplyFilters(){
                this.$emit('apply-filters');
            },
            emitDocumentFilter(){
                this.$emit('document-filter',this.documentFilterData);
            },
            emitDropDocumentFilter: function (field){
                this.$emit('remove-document-filter',field);
            },
            clearDocumentFilter: function () {
                this.documentFilterData = {
                    document_title: '',
                    document_author_forename: '',
                    document_author_surname: '',
                    document_merged_authors: '',
                    document_publication_place: '',
                    document_publication_publishing_date: '',
                    document_publication_publishing_date_to: '',
                    document_size_extent: '',
                    document_size_extent_to: '',
                    document_languages_language: '',
                    document_merged_languages: ''
                }
            },
            resetFilterField: function(field, filter) {
                if(field == 'document_publication_publishing_date'){
                    this.documentFilterData['document_publication_publishing_date'] = ''
                    this.documentFilterData['document_publication_publishing_date_to'] = ''
                }
                else if(field == 'document_size_extent'){
                    //this.documentFilterData['document_size_extent'] = ''
                    //this.documentFilterData['document_size_extent_to'] = ''

                }
                else{
                    this.documentFilterData[field] = ''
                }
            },
            resetNoUiSlider: function() {
                let documentel = document.getElementById('documentSize')

                if(documentel) {
                    documentel.noUiSlider.reset();
                }
            }
        },
        mounted() {

            let myvue = this;
            let el = document.getElementById('documentSize')
            var touched = false;

            if(el) {
                //console.log("el: "+el)
                el.style.height = '8px';
                el.style.margin = '0 auto 8px';

                noUiSlider.create(el, {
                    connect: true,
                    behaviour: 'tap-drag',
                    start: [1, 1000000],
                    range: {
                        // Starting at 500, step the value by 500,
                        // until 4000 is reached. From there, step by 1000.
                        'min': [1],
                        '10%': [100, 10],
                        '50%': [4000, 100],
                        'max': [999999]
                    }
                });


                let paddingMin = document.getElementById('documentSize' + '-minVal'),
                    paddingMax = document.getElementById('documentSize' + '-maxVal');

                el.noUiSlider.on('update', function ( values, handle ) {
                    if ( handle ) {

                            myvue.documentFilterData.document_size_extent_to = Math.round(values[handle]);
                            paddingMax.innerHTML = Math.round(values[handle]);

                    } else {
                            myvue.documentFilterData.document_size_extent = Math.round(values[handle]);
                            paddingMin.innerHTML = Math.round(values[handle]);

                    }

                    myvue.emitDropDocumentFilter('document_size_extent')
                    myvue.emitDocumentFilter();

                });



                el.noUiSlider.on('change', function(){
                    // Validate corresponding form
                    let parentForm = $(el).closest('form')
                    $(parentForm).find('*[type=submit]').removeClass('disabled');
                });
            }
        }
    }
</script>