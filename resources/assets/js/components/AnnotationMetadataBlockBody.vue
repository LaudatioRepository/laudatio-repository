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
                          <li v-for="(guidelinedata, guidelinekey) in headerdata.guidelines" class="nav-link" role="tab">
                                <a v-if="Object.keys(guidelinedata['annotations']).length > 0" v-bind:href="('#').concat(guidelinekey)" data-toggle="pill" >{{guidelinekey}}</a>
                                <!-- a href="#" data-toggle="collapse" v-bind:data-target="('#drilldown-').concat(guidelinekey)">{{guidelinekey}}</a-->
                                    <!--ul v-bind:id="('drilldown-').concat(guidelinekey)" class="nav nav-stacked collapse">
                                        <li role="tab" class="nav-link" v-for="(annotationdata, annotationkey) in guidelinedata['annotations']">
                                            <a href="#">{{annotationkey}}</a>
                                         </li>
                                      </ul-->


                            <!--span v-else>
                                <a v-bind:href="('#').concat(guidelinekey)" data-toggle="pill" >{{guidelinekey}}</a>
                            </span-->
                        </li>
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
                    <div class="tab-pane fade" v-for="(guidelinedata, guidelinekey) in headerdata.guidelines" :id="guidelinekey" v-if="header == 'annotation'">
                    <h2>GUIDELINES - for the {{guidelinekey}} format</h2>
                    <vue-good-table
                      title=""
                      :columns="guidelineColumns"
                      :rows=rows(guidelinekey)
                      :paginate="true"
                      :lineNumbers="false"
                      styleClass="table table-striped"/>
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
               <div class="tab-pane fade in active" id="allAnnotations" v-if="header == 'annotation'">

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
                guidelineColumns: [
                    {
                        label: 'Annotation key',
                        field: 'title',
                        filterable: true,
                    },
                    {
                        label: 'Description',
                        field: 'description',
                        filterable: true,
                    }
                ],
                guidelineRows: [],

            }

        },
        methods: {
            rows: function(format){
                var guidelineArray = [];
                var annotationTitle = this.headerdata.preparation_title[0];
                if(null != this.headerdata.guidelines && typeof this.headerdata.guidelines != 'undefined'){
                    Object.keys(this.headerdata.guidelines).forEach(function(formatKey, formatIndex) {
                        var annotationData = this[formatKey];
                        if(typeof this[formatKey]['annotations'] != 'undefined'){
                            if(format == formatKey && Object.keys(this[formatKey]['annotations']).length > 0){
                                Object.keys(this[formatKey]['annotations'][annotationTitle]).forEach(function (guidelineKey, guidelineIndex) {
                                    var valueObject = {}
                                    valueObject.title = guidelineKey;
                                    valueObject.description = annotationData['annotations'][annotationTitle][guidelineKey]

                                    guidelineArray.push(valueObject);
                                }, this[formatKey]['annotations']);
                            }
                        }

                    }, this.headerdata.guidelines);
                }
                return guidelineArray;
            }

        },
        computed: {

        },
        mounted() {
            console.log('DocumentMetadataBlockBody mounted.')
        }
    }
</script>