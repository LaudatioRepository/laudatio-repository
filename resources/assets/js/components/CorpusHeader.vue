<template lang="html">
    <div class="container pt-5"  v-if="header == 'corpus'">
        <div class="row">
        <div class="col-2">
          <img class="w-100" src="/images/placeholder_circle.svg" alt="circle-image">
        </div>
        <div class="col pr-5">
          <h3 class="h3 font-weight-bold">
           {{ headerdata.corpus_title | arrayToString }}
          </h3>
          <p class="text-wine text-14">
            {{corpusAuthors()}}
          </p>
          <div class="row mt-2">
            <div class="col col-auto mr-2">
              <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
              <i class="fa fa-fw fa-clock-o mr-1"></i>
              <span v-if="headerdata.document_range.indexOf('-') > -1 ">
                D. from {{headerdata.document_range}}
              </span>
              <span v-else>
                D. {{headerdata.document_range}}
              </span>
            </div>
            <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
              <i class="fa fa-fw fa-th-list  mr-1"></i>
              <span>
                {{headerdata.document_genre}}
              </span>
            </div>
            </div>
            <div class="col col-auto mr-2">
             <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
              <i class="fa fa-fw fa-globe mr-1"></i> <span>{{headerdata.corpus_languages_language[0]}}</span>
              </div>
             <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
              <i class="fa fa-fw fa-cubes mr-1"></i>
              <span>
                {{headerdata.corpus_size_value | arrayToString}} Tokens
              </span>
            </div>
            </div>
            <div class="col col-auto mr-2 align-self-end">
              <div class="corpusProp smaller text-14 d-flex align-items-center align-self-start my-1 pl-2 flex-nowrap">
                <i class="fa fa-fw fa-arrow-up mr-1 border-top border-dark"></i>
                <span>
                  Working Version ({{headerdata.corpus_publication_publication_date | lastElement}})
                </span>
              </div>
            </div>
          </div>
          <div class="mt-3 mb-3 mr-5">
            <div class="text-wine text-14">
              <img class="pr-1" src="/images/logo-laudatio-mini.svg" alt="copyright-logo">
              <span>{{ corpusAuthors() }};
                                {{ headerdata.corpus_title | arrayToString }};
                                 {{ headerdata.corpus_publication_publisher | arrayToString }};</span>
              <b>Homepage: </b>
              <a v-bind:href="headerdata.corpus_encoding_project_homepage[0]">Link</a>
              <b>Corpus-Link: </b>
              <a href="http://handle.net/xxx">Link</a>
            </div>
          </div>
        </div>
        <div class="col-2">
          <div class="card text-white bg-transparent" v-if="isloggedin">
              <h6 class="corpus-title h6 text-uppercase text-12 text-wine-trans">
                Corpus
              </h6>
              <div class="card-body d-flex flex-column">
                <a v-bind:href="('/corpusprojects/corpora/').concat(corpusid).concat('/edit')" class=" btn btn-outline-corpus-dark font-weight-bold text-uppercase rounded small">
                  Edit
                </a>
                <button id="publishCorpusButton" class=" btn btn-primary font-weight-bold text-uppercase rounded small mt-3" data-toggle="modal"
                  data-target="#publishCorpusModal">
                  Publish
                </button>
              </div>
            </div>

            <div class="card text-white bg-transparent" v-else-if="! isloggedin">
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
                <!--button class=" btn btn-primary font-weight-bold text-uppercase rounded mb-3 small">
                  Open in Annis
                </button-->

                 <div class="dropdown">
                  <button class="w-100 btn btn-primary dropdown-toggle font-weight-bold text-uppercase rounded small"
                    type="button" id="corpusMainActions-Choice" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    OPEN IN
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item text-14" href="#">ANNIS</a>
                    <!--a class="dropdown-item text-14" href="#">DARIA</a>
                    <a class="dropdown-item text-14" href="#">CLARIN</a-->
                  </div>
                </div>
                <br />
                <button id="citeButton" class="  w-100 btn btn-outline-corpus-dark font-weight-bold text-uppercase rounded mb-3" data-toggle="modal"
                  data-target="#citation-modal">
                  <img src="/images/logo-laudatio-mini.svg" alt="copyright-logo">
                   CITE
                </button>
                <div class="w-100 d-flex justify-content-start align-items-center">
                  <img class="py-1" src="/images/license-cc.svg" alt="license cc" /> <img class="py-1" src="/images/license-sa.svg" alt="license sa" /> <img class="py-1" src="/images/license-by.svg" alt="license by" /> <img class="py-1" src="/images/license-nd.svg" alt="license nd" /> <img class="py-1" src="/images/license-nc.svg" alt="license nc" />
                </div>
              </div>
            </div>

        </div>
      </div>
        <div class="row mt-5">

            <nav class="navbar navbar-expand-sm navbar-light bg-transparent p-0 container" role="tablist">

                <div class="navbar-nav nav row w-100 px-5">
                    <div class="nav-item maintablink col-2 text-center text-14 font-weight-bold active">
                        <a class=" nav-link maintablink text-dark text-uppercase " data-toggle="tab" href="#corpusMetadataBody" role="tab">
                            CORPUS
                        </a>
                    </div>


                     <div class="nav-item maintablink col-auto text-center text-14 font-weight-bold ">
                        <a class="nav-link maintablink text-dark text-uppercase " data-toggle="tab" href="#documentMetadataBody" role="tab">Documents
                            <div class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                <i class="fa fa-comment-o fa-fw fa-edit align-text-top fa-lg text-wine"></i>
                                <span class="text-primary text-14 font-weight-bold">{{headerdata.corpusdocumentcount}}</span>
                            </div>
                        </a>
                    </div>


                    <div class="nav-item maintablink col-auto text-center text-14 font-weight-bold ">
                        <a class="nav-link maintablink text-dark text-uppercase " data-toggle="tab" href="#annotationMetadataBody" role="tab">Annotations
                            <div class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                                <span class="text-primary text-14 font-weight-bold">{{headerdata.corpusannotationcount}}</span>
                            </div>
                        </a>
                    </div>
                </div>
            </nav>

        </div>

        <div class="modal fade" id="publishCorpusModal" tabindex="-1" role="dialog" aria-labelledby="publishCorpusModal"
          aria-hidden="true">
          <div class="modal-dialog " role="document">
            <div class="modal-content border-0 rounded-lg bsh-1">

              <div class="modal-body px-5">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="fa fa-close" aria-hidden="true"></i>
                </button>
                <h3 class="h3 modal-title mt-3 w-75">
                  Publish „RIDGES Herbology, Version 9.0“
                </h3>

                <p class="mt-3 mb-1">
                  Following criteria needs to be fulfilled before you can publish a corpus: A verification is ongoing ...
                </p>

                <ul class="list-group list-group-flush mb-3 mt-3">
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <b>1 Corpus Header uploaded</b>
                    <span class="text-grey text-14">verifying</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <b>According number of Document Header</b>
                    <i class="fa fa-check-circle fa-fw fa-lg text-success"></i>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column">
                      <b>According number of Annotation Header</b>
                      <small class="text-primary">missing Annotation Header</small>
                    </div>
                    <i class="fa fa-exclamation-triangle fa-fw fa-lg text-danger"></i>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column">
                      <b>at least 1 Corpus Data Format</b>
                      <small class="text-primary">missing Corpus Data Format</small>
                    </div>
                    <i class="fa fa-exclamation-triangle fa-fw fa-lg text-danger"></i>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <b>Defined License</b>
                    <span>...</span>
                  </li>
                </ul>

              </div>
              <div class="modal-footer bg-corpus-light px-4 rounded-lg-bt">
                <button class="btn btn-outline-corpus-dark font-weight-bold text-uppercase rounded px-5" data-dismiss="modal"
                  aria-label="Close">
                  Cancel
                </button>
                <button class="disabled btn btn-primary font-weight-bold text-uppercase rounded px-5" data-dismiss="modal"
                  data-toggle="modal" data-target="#publishSuccessCorpusModal">
                  Publish
                </button>
              </div>
            </div>
          </div>
       </div>
        <div class="modal fade in" id="citation-modal" tabindex="-1" role="dialog" aria-labelledby="citation-modal-title" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header bg-corpus-mid">
					    <div class="h4 modal-title" id="citation-modal-title">
                            {{ headerdata.corpus_title | arrayToString }}
						</div>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <i class="fa fa-close" aria-hidden="true"></i>
                         </button>
					</div>
					<div class="modal-body">
                        <div class="alert alert-dismissible fade show" role="alert" id="alert-laudatio">
                            <span class="alert-laudatio-message"></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
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
							<button class="btn btn-fill btn-sm btn-neutral" data-clipboard-target="#citation-text" id="clipboard-btn" title="Copy to Clipboard">Copy to Clipboard</button>
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
        props: ['headerdata','header','citedata','user','isloggedin','corpuselasticsearchid','corpusid','corpuspath'],
        methods: {
            corpusAuthors: function(){
                var authorString = "";
                for(var i=0; i < this.headerdata.corpus_editor_forename.length;i++) {
                    authorString += this.headerdata.corpus_editor_forename[i]
                        .concat(' ')
                        .concat(this.headerdata.corpus_editor_surname[i])
                        .concat(',');
                }
                authorString = authorString.substring(0,authorString.lastIndexOf(","));
                return authorString;
            }
        },
        data: function(){
            return {
                containerClass: 'container-fluid',
                backgroundClass: this.isloggedin ? 'bg-bluegrey-mid': 'bg-corpus-light',
                bsh1 : 'bsh-1'
            }
        },
        mounted() {
            console.log('CorpusMetadataBlockHeader mounted.')
        }
    }
</script>