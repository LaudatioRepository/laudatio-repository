<template>
        <div class="container bg-corpus-superlight mt-1 mb-1 p-5" v-if="corpusresult._source.visibility == 1">
            <div class="row">
                <div class="col-2" v-if="corpusresult._source.corpuslogo == null">
                    <img class="w-100" src="/images/placeholder_circle.svg" alt="circle-image">
                </div>
                <div class="col-2" v-else>
                    <img  class="rounded-circle bg-white w-100" v-bind:src="('/images/corpuslogos/').concat(corpusresult._source.projectpath).concat('_').concat(corpusresult._source.corpuspath).concat('_').concat(corpusresult._source.corpuslogo)" alt="corpus-logo">
                </div>
                <div class="col">
                    <h4 class="h4 font-weight-bold">
                        <a class="text-dark" v-bind:href="browseUri(corpusresult._id)" v-if="corpushighlights.hasOwnProperty(corpusresult._id) && corpushighlights[corpusresult._id][0].hasOwnProperty('corpus_title')" v-html="corpushighlights[corpusresult._id][0].corpus_title">
                        </a>
                        <a class="text-dark" v-bind:href="browseUri(corpusresult._id)" v-else-if="filteredcorpushighlightmap.hasOwnProperty(corpusresult._id) && filteredcorpushighlightmap[corpusresult._id].hasOwnProperty('corpus_title')" v-html="filteredcorpushighlightmap[corpusresult._id].corpus_title">
                        </a>
                        <a class="text-dark" v-bind:href="browseUri(corpusresult._id)" v-else>
                            {{ corpusresult._source.corpus_title | arrayToString }}
                        </a>
                    </h4>
                    <span class="text-grey text-14" v-if="corpusresult._source.corpus_editor_forename != 'undefined' && corpusresult._source.corpus_editor_surname != 'undefined'">{{corpusAuthors(corpusresult._source.corpus_editor_forename,corpusresult._source.corpus_editor_surname)}}</span>
                    <div class="row mt-1 ">
                        <div class="col col-auto mr-1">
                            <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                <i class="fa fa-fw fa-globe mr-1"></i>
                                <span v-if="corpushighlights.hasOwnProperty(corpusresult._id) && corpushighlights[corpusresult._id][0].hasOwnProperty('corpus_publication_publisher')" v-html="corpushighlights[corpusresult._id][0].corpus_publication_publisher"></span>
                                <span v-else-if="filteredcorpushighlightmap.hasOwnProperty(corpusresult._id) && filteredcorpushighlightmap[corpusresult._id].hasOwnProperty('corpus_publication_publisher')" v-html="filteredcorpushighlightmap[corpusresult._id].corpus_publication_publisher"></span>
                                <span v-else>
                                    {{corpusresult._source.corpus_publication_publisher | arrayToString}}
                                </span>
                            </div>
                        </div>
                        <div class="col col-auto mr-1">
                            <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                <i class="fas fa-file-signature mr-1"></i>
                                <span v-if="corpushighlights.hasOwnProperty(corpusresult._id) && corpushighlights[corpusresult._id][0].hasOwnProperty('corpus_merged_formats')" v-html="corpushighlights[corpusresult._id][0].corpus_merged_formats"></span>
                                <span v-else-if="filteredcorpushighlightmap.hasOwnProperty(corpusresult._id) && filteredcorpushighlightmap[corpusresult._id].hasOwnProperty('corpus_merged_formats')" v-html="filteredcorpushighlightmap[corpusresult._id].corpus_merged_formats"></span>
                                <span v-else>
                                    {{corpusresult._source.corpus_merged_formats | truncatelist}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1 ">
                        <div class="col col-auto mr-1">
                            <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                                <i class="fa fa-fw fa-clock-o mr-1"></i>
                                <span v-if="corpushighlights.hasOwnProperty(corpusresult._id) && corpushighlights[corpusresult._id][0].hasOwnProperty('documentrange')">D. from <span v-html="corpushighlights[corpusresult._id][0].documentrange"></span></span>
                                <span v-else>D. from {{corpusresult._source.documentrange}}</span>
                            </div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                            <i class="fa fa-fw fa-th-list  mr-1"></i>
                            <span v-if="corpushighlights.hasOwnProperty(corpusresult._id) && corpushighlights[corpusresult._id][0].hasOwnProperty('corpus_document_genre')" v-html="corpushighlights[corpusresult._id][0].corpus_document_genre"></span>
                            <span v-else>{{corpusresult._source.corpus_document_genre[0]}}</span>
                        </div>
                            <div class="mt-2">
                                <a class="text-dark text-uppercase search-description-expander" data-toggle="collapse" v-bind:href="('#corpusSearchItem_').concat(corpusresult._id)"
                                   role="button" aria-expanded="false" v-bind:aria-controls="('#corpusSearchItem_').concat(corpusresult._id)">
                                    <i class="fa fa-angle-down fa-fw text-primary font-weight-bold"></i>
                                    Description
                                </a>
                            </div>
                        </div>
                        <div class="col col-auto mr-1">
                            <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap" v-if="corpusresult._source.corpus_merged_languages != 'undefined'">
                                <i class="fa fa-fw fa-globe mr-1"></i>
                                <span v-if="corpushighlights.hasOwnProperty(corpusresult._id) && corpushighlights[corpusresult._id][0].hasOwnProperty('corpus_merged_languages')" v-html="corpushighlights[corpusresult._id][0].corpus_merged_languages"></span>
                                <span v-else-if="filteredcorpushighlightmap.hasOwnProperty(corpusresult._id) && filteredcorpushighlightmap[corpusresult._id].hasOwnProperty('corpus_merged_languages')" v-html="filteredcorpushighlightmap[corpusresult._id].corpus_merged_languages"></span>
                                <span v-else>{{corpusresult._source.corpus_merged_languages | truncatelist}}</span>
                            </div>
                            <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                            <i class="fa fa-fw fa-cubes mr-1"></i>
                            <span>{{corpusresult._source.corpus_size_value | arrayToString}} {{corpusresult._source.corpus_size_type | arrayToString}}</span>
                        </div>
                            <div class="mt-2"> <a href="#" class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                <i class="fa fa-text-height fa-fw fa-file-text-o align-baseline fa-lg text-wine"></i>
                                <span class="text-primary text-14 font-weight-bold" v-if="typeof corpusresult._source.corpus_documents != 'undefined'">{{corpusresult._source.corpus_documents.length}}</span>
                            </a>
                            </div>
                        </div>
                        <div class="col col-auto mr-1">
                            <div class="d-flex justify-content-start align-items-center" v-if="corpusresult._source.corpus_publication_license != 'undefined'" v-for="(licenseObject) in getLicenseMarkup(corpusresult._source.corpus_publication_license[0])">
                                <img class="py-1" v-bind:src="(licenseObject.uri)" v-bind:alt="('license').concat(licenseObject.altText)">
                            </div>
                            <div class="corpusProp smaller text-14 d-flex align-items-center align-self-start my-1 flex-nowrap" v-if="corpusresult._source.corpus_publication_publication_date != 'undefined'">
                                <i class="fa fa-fw fa-arrow-up mr-1 border-top border-dark"></i>
                                <span>{{corpusresult._source.corpus_publication_publication_date | lastElement}}</span>
                            </div>
                            <div class="mt-2"> <a href="# " class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1" v-if="typeof corpusresult._source.annotation_id != 'undefined'">
                                <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                                <span class="text-14 font-weight-bold">{{corpusresult._source.annotation_id.length}}</span>
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
                            <a class="dropdown-item text-14" v-bind:href="('/download/tei/').concat(corpusresult._source.projectpath).concat('/').concat(corpusresult._source.corpuspath)">TEI-Header</a>
                            <!--a class="dropdown-item text-14" href="#">EXCEL</a>
                            <a class="dropdown-item text-14" href="#">PAULA</a>
                            <a class="dropdown-item text-14" href="#">ANNIS</a-->
                        </div>
                    </div>
                    <!--div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" v-bind:id="('filtercheck-corpusSearchItem').concat(corpusresult._id)">
                        <label class="custom-control-label text-14" v-bind:for="('filtercheck-corpusSearchItem').concat(corpusresult._id)">
                            Set as Filter
                        </label>
                    </div-->
                </div>
            </div>
            <div class="row">
                <div class="col-2"></div>
                <div class="col">
                    <div v-bind:id="('corpusSearchItem_').concat(corpusresult._id)" class="collapse row pl-0 pr-3 pb-0">
                        <hr />
                        <p v-if="corpushighlights.hasOwnProperty(corpusresult._id) && corpushighlights[corpusresult._id][0].hasOwnProperty('corpus_encoding_project_description')" v-html="corpushighlights[corpusresult._id][0].corpus_encoding_project_description"></p>
                        <p v-else>
                            {{corpusresult._source.corpus_encoding_project_description | lastElement}}
                        </p>
                        <a v-bind:href="browseUri(corpusresult._id)">MORE</a>
                    </div>
                </div>
            </div>
        </div>
</template>
<script>
    import { mapState, mapActions } from 'vuex'
    export default {
        props: ['corpusresult','corpushighlights','filteredcorpushighlightmap','corpuspaths'],
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
        }
    }
</script>