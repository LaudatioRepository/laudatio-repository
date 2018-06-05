<template lang="html">
   <div class="container pt-5" v-if="header == 'annotation'">
    <div class="row">
      <div class="col-2">
        <img class="w-100" src="/images/placeholder_circle.svg" alt="circle-image">
      </div>
      <div class="col pr-5">
        <h3 class="h3 font-weight-bold">
         {{ headerdata.preparation_title | arrayToString }}
        </h3>
        <p class="text-wine">
          Annotation in {{headerdata.annotationCorpusdata.corpus_title | arrayToString}}
        </p>
        <p class="text-wine">
          {{ annotationEditors() }}
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
                    {{ headerdata.annotationCorpusdata.corpus_title | arrayToString }};
                    {{ headerdata.annotationCorpusdata.corpus_publication_publisher[0] }};</span>
          <b>Homepage: </b>
          <a v-bind:href="(headerdata.annotationCorpusdata.corpus_encoding_project_homepage[0])>Link</a>
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
                <button class=" btn btn-primary font-weight-bold text-uppercase rounded small mt-3" data-toggle="modal"
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
                </button>
                <div class="dropdown">
                  <button class=" w-100 btn btn-outline-corpus-dark dropdown-toggle font-weight-bold text-uppercase rounded mb-3"
                    type="button" id="corpusMainActions-Choice" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    CITE
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item text-14" href="#">Menuitem 1</a>
                    <a class="dropdown-item text-14" href="#">Menuitem 2</a>
                    <a class="dropdown-item text-14" href="#">Menuitem 3</a>
                  </div>
                </div-->
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


           <div class="nav-item maintablink col-auto text-center text-14 font-weight-bold active" id="guidelines_nav">
                <a class="nav-link maintablink text-dark text-uppercase" data-toggle="tab" href="#guidelines" role="tab"> GUIDELINES</a>
           </div>

           <div class="nav-item maintablink col-auto text-center text-14 font-weight-bold" id="preparationsteps_nav">
                <a class="nav-link maintablink text-dark text-uppercase " data-toggle="tab" href="#preparationsteps" role="tab"> PREPARATION STEPS</a>
           </div>


           <div class="nav-item maintablink col-auto text-center text-14 font-weight-bold">
                <a class="nav-link maintablink text-dark text-uppercase " data-toggle="tab" href="#annotationDocumentBody" role="tab"> DOCUMENTS
                    <div class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                        <i class="fa fa-comment-o fa-fw fa-edit align-text-top fa-lg text-wine"></i>
                        <span class="text-primary text-14 font-weight-bold">{{headerdata.annotationdocumentcount}}</span>
                    </div>
                </a>
           </div>

          </div>
       </nav>
     </div>

  </div>
</template>

<script>
    export default {
        props: ['headerdata','header','user','isloggedin','corpuselasticsearchid','corpusid','corpuspath'],
        methods: {
            annotationEditors: function(){
                var editorString = "";
                for(var i=0; i < this.headerdata.corpus_editor_forename.length;i++) {
                    editorString += this.headerdata.corpus_editor_forename[i]
                        .concat(' ')
                        .concat(this.headerdata.corpus_editor_surname[i])
                        .concat(',');
                }
                editorString = editorString.substring(0,editorString.lastIndexOf(","));
                return editorString;
            },
            facsimileUri: function(id) {
                return this.headerdata.document_history_faximile_link
            },
            corpusAuthors: function(){
                var authorString = "";
                for(var i=0; i < this.headerdata.annotationCorpusdata.corpus_editor_forename.length;i++) {
                    authorString += this.headerdata.annotationCorpusdata.corpus_editor_forename[i]
                        .concat(' ')
                        .concat(this.headerdata.annotationCorpusdata.corpus_editor_surname[i])
                        .concat(',');
                }
                authorString = authorString.substring(0,authorString.lastIndexOf(","));
                return authorString;
            }
        },
        mounted() {
            console.log('AnnotationHeader mounted.')
        }
    }
</script>