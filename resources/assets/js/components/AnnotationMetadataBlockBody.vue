<template lang="html">
    <div class="headerRow headerNav">
        <div class="bodyColumn left">

        </div>
        <div class="bodyColumn middle">
          <div class="container tab-content">
        <div class="tab-pane fade in active" id="guidelines">
            <div class="row">
              <div class="col-sm-3">
                <div class="sidebar-nav">
                    <div class="navbar-collapse collapse sidebar-navbar-collapse">
                      <ul class="nav nav-stacked">
                          <li role="tab" class="nav-link active"><a href="#tei-header" data-toggle="pill">TEI-HEADER</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-sm-9">
                <div class="tab-content" v-if="header == 'annotation'">
                    <div class="tab-pane fade in active" id="tei-header">
                        <h2>GUIDELINES - TEI-Header</h2>
                        <table class="table table-condensed">
                            <tr>
                                <th>Title: </th>

                            </tr>

                        </table>
                    </div>

                </div>
              </div>
            </div>
        </div>
        <div class="tab-pane fade" id="preparationsteps">
        <div class="row">
              <div class="col-sm-3">

                <div class="sidebar-nav">
                    <div class="navbar-collapse collapse sidebar-navbar-collapse">
                      <ul class="nav nav-stacked">
                        <li class="nav-link active" role="tab">
                            <a href="#allAnnotations" data-toggle="pill">All </a>
                        </li>


                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-sm-9">
               <div class="tab-content">
               <div class="tab-pane fade in active" id="allAnnotations" v-if="header == 'document'">



                </div>

                </div>
              </div>
            </div>
         </div>
    </div>
        </div>
        <div class="bodyColumn right">
        </div>
    </div>
</template>

<script>
    export default {
        props: ['headerdata','header'],
        data: function(){
            return {
                annotators: [],
                revisions: [],
                documentsByAnnotation: [],

            }

        },
        methods: {


        },
        computed: {

        },
        mounted() {
            console.log('DocumentMetadataBlockBody mounted.')
        }
    }
</script>