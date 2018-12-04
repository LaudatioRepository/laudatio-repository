<template lang="html">
   <div class="container pt-5" v-if="header == 'document'">
    <div class="row">
      <div class="col-2" v-if="headerdata.corpus_logo == null">
            <img class="w-100" src="/images/placeholder_circle.svg" alt="circle-image">
        </div>
        <div class="col-2" v-else>
            <img class="rounded-circle bg-white w-100"  v-bind:src="('/images/corpuslogos/').concat(headerdata.project_directorypath).concat('_').concat(headerdata.corpus_directorypath).concat('_').concat(headerdata.corpus_logo)" alt="corpus-logo">
        </div>
      <div class="col pr-5">
        <h3 class="h3 font-weight-bold">
         {{ headerdata.document_title | arrayToString }}
        </h3>
        <p class="text-wine">
          Document in Corpus {{headerdata.documentCorpusdata.corpus_title | arrayToString}}
        </p>
        <p class="text-wine">
          {{headerdata.document_author_forename | arrayToString}} {{headerdata.document_author_surname | arrayToString}}
        </p>
        <div class="row mt-2"  v-if="typeof headerdata.document_publication_publishing_date != 'undefined'">
          <div class="col col-auto mr-2">
            <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
                <i class="fa fa-fw fa-clock-o mr-1"></i>
              <span>
                {{headerdata.document_publication_publishing_date | arrayToString}}
              </span>
            </div>
          </div>
          <div class="col col-auto mr-2" v-if="typeof headerdata.document_languages_language != 'undefined'">
            <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
              <i class="fa fa-fw fa-globe mr-1"></i>
              <span>
                {{concatLanguages}}
              </span>
            </div>
          </div>
          <div class="col col-auto mr-2" v-if="typeof headerdata.document_size_extent != 'undefined'">
            <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
              <i class="fa fa-fw fa-cubes mr-1"></i>
              <span>
                {{headerdata.document_size_extent | arrayToString}} Tokens
              </span>
            </div>
          </div>
          <div class="col col-auto mr-2" v-if="typeof headerdata.document_publication_place != 'undefined'">
            <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
              <i class="fa fa-fw fa-map-marker mr-1"></i>
              <span>
                {{headerdata.document_publication_place | arrayToString}}
              </span>
            </div>
          </div>
        </div>
        <div class="mt-3 mb-3 mr-5">
          <div class="text-wine text-14">
          <img class="pr-1" src="/images/logo-laudatio-mini.svg" alt="copyright-logo">
         <span> {{ corpusAuthors() }};
                    {{ headerdata.documentCorpusdata.corpus_title | arrayToString }};
                    {{ headerdata.documentCorpusdata.corpus_publication_publisher[0] }};</span>
          <b>Homepage: </b>
          <a v-bind:href="(headerdata.documentCorpusdata.corpus_encoding_project_homepage[0])">Link</a>
          <b>Corpus-Link: </b>
          <a href="http://handle.net/xxx">Link</a>
       </div>
        </div>
      </div>
      <div class="col-2">
        <div class="card text-white bg-transparent" v-if="isloggedin && workflowstatus == '0'">
              <h6 class="corpus-title h6 text-uppercase text-12 text-wine-trans">
                Corpus
              </h6>
              <div class="card-body d-flex flex-column">
                 <a v-bind:href="('/corpusprojects/corpora/').concat(corpusid).concat('/edit')" class=" btn btn-outline-corpus-dark font-weight-bold text-uppercase rounded small">
                  Edit
                </a>
                <button class=" btn btn-primary font-weight-bold text-uppercase rounded small mt-3" data-toggle="modal"
                  data-target="#publishCorpusModal">
                  Publish
                </button>
              </div>
         </div>

            <div class="card text-white bg-transparent" v-else-if="!isloggedin && workflowstatus == '1' || isloggedin && workflowstatus == '1'">
              <h6 class="corpus-title h6 text-uppercase text-12 text-wine">
                Corpus
              </h6>
              <div class="card-body d-flex flex-column">
                <div class="dropdown mb-3">
                  <button class=" w-100 btn btn-primary dropdown-toggle font-weight-bold text-uppercase rounded small"
                    type="button" id="corpusMainActions-Download" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Download
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item text-14"  v-bind:href="('/download/tei/').concat(corpuspath)" >TEI-Header</a>
                    <!--a class="dropdown-item text-14" href="#">EXCEL</a>
                    <a class="dropdown-item text-14" href="#">PAULA</a>
                    <a class="dropdown-item text-14" href="#">ANNIS</a-->
                  </div>
                </div>
                <button class=" btn btn-primary font-weight-bold text-uppercase rounded mb-3 small">
                  Open in Annis
                </button>
                <button id="citeButton" class="  w-100 btn btn-outline-corpus-dark font-weight-bold text-uppercase rounded mb-3" data-toggle="modal"
                  data-target="#citation-modal">
                  <img src="/images/logo-laudatio-mini.svg" alt="copyright-logo">
                   CITE
                </button>
                <div class="w-100 d-flex justify-content-start align-items-center" id="licenseContainer"></div>
              </div>
            </div>
      </div>
    </div>
    <div class="row mt-5">
      <nav class="navbar navbar-expand-sm navbar-light bg-transparent p-0 container" role="tablist">

          <div class="navbar-nav nav row w-100 px-5">
               <div class="nav-item maintablink col-auto text-center text-14 font-weight-bold active">
                    <a class="nav-link maintablink text-dark text-uppercase " data-toggle="tab" href="#documentMetadataBody" role="tab"> Document Metadata
                        <div class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                            <i class="fa fa-comment-o fa-fw fa-edit align-text-top fa-lg text-wine"></i>
                            <span class="text-primary text-14 font-weight-bold">{{headerdata.corpusdocumentcount}}</span>
                        </div>
                    </a>
               </div>


               <div class="nav-item maintablink col-auto text-center text-14 font-weight-bold ">
                    <a class="nav-link maintablink text-dark text-uppercase " data-toggle="tab" href="#annotationMetadataBody" role="tab"> Annotations
                        <div class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                            <i class="fa fa-comment-o fa-fw fa-edit align-text-top fa-lg text-wine"></i>
                            <span class="text-primary text-14 font-weight-bold">{{headerdata.documentannotationcount}}</span>
                        </div>
                    </a>
               </div>
          </div>

       </nav>
     </div>
    <div class="modal fade in" id="citation-modal" tabindex="-1" role="dialog" aria-labelledby="citation-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-corpus-mid">
                    <div class="h4 modal-title" id="citation-modal-title">
                        {{headerdata.documentCorpusdata.corpus_title | arrayToString}}, Version {{ headerdata.corpus_version | arrayToString }}
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                     </button>
                </div>
                <div class="modal-body">
                 <div class="alert alert-dismissible fade show" role="alert" id="alert-laudatio">
                    <span class="alert-laudatio-message"></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="fa fa-close" aria-hidden="true"></i>
                    </button>
                  </div>
                    <nav class="navbar navbar-expand-sm navbar-light bg-transparent p-0 container" role="tablist" id="citationtabs">
                        <div class="navbar-nav nav row w-100 px-5" data-cite-format="apa">
                            <div class="nav-item maintablink col-2 text-center text-14 font-weight-bold active">
                                <a class=" nav-link maintablink text-dark text-uppercase " data-toggle="tab" role="tab" data-cite-format="apa">
                                    APA
                                </a>
                            </div>

                             <div class="nav-item maintablink col-2 text-center text-14 font-weight-bold">
                                    <a class=" nav-link maintablink text-dark text-uppercase " data-toggle="tab" role="tab" data-cite-format="chicago">
                                        Chicago
                                    </a>
                                </div>

                                <div class="nav-item maintablink col-2 text-center text-14 font-weight-bold">
                                    <a class=" nav-link maintablink text-dark text-uppercase " data-toggle="tab" role="tab" data-cite-format="harvard">
                                        Harvard
                                    </a>
                                </div>

                             <div class="nav-item maintablink col-auto text-center text-14 font-weight-bold">
                                <a class="nav-link maintablink text-dark text-uppercase " data-toggle="tab" data-cite-format="bibtex" role="tab">BibTeX
                                </a>
                            </div>


                            <div class="nav-item maintablink col-auto text-center text-14 font-weight-bold">
                                <a class="nav-link maintablink text-dark text-uppercase " data-cite-format="txt" data-toggle="tab" role="tab">Plain text
                                </a>
                            </div>
                        </div>
                    </nav>
                    <div id="citation-text" class="bg-corpus-light bsh-1">
                    </div>
                    <div class="pull-right">
                        <button class="btn btn-fill btn-sm btn-neutral" data-clipboard-target="#citation-text" id="clipboard-btn"  title="Copy to Clipboard">Copy to Clipboard</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
    export default {
        props: ['headerdata','header','citedata','user','isloggedin','corpuselasticsearchid','corpusid','corpuspath','workflowstatus','ccbaseuri'],
        computed: {
            concatLanguages: function(){
                return this.headerdata.document_languages_language.join();
            }
        },
        methods: {
            facsimileUri: function(id) {
                return this.headerdata.document_history_faximile_link
            },

            corpusAuthors: function(){
                var authorString = "";
                for(var i=0; i < this.headerdata.documentCorpusdata.corpus_editor_forename.length;i++) {
                    authorString += this.headerdata.documentCorpusdata.corpus_editor_forename[i]
                        .concat(' ')
                        .concat(this.headerdata.documentCorpusdata.corpus_editor_surname[i])
                        .concat(',');
                }
                authorString = authorString.substring(0,authorString.lastIndexOf(","));
                return authorString;
            }

        },
        mounted() {
            console.log('DocumentMetadataBlockHeader mounted.')
        }
    }
</script>