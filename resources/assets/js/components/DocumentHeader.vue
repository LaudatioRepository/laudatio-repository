<template lang="html">
   <div class="container pt-5" v-if="header == 'document'">
    <div class="row">
      <div class="col-2">
        <img class="w-100" src="/images/placeholder_circle.svg" alt="circle-image">
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
  <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat ad quod culpa molestias ab. Enim quo
    nesciunt sequi commodi quos nihil suscipit, beatae similique hic animi eius, doloremque, et corporis.</span>
  <b>Homepage: </b>
  <a href="#">Link</a>
  <b>Corpus-Link: </b>
  <a href="#">Link</a>
</div>
        </div>
      </div>
      <div class="col col-auto">
        <div class="card text-white bg-transparent">
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
        <a class="dropdown-item text-14" href="#">TEI-Header</a>
        <a class="dropdown-item text-14" href="#">EXCEL</a>
        <a class="dropdown-item text-14" href="#">PAULA</a>
        <a class="dropdown-item text-14" href="#">ANNIS</a>
      </div>
    </div>
    <button class=" btn btn-primary font-weight-bold text-uppercase rounded mb-3 small">
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
    </div>
    <div class="w-100 d-flex justify-content-start align-items-center">
      <img class="py-1" src="/images/license-cc.svg" alt="license cc" /> <img class="py-1" src="/images/license-sa.svg" alt="license sa" /> <img class="py-1" src="/images/license-by.svg" alt="license by" /> <img class="py-1" src="/images/license-nd.svg" alt="license nd" /> <img class="py-1" src="/images/license-nc.svg" alt="license nc" />
    </div>
  </div>
</div>
      </div>
    </div>
    <div class="row mt-5">
      <nav class="navbar navbar-expand-sm navbar-light bg-transparent p-0 container" role="navigation">
          <div class="navbar-nav row w-100">

            <div class="nav-item col-2 text-center text-14 font-weight-bold active">
              <a class="nav-link  text-dark text-uppercase " href="#documentMetadataBody">
                Document Metadata
              </a>
            </div>

            <div class="nav-item col-2 text-center text-14 font-weight-bold ">
              <a class="nav-link  text-dark text-uppercase " href="#annotationMetadataBody">
                Annotations <div class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                  <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                  <span class="text-primary text-14 font-weight-bold">{{headerdata.totaldocumentannotationcount}}</span>
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
        props: ['headerdata','header','user','isloggedin'],
        computed: {
            concatLanguages: function(){
                return this.headerdata.document_languages_language.join();
            }
        },
        methods: {
            facsimileUri: function(id) {
                return this.headerdata.document_history_faximile_link
            },
            /*
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
            */
        },
        mounted() {
            console.log('DocumentMetadataBlockHeader mounted.')
        }
    }
</script>