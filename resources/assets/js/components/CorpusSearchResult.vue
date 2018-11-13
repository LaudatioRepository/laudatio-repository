<template>
    <div class="tab-pane active" id="searchtab-corpora" role="tabpanel" aria-labelledby="searchtab-corpora">
        <div class="container bg-corpus-superlight mt-1 mb-1 p-5" v-if="corpusresult.results.length > 0" v-for="(corpusresultdata, index) in corpusresult.results" v-bind:key="corpusresultdata._source.corpus_id[0]">
            <div class="row">
                <div class="col-2 px-2">
                    <img class="w-100" src="/images/placeholder_circle.svg" alt="circle-image">
                </div>
                <div class="col">
                    <h4 class="h4 font-weight-bold">
                        <a class="text-dark" v-bind:href="browseUri(corpusresultdata._id)">
                            {{ corpusresultdata._source.corpus_title | arrayToString }}
                        </a>
                    </h4>
                    <span class="text-grey text-14" v-if="corpusresultdata._source.corpus_editor_forename != 'undefined' && corpusresultdata._source.corpus_editor_surname != 'undefined'">{{corpusAuthors(corpusresultdata._source.corpus_editor_forename,corpusresultdata._source.corpus_editor_surname)}}</span>
                    <div class="row mt-1 ">
                        <div class="col col-auto mr-1">
                            <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                <i class="fa fa-fw fa-clock-o mr-1"></i>
                                <span>D. from {{corpusresultdata._source.documentrange}}</span>
                            </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                            <i class="fa fa-fw fa-th-list  mr-1"></i>
                            <span>{{corpusresultdata._source.documentgenre}}</span>
                        </div>
                            <div class="mt-2">
                                <a class="text-dark text-uppercase search-description-expander" data-toggle="collapse" v-bind:href="('#corpusSearchItem_').concat(index)"
                                   role="button" aria-expanded="false" v-bind:aria-controls="('#corpusSearchItem_').concat(index)">
                                    <i class="fa fa-angle-down fa-fw text-primary font-weight-bold"></i>
                                    Description
                                </a>
                            </div>
                        </div>
                        <div class="col col-auto mr-1">
                            <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap" v-if="corpusresultdata._source.corpus_languages_language != 'undefined'">
                                <i class="fa fa-fw fa-globe mr-1"></i>
                                <span>{{corpusresultdata._source.corpus_languages_language[0] | truncatelist}}</span>
                            </div>
                            <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                            <i class="fa fa-fw fa-cubes mr-1"></i>
                            <span>{{corpusresultdata._source.corpus_size_value | arrayToString}} {{corpusresultdata._source.corpus_size_type | arrayToString}}</span>
                        </div>
                            <div class="mt-2"> <a href="#" class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                <i class="fa fa-text-height fa-fw fa-file-text-o align-baseline fa-lg text-wine"></i>
                                <span class="text-primary text-14 font-weight-bold" v-if="typeof corpusresultdata._source.corpus_documents != 'undefined'">{{corpusresultdata._source.corpus_documents.length}}</span>
                            </a>
                            </div>
                        </div>
                        <div class="col col-auto mr-1">
                            <div class="d-flex justify-content-start align-items-center" v-if="corpusresultdata._source.corpus_publication_license != 'undefined'" v-for="(licenseObject) in getLicenseMarkup(corpusresultdata._source.corpus_publication_license[0])">
                                <img class="py-1" v-bind:src="(licenseObject.uri)" v-bind:alt="('license').concat(licenseObject.altText)">
                            </div>
                            <div class="corpusProp smaller text-14 d-flex align-items-center align-self-start my-1 flex-nowrap" v-if="corpusresultdata._source.corpus_publication_publication_date != 'undefined'">
                                <i class="fa fa-fw fa-arrow-up mr-1 border-top border-dark"></i>
                                <span>{{corpusresultdata._source.corpus_publication_publication_date | lastElement}}</span>
                            </div>
                            <div class="mt-2"> <a href="# " class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1" v-if="typeof corpusresultdata._source.annotation_id != 'undefined'">
                                <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                                <span class="text-14 font-weight-bold">{{corpusresultdata._source.annotation_id.length}}</span>
                            </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2 mr-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-corpus-dark dropdown-toggle font-weight-bold text-uppercase rounded mb-4"
                                type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Download
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item text-14" v-bind:href="('/download/tei/').concat(corpusresultdata._source.corpuspath)">TEI-Header</a>
                            <!--a class="dropdown-item text-14" href="#">EXCEL</a>
                            <a class="dropdown-item text-14" href="#">PAULA</a>
                            <a class="dropdown-item text-14" href="#">ANNIS</a-->
                        </div>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" v-bind:id="('filtercheck-corpusSearchItem').concat(index)">
                        <label class="custom-control-label text-14" v-bind:for="('filtercheck-corpusSearchItem').concat(index)">
                            Set as Filter
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-2"></div>
                <div class="col">
                    <div v-bind:id="('corpusSearchItem_').concat(index)" class="collapse row pl-0 pr-3 pb-0">
                        <hr />
                        <p>
                            {{corpusresultdata._source.corpus_encoding_project_description | lastElement}}
                            <a href="#">MORE</a>
                        </p>
                    </div>
                </div>
            </div>

        </div>
        <div class="container d-flex flex-column align-items-center justify-content-center mb-5 mt-5">
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
    import { mapState, mapActions } from 'vuex'
    export default {
        props: ['corpusresult','documentsbycorpus','annotationsbycorpus','corpuspaths'],
        methods: {
            browseUri: function(id) {
                return '/browse/corpus/'.concat(id);
            },
            corpusAuthors: function(forenames, surnames){
                var authorString = "";
                for(var i=0; i < forenames.length;i++) {
                    authorString += forenames[i]
                        .concat(' ')
                        .concat(surnames[i])
                        .concat(', ');
                }
                authorString = authorString.substring(0,authorString.lastIndexOf(","));
                return authorString;
            },
            getLicenseMarkup: function(licenseUri) {
                var uriSplits = licenseUri.split("/");
                var license = uriSplits[4];
                var licenseSplits = license.split("-");
                var licenses = [];

                for(var i=0; i < licenseSplits.length; i++) {
                    var license = {};
                    license.uri = '/images/license-'+licenseSplits[i]+'.svg';
                    license.altText = licenseSplits[i]
                    licenses.push(license)
                }
                return licenses;
            },
            emitCorpusRelations: function(corpusId){
                this.$store.dispatch('clearDocuments',[])
                this.$store.dispatch('clearAnnotations',[])
                this.$store.dispatch('documentByCorpus',this.documentsbycorpus[corpusId])
                this.$store.dispatch('annotationByCorpus',this.annotationsbycorpus[corpusId])
            }
        },
        mounted() {
            console.log('CorpusResultComponent mounted.')
        }
    }
</script>