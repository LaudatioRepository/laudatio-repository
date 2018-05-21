<template lang="html">
<div>
 <div class="container-fluid bg-bluegrey-mid bsh-1">
        <div class="container pt-5">
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
  <span>
    D. from 1945 - 1950
  </span>
</div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
  <i class="fa fa-fw fa-th-list  mr-1"></i>
  <span>
    Herbology
  </span>
</div>
                </div>
                <div class="col col-auto mr-2">
      <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
  <i class="fa fa-fw fa-globe mr-1"></i> <span>{{headerdata.corpus_languages_language[0]}}</span>
</div> <div class="corpusProp text-14 d-flex align-items-center align-self-start pr-1 my-1 flex-nowrap">
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
                    {{ headerdata.corpus_publication_publisher[0] }};
                    Homepage: {{ headerdata.corpus_encoding_project_homepage[0] }};
                    Corpus-Link: <a href="http://handle">http://handle.net/xxx</a></span>
  <b>Homepage: </b>
  <a href="#">Link</a>
  <b>Corpus-Link: </b>
  <a href="#">Link</a>
</div>
              </div>
            </div>
            <div class="col-2">
              <div class="card text-white bg-transparent">
  <h6 class="corpus-title h6 text-uppercase text-12 text-wine-trans">
    Corpus
  </h6>
  <div class="card-body d-flex flex-column">
    <a href="adminEdit_corpus.html" class=" btn btn-outline-corpus-dark font-weight-bold text-uppercase rounded small">
      Edit
    </a>
    <button class=" btn btn-primary font-weight-bold text-uppercase rounded small mt-3" data-toggle="modal"
      data-target="#publishCorpusModal">
      Publish
    </button>
  </div>
</div>
            </div>
          </div>
            <div class="row mt-5">

                <nav class="navbar navbar-expand-sm navbar-light bg-transparent p-0 container" role="tablist">

                    <div class="navbar-nav nav row w-100 px-5">
                        <div class="nav-item maintablink col-2 text-center text-14 font-weight-bold active">
                            <a class=" nav-link maintablink text-dark text-uppercase " data-toggle="tab" href="#editCorpus" role="tab">
                                CORPUS
                            </a>
                        </div>


                        <div class="nav-item col-auto text-center text-14 font-weight-bold ">
                              <a class="nav-link  text-dark text-uppercase " href="adminPreview_documents.html">
                                Documents <div class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1">
                          <i class="fa fa-text-height fa-fw fa-file-text-o align-baseline fa-lg text-wine"></i>
                          <span class="text-primary text-14 font-weight-bold">{{headerdata.corpusdocumentcount}}</span>
                        </div>
                        </a>
                        </div>




                        <div class="nav-item col-auto text-center text-14 font-weight-bold ">
                          <a class="nav-link  text-dark text-uppercase " href="adminPreview_annotations.html">
                            Annotations <div class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                      <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                      <span class="text-primary text-14 font-weight-bold">{{headerdata.totalcorpusannotationcount}}</span>
                    </div>
                          </a>
                        </div>

                    </div>

                </nav>

            </div>
        </div>
    </div>


    <!-- Tab panes -->

    <div class="container-fluid tab-content content">

        <div role="tabpanel"  class="tab-pane active" id="editCorpus">

        </div>

        <div role="tabpanel"  class="tab-pane fade in" id="messageBoard">

        </div>
        <div role="tabpanel"  class="tab-pane fade in" id="corpusCollaborators">
            <div class="container-fluid">
                <div class="container">
                    <div class="row">

                        <div class="col">
                            <div class="d-flex justify-content-between mt-7 mb-3">
                                <h3 class="h3 font-weight-normal">Corpus Collaborator</h3>


                            </div>

                            <table class="documents-table table table-bluegrey-dark  table-striped">
                                <thead class="bg-bluegrey-mid">
                                <tr class="text-14 text-grey-light">
                                    <th scope="col">Collaborator</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Institute</th>

                                        <th scope="col">Delete</th>

                                        <th scope="col" colspan="2">&nbsp;</th>

                                </tr>
                                </thead>
                                <tbody>

                                <tr>
                                    <td>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="corpusEditItem_0001">

                                                <label class="custom-control-label font-weight-bold" for="corpusEditItem_0001">
                                                    <i class="fa fa-user fa-fw"></i>

                                                </label>
                                            </div>


                                            <label class="custom-control-label font-weight-bold" for="corpusEditItem_0001">
                                                <i class="fa fa-user fa-fw"></i>

                                            </label>

                                    </td>


                                        <td>

                                        </td>

                                        <td>
                                            <span class="font-weight-bold text-uppercase"></span>
                                        </td>

                                    <td class="text-14 text-grey-light">df</td>

                                        <td>
                                            <a href="#">
                                                <i class="fa fa-trash-o fa-fw fa-lg text-dark"></i>
                                            </a>
                                        </td>

                                        <td>
                                            <a href="#">
                                                &nbsp;
                                            </a>
                                        </td>

                                </tr>

                                </tbody>
                                <tfoot class="bg-bluegrey-mid">
                                <tr>
                                    <td colspan="2">

                                    </td>
                                    <td colspan="2">


                                    </td>
                                </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        props: ['headerdata','header'],
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
        mounted() {
            console.log('CorpusMetadataBlockHeader mounted.')
        }
    }
</script>