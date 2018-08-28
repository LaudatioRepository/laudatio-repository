<template lang="html">
   <div class="container-fluid tab-content content"  v-if="header == 'corpus'">
    <div role="tabpanel"  class="tab-pane active" id="corpusMetadataBody">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-2">

                        <nav class="sidebar text-14 nav flex-column border-top border-light mt-7"  role="navigation">
                          <div class="border-bottom border-light">
                          <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link stacktablink active" data-toggle="tab" role="tab" data-headertype="corpus" href="#corpusDescription">DESCRIPTION</a>
                            <a class="font-weight-normal text-uppercase py-3 px-0 nav-link" href="#" data-target="#authorCollapse"
                              data-toggle="collapse" aria-expanded="false" aria-controls="authorCollapse">
                              Authorship</a>
                            <div class="collapse " id="authorCollapse">
                              <div class="nav flex-column ">
                                <a class="font-weight-normal text-uppercase py-1 mb-1 nav-link stacktablink" data-toggle="tab" role="tab"  href="#editors" data-headertype="annotation"  v-if="this.corpusEditorRows().length > 0">EDITORS</a>
                                <a class="font-weight-normal text-uppercase py-1 mb-1 nav-link stacktablink" data-toggle="tab" role="tab"  href="#annotators" data-headertype="annotation"  v-if="this.corpusAnnotatorRows().length > 0">ANNOTATORS</a>
                                <a class="font-weight-normal text-uppercase py-1 mb-1 nav-link stacktablink" data-toggle="tab" role="tab"  href="#transcription" data-headertype="annotation"  v-if="this.corpusTranscriptionRows().length > 0">TRANSCRIPTION</a>
                                <a class="font-weight-normal text-uppercase py-1 mb-1 nav-link stacktablink" data-toggle="tab" role="tab"  href="#infrastructure" data-headertype="annotation"  v-if="this.corpusInfrastructureRows().length > 0">INFRASTRUCTURE</a>
                            </div>
                          </div>
                          <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link stacktablink" data-toggle="tab" role="tab" data-headertype="annotation" href="#corpusVersions">VERSIONS</a>
                          <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link stacktablink" id="licenselink" data-toggle="tab" role="tab" data-headertype="annotation" href="#corpusLicense">LICENSE / REVISION</a>
                          <!-- a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link stacktablink" data-toggle="tab" role="tab" data-headertype="license" href="#corpusFormats">FORMATS</a-->
                          </div>
                        </nav>
                    </div>
                    <div class="col">
                        <div id="tabcontainer" class="container-fluid tab-content content">


                            <div role="tabpanel"  class="tab-pane active" id="corpusDescription" v-if="header == 'corpus'">
                                <div class="d-flex justify-content-between mt-7 mb-3">
                                    <div class="h3 font-weight-normal">CORPUS DESCRIPTION</div>
                                </div>
                                <div class="panel-body"><p class="mb-7">{{headerdata.corpus_encoding_project_description | lastElement}}</p></div>
                                <div class="d-flex justify-content-between mt-7 mb-3">
                                    <div class="h3 font-weight-normal">CORPUS FORMATS</div>
                                </div>
                                <ul>
                                    <li v-for="format in getFormats()" v-bind:format="format"><a href="">{{format.format}}</a></li>
                                </ul>
</ul>
                            </div>

                            <div class="tab-pane fade" id="editors" v-if="header == 'corpus' && this.corpusEditorRows().length > 0">
                                <div class="d-flex justify-content-between mt-7 mb-3">
                                    <div class="h3 font-weight-normal">CORPUS EDITORS</div>
                                </div>
                            <vue-good-table
                              title=""
                              :columns="authorshipColumns"
                              :rows=corpusEditorRows()
                              :search-options="{
                                enabled: true,
                              }"
                              :pagination-options="{
                                enabled: false,
                              }"
                              :lineNumbers="false"
                              styleClass="vgt-table condensed custom-table table table-corpus-mid table-striped"/>
                        </div>

                        <div class="tab-pane fade" id="annotators" v-if="header == 'corpus' && this.corpusAnnotatorRows().length > 0">
                           <div class="d-flex justify-content-between mt-7 mb-3">
                                <div class="h3 font-weight-normal">ANNOTATORS</div>
                            </div>
                            <vue-good-table
                              title=""
                              :columns="authorshipColumns"
                              :rows=corpusAnnotatorRows()
                              :search-options="{
                                enabled: true,
                              }"
                              :pagination-options="{
                                enabled: false,
                              }"
                              :lineNumbers="false"
                              styleClass="vgt-table condensed custom-table table table-corpus-mid table-striped"/>
                        </div>

                        <div class="tab-pane fade" id="transcription" v-if="header == 'corpus' && this.corpusTranscriptionRows().length > 0">
                            <div class="d-flex justify-content-between mt-7 mb-3">
                                <div class="h3 font-weight-normal">TRANSCRIPTION</div>
                            </div>
                            <vue-good-table
                              title=""
                              :columns="authorshipColumns"
                              :rows=corpusTranscriptionRows()
                              :search-options="{
                                enabled: true,
                              }"
                              :pagination-options="{
                                enabled: false,
                              }"
                              :lineNumbers="false"
                              styleClass="vgt-table condensed custom-table table table-corpus-mid table-striped"/>
                        </div>

                        <div class="tab-pane fade" id="infrastructure" v-if="header == 'corpus' && this.corpusInfrastructureRows().length > 0">
                            <div class="d-flex justify-content-between mt-7 mb-3">
                                <div class="h3 font-weight-normal">INFRASTRUCTURE</div>
                            </div>
                            <vue-good-table
                              title=""
                              :columns="authorshipColumns"
                              :rows=corpusInfrastructureRows()
                              :search-options="{
                                enabled: true,
                              }"
                              :pagination-options="{
                                enabled: false,
                              }"
                              :lineNumbers="false"
                              styleClass="vgt-table condensed custom-table table table-corpus-mid table-striped"/>
                        </div>

                            <div role="tabpanel"  class="tab-pane fade in" id="corpusVersions" v-if="header == 'corpus'">
                                <div class="d-flex justify-content-between mt-7 mb-3">
                                    <div class="h3 font-weight-normal">VERSIONS</div>
                                </div>
                            <vue-good-table
                              title=""
                              :columns="versionColumns"
                              :rows=getRevisions()
                              :search-options="{
                                enabled: true,
                              }"
                              :pagination-options="{
                                enabled: false,
                              }"
                              :lineNumbers="false"
                              styleClass="vgt-table condensed custom-table table table-corpus-mid table-striped"/>
                            </div>

                            <div role="tabpanel"  class="tab-pane fade in" id="corpusLicense" v-if="header == 'corpus'">
                                {{headerdata.corpus_publication_license_description  | arrayToString }}
                                <div id="license-deed"></div>
                            </div>

                            <!--div role="tabpanel"  class="tab-pane fade in" id="corpusFormats" v-if="header == 'corpus'">
                                <div class="d-flex justify-content-between mt-7 mb-3">
                                    <div class="h3 font-weight-normal">FORMATS</div>
                                </div>
                                <vue-good-table
                                  title=""
                                  :columns="formatColumns"
                                  :rows=getFormats()
                                  :search-options="{
                                    enabled: true,
                                  }"
                                  :pagination-options="{
                                    enabled: false,
                                  }"
                                  :lineNumbers="false"
                                  styleClass="custom-table table table-corpus-mid table-striped"/>
                            </div-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>





        <div role="tabpanel"  class="tab-pane fade in" id="documentMetadataBody" v-if="header == 'corpus'">
            <div class="container">
              <div class="row">
                <div class="col">
                  <div class="d-flex justify-content-between align-items-center mt-7 mb-3 w-100">
                      <div class="h3 font-weight-normal">Documents</div>
                    </div>
                    <vue-good-table
                          :columns="documentColumns"
                          :rows=documentRows()
                          :lineNumbers="false"
                          @on-row-click="goToDocument"
                          :search-options="{
                            enabled: true,

                          }"
                          :sort-options="{
                            enabled: true,
                            initialSortBy: {field: 'title', type: 'asc'}
                          }"
                          :pagination-options="{
                            enabled: true,
                            perPage: 10,
                          }"
                          styleClass="vgt-table condensed custom-table table table-corpus-mid table-striped">
                          <template slot="table-row" slot-scope="props">
                              <span v-if="props.column.field == 'place'">
                                <i class="fa fa-fw fa-map-marker mr-1"></i> {{props.formattedRow[props.column.field]}}
                              </span>
                              <span v-else-if="props.column.field == 'date'">
                                 <i class="fa fa-fw fa-clock-o mr-1"></i> {{props.formattedRow[props.column.field]}}
                              </span>
                              <span v-else-if="props.column.field == 'title'">
                                <span class="hover-mouse-pointer">{{props.formattedRow[props.column.field]}}</span>
                              </span>
                              <span v-else-if="props.column.field == 'annotations'">
                                    <a href="#" class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                        <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                                        <span class="text-14 font-weight-bold">{{props.formattedRow[props.column.field]}}</span>
                                    </a>
                                </span>
                              <span v-else>
                                {{props.formattedRow[props.column.field]}}
                               </span>
                           </template>
                    </vue-good-table>
                </div>
              </div>
          </div>
        </div>

        <div role="tabpanel"  class="tab-pane fade in" id="annotationMetadataBody" v-if="header == 'corpus'">
             <div class="container">
              <div class="row">
                <div class="col-2">
                    <nav class="headernav sidebar text-14 nav flex-column border-top border-light mt-7" role="tablist">
                        <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link  stacktablink active" data-toggle="tab" role="tab" data-headertype="corpus" href="#allAnnotations">All ({{groupCount("all")}})</a>
                        <span v-for="(annotationGroup) in headerdata.allAnnotationGroups">
                            <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link  stacktablink" data-toggle="tab" role="tab" data-headertype="corpus" v-if="groupCount(annotationGroup) > 0 " v-bind:href="('#').concat(annotationGroup)">{{annotationGroup | touppercase}} ({{groupCount(annotationGroup)}})</a>
                            <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link  stacktablink disabledLink" data-toggle="tab" role="tab" data-headertype="corpus" v-else>{{annotationGroup | touppercase}}</a>
                        </span>
                    </nav>
                </div>
                <div class="col">
                    <div id="tabcontainer" class="container-fluid tab-content content">
                        <div role="tabpanel"  class="tab-pane active" id="allAnnotations" v-if="header == 'corpus'">
                            <div class="d-flex justify-content-between mt-7 mb-3">
                                <div class="h3 font-weight-normal">Annotations - All ({{groupCount("all")}})</div>
                            </div>
                            <vue-good-table
                                 :columns="annotationColumns"
                                 :rows=allAnnotationRows()
                                 :lineNumbers="false"
                                 @on-row-click="goToAnnotation"
                                 :search-options="{
                                    enabled: true,
                                  }"
                                  :pagination-options="{
                                    enabled: true,
                                    perPage: 10,
                                  }"
                                 styleClass="vgt-table condensed custom-table table table-corpus-mid table-striped">
                                <template slot="table-row" slot-scope="props">
                                    <span v-if="props.column.field == 'title'">
                                     <span class="hover-mouse-pointer">{{props.formattedRow[props.column.field]}}</span>
                                    </span>
                                    <span v-else-if="props.column.field == 'guidelines'">
                                      <a v-bind:href="('/browse/annotation/').concat(props.row.preparation_annotation_id).concat('#guidelines')"><i class="fa fa-fw fa-lg fa-angle-right"></i></a>
                                    </span>
                                    <span v-else-if="props.column.field == 'prep'">
                                      <a v-bind:href="('/browse/annotation/').concat(props.row.preparation_annotation_id).concat('#preparationsteps')"><i class="fa fa-fw fa-lg fa-angle-right"></i></a>
                                    </span>
                                    <span v-else-if="props.column.field == 'document_count'">
                                        <a href="#" class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                            <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                                            <span class="text-14 font-weight-bold">{{props.formattedRow[props.column.field]}}</span>
                                        </a>
                                    </span>
                                    <span v-else>
                                    {{props.formattedRow[props.column.field]}}
                                    </span>
                                </template>
                            </vue-good-table>
                        </div>

                        <div role="tabpanel"  class="tab-pane fade in" v-for="(annotationGroup) in headerdata.allAnnotationGroups" :id="annotationGroup" v-if="header == 'corpus'">
                            <div class="d-flex justify-content-between mt-7 mb-3">
                                <div class="h3 font-weight-normal">{{annotationGroup}}  ({{groupCount(annotationGroup)}})</div>
                            </div>
                            <vue-good-table
                              :columns="annotationColumns"
                              :rows=annotationRows(annotationGroup)
                              @on-row-click="goToAnnotation"
                              :search-options="{
                                enabled: true,
                              }"
                              :pagination-options="{
                                enabled: true,
                                perPage: 10,
                              }"
                              :lineNumbers="false"
                              :onClick="goToAnnotation"
                              styleClass="vgt-table condensed custom-table table table-corpus-mid table-striped">
                                <template slot="table-row" slot-scope="props">
                                    <span v-if="props.column.field == 'title'">
                                     <span class="hover-mouse-pointer">{{props.formattedRow[props.column.field]}}</span>
                                    </span>
                                    <span v-else-if="props.column.field == 'guidelines'">
                                      <a v-bind:href="('/browse/annotation/').concat(props.row.preparation_annotation_id).concat('#guidelines')"><i class="fa fa-fw fa-lg fa-angle-right"></i></a>
                                    </span>
                                    <span v-else-if="props.column.field == 'prep'">
                                      <a v-bind:href="('/browse/annotation/').concat(props.row.preparation_annotation_id).concat('#preparationsteps')"><i class="fa fa-fw fa-lg fa-angle-right"></i></a>
                                    </span>
                                    <span v-else-if="props.column.field == 'document_count'">
                                        <a href="#" class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                                            <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                                            <span class="text-14 font-weight-bold">{{props.formattedRow[props.column.field]}}</span>
                                        </a>
                                    </span>
                                    <span v-else>
                                    {{props.formattedRow[props.column.field]}}
                                    </span>
                                </template>
                            </vue-good-table>
                         </div>

                    </div>
                </div>
               </div>
             </div>
        </div>
        <div  v-if="workflowstatus == 0" class="verticalBadge text-uppercase font-weight-bold bg-blueadmin text-14 text-white rounded bsh-1" v-show="isloggedin" id="workflowBadge">
            <span>
                WORKING VERSION
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['headerdata','header','user','isloggedin','workflowstatus', 'corpusversion'],
        data: function(){
            return {
                annotators: [],
                revisions: [],
                documentsByAnnotation: [],
                authorshipColumns: [
                    {
                        label: 'Name',
                        field: 'name',
                        filterable: true,
                    },
                    {
                        label: 'Affiliation',
                        field: 'affiliation',
                        filterable: true,
                    }
                ],
                versionColumns: [
                    {
                        label: 'Revision',
                        field: 'revision',
                        filterable: true
                    },
                    {
                        label: 'Date',
                        field: 'date',
                        filterable: true
                    },
                    {
                        label: 'Revision description',
                        field: 'description',
                        filterable: true
                    }
                ],
                documentColumns: [
                    {
                        label: 'Title',
                        field: 'title',
                        filterable: true
                    },
                    {
                        label: 'Tokens',
                        field: 'tokens',
                        type: 'number',
                        filterable: true
                    },
                    {
                        label: 'Publishing date',
                        field: 'date',
                        filterable: true
                    },
                    {
                        label: 'Place',
                        field: 'place',
                        filterable: true
                    },
                    {
                        label: 'Annotations',
                        field: 'annotations',
                        type: 'number',
                        html: false,
                        filterable: true
                    },
                ],
                annotationColumns: [
                    {
                        label: 'Annotation key',
                        field: 'title',
                        filterable: true,
                    },
                    {
                        label: 'Category',
                        field: 'group',
                        filterable: true,
                    },
                    {
                        label: 'Annotators',
                        field: 'annotators',
                        filterable: false,
                    },
                    {
                        label: 'Guidelines',
                        field: 'guidelines',
                        filterable: false,
                    },
                    {
                        label: 'Preparation steps',
                        field: 'prep',
                        filterable: false,
                    },
                    {
                        label: 'Documents',
                        field: 'document_count',
                        type: 'number',
                        html: false,
                        filterable: true,
                    }
                ],
                formatColumns: [
                    {
                        label: 'Name',
                        field: 'format',
                        filterable: true,
                    }
                ],
            }

        },
        methods: {
            corpusEditorRows: function(){
                var editorArray = [];
                var theHeaderData = this.headerdata;
                if( typeof theHeaderData.corpus_editor_forename != 'undefined' &&
                    typeof theHeaderData.corpus_editor_surname != 'undefined' &&
                    typeof theHeaderData.corpus_editor_affiliation_department != 'undefined' &&
                    typeof theHeaderData.corpus_editor_affiliation_institution != 'undefined' &&
                    this.hasSameLength([
                        theHeaderData.corpus_editor_forename,
                        theHeaderData.corpus_editor_surname,
                        theHeaderData.corpus_editor_affiliation_department,
                        theHeaderData.corpus_editor_affiliation_institution
                    ])
                ){
                    for(var i = 0; i < theHeaderData.corpus_editor_forename.length;i++){
                        var personObject = {}
                        personObject.name = theHeaderData.corpus_editor_forename[i]+" "+theHeaderData.corpus_editor_surname[i];
                        personObject.affiliation = theHeaderData.corpus_editor_affiliation_department[i]+", "+theHeaderData.corpus_editor_affiliation_institution[i]
                        editorArray.push(personObject);
                    }
                }


                return editorArray;
            },
            corpusAnnotatorRows: function(){
                var annotatorArray = [];
                var theHeaderData = this.headerdata;
                if( typeof theHeaderData.corpus_annotator_forename != 'undefined' &&
                    typeof theHeaderData.corpus_annotator_surname != 'undefined' &&
                    typeof theHeaderData.corpus_annotator_affiliation_department != 'undefined' &&
                    typeof theHeaderData.corpus_annotator_affiliation_institution != 'undefined' &&
                    this.hasSameLength([
                        theHeaderData.corpus_annotator_forename,
                        theHeaderData.corpus_annotator_surname,
                        theHeaderData.corpus_annotator_affiliation_department,
                        theHeaderData.corpus_annotator_affiliation_institution
                    ])
                ){
                    for(var i = 0; i < theHeaderData.corpus_annotator_forename.length;i++){
                        var personObject = {}
                        personObject.name = theHeaderData.corpus_annotator_forename[i]+" "+theHeaderData.corpus_annotator_surname[i];
                        personObject.affiliation = theHeaderData.corpus_annotator_affiliation_department[i]+", "+theHeaderData.corpus_annotator_affiliation_institution[i]
                        annotatorArray.push(personObject);
                    }
                }

                return annotatorArray;
            },
            corpusInfrastructureRows: function(){
                var infrastructureArray = [];
                var theHeaderData = this.headerdata;
                if( typeof theHeaderData.corpus_author_infrastructure_forename != 'undefined' &&
                    typeof theHeaderData.corpus_author_infrastructure_surname != 'undefined' &&
                    typeof theHeaderData.corpus_infrastructure_affiliation_department != 'undefined' &&
                    typeof theHeaderData.corpus_infrastructure_affiliation_institution != 'undefined' &&
                    this.hasSameLength([
                        theHeaderData.corpus_author_infrastructure_forename,
                        theHeaderData.corpus_author_infrastructure_surname,
                        theHeaderData.corpus_infrastructure_affiliation_department,
                        theHeaderData.corpus_infrastructure_affiliation_institution
                    ])
                ){
                    for(var i = 0; i < theHeaderData.corpus_author_infrastructure_forename.length;i++){
                        var personObject = {}
                        personObject.name = theHeaderData.corpus_author_infrastructure_forename[i]+" "+theHeaderData.corpus_author_infrastructure_surname[i];
                        personObject.affiliation = theHeaderData.corpus_infrastructure_affiliation_department[i]+", "+theHeaderData.corpus_infrastructure_affiliation_institution[i]
                        infrastructureArray.push(personObject);
                    }
                }

                return infrastructureArray;
            },
            corpusTranscriptionRows: function(){
                var transcriptionArray = [];
                var theHeaderData = this.headerdata;
                if( typeof theHeaderData.corpus_author_transcription_forename != 'undefined' &&
                    typeof theHeaderData.corpus_author_transcription_surname != 'undefined' &&
                    typeof theHeaderData.corpus_author_transcription_affiliation_department != 'undefined' &&
                    typeof theHeaderData.corpus_author_transcription_affilitation_institution != 'undefined' &&
                    this.hasSameLength([
                        theHeaderData.corpus_author_transcription_forename,
                        theHeaderData.corpus_author_transcription_surname,
                        theHeaderData.corpus_author_transcription_affilitation_institution,
                        theHeaderData.corpus_author_transcription_affilitation_institution
                    ])
                ){
                    for(var i = 0; i < theHeaderData.corpus_author_transcription_forename.length;i++){
                        var personObject = {}
                        if( typeof theHeaderData.corpus_author_transcription_forename[i] != 'undefined' &&
                            typeof theHeaderData.corpus_author_transcription_surname[i] != 'undefined' &&
                            typeof theHeaderData.corpus_author_transcription_affiliation_department[i] != 'undefined' &&
                            typeof theHeaderData.corpus_author_transcription_affilitation_institution[i] != 'undefined'){
                            personObject.name = theHeaderData.corpus_author_transcription_forename[i]+" "+theHeaderData.corpus_author_transcription_surname[i];
                            personObject.affiliation = theHeaderData.corpus_author_transcription_affilitation_institution[i]+", "+theHeaderData.corpus_author_transcription_affilitation_institution[i]
                            transcriptionArray.push(personObject);
                        }

                    }
                }

                return transcriptionArray;
            },
            getRevisions: function(){
                var revisionArray = [];
                var theHeaderData = this.headerdata;
                if(typeof theHeaderData != 'undefined' && theHeaderData.corpus_version.length > 0
                    && theHeaderData.corpus_version_publishing_date.length > 0
                    && theHeaderData.corpus_version_description.length > 0
                    && theHeaderData.corpus_version.length
                    == theHeaderData.corpus_version_description.length
                    && theHeaderData.corpus_version.length
                    == theHeaderData.corpus_version_publishing_date.length){
                    for(var j = 0; j < theHeaderData.corpus_version.length; j++) {
                        let revisiondata = {};
                        revisiondata.date = this.headerdata.corpus_version_publishing_date[j];
                        revisiondata.revision = this.headerdata.corpus_version[j];
                        revisiondata.description = this.headerdata.corpus_version_description[j];
                        revisionArray.push(revisiondata);
                    }
                }
                return revisionArray.reverse()
            },
            getFormats: function(){
                var formatArray = [];
                var theHeaderData = this.headerdata;
                if(typeof theHeaderData != 'undefined' && theHeaderData.formats.length > 0){
                    for(var j = 0; j < theHeaderData.formats.length; j++) {
                        let formatdata = {};
                        formatdata.format = theHeaderData.formats[j];
                        formatArray.push(formatdata);
                    }
                }
                return formatArray
            },
            documentRows: function(){
                var documentArray = [];
                var theHeaderData = this.headerdata;
                if( typeof theHeaderData.corpusdocuments != 'undefined' &&
                    theHeaderData.corpusdocuments.length > 0){

                    for(var i = 0; i < theHeaderData.corpusdocuments.length; i++) {
                        var documentObject = {}
                        documentObject.title = theHeaderData.corpusdocuments[i].document_title[0];
                        documentObject.tokens = parseInt(theHeaderData.corpusdocuments[i].document_size_extent[0].replace('.',''),10);
                        documentObject.date = theHeaderData.corpusdocuments[i].document_publication_publishing_date[0];
                        documentObject.place = theHeaderData.corpusdocuments[i].document_publication_place[0];
                        documentObject.annotations = theHeaderData.corpusdocuments[i].document_list_of_annotations_name.length;
                        documentObject.document_id = theHeaderData.corpusdocuments[i].document_id;
                        documentArray.push(documentObject);
                    }

                }
                return documentArray;
            },
            allAnnotationRows: function() {
                var annotationArray = [];
                var foundAnnotationArray = [];
                var theHeaderData = this.headerdata;
                if(null != theHeaderData.allAnnotationGroups && null != theHeaderData.corpusAnnotationGroups && typeof theHeaderData.corpusAnnotationGroups != 'undefined'){
                    Object.keys(this.headerdata.corpusAnnotationGroups).forEach(function(key, index) {
                        this[key].forEach(function(value){
                            value.group = key;
                            if(typeof value.document_count == 'undefined'){
                                value.document_count = 0.0;
                            }
                            if(foundAnnotationArray.indexOf(value.title) == -1){
                                annotationArray.push(value);
                                foundAnnotationArray.push(value.title);
                            }

                        })
                    }, this.headerdata.corpusAnnotationGroups);
                }
                return annotationArray;
            },
            annotationRows: function(currentkey){
                var annotationArray = [];
                var foundAnnotationArray = [];
                var theHeaderData = this.headerdata;
                if(null != theHeaderData.allAnnotationGroups && null != theHeaderData.corpusAnnotationGroups && typeof theHeaderData.corpusAnnotationGroups != 'undefined'){
                    Object.keys(this.headerdata.corpusAnnotationGroups).forEach(function(key, index) {
                        if(key == currentkey) {
                            this[key].forEach(function(value){
                                value.group = key;
                                if(typeof value.document_count == 'undefined'){
                                    value.document_count = 0.0;
                                }
                                if (typeof value['annotators'][value.preparation_annotation_id] != 'undefined') {
                                    value.annotators = value['annotators'][value.preparation_annotation_id].join(", ");
                                }

                                if(foundAnnotationArray.indexOf(value.title) == -1){
                                    annotationArray.push(value);
                                    foundAnnotationArray.push(value.title);
                                }

                            })
                        }

                    }, this.headerdata.corpusAnnotationGroups);
                }
                return annotationArray;
            },
            groupCount: function(currentkey) {
                var foundAnnotationArray = [];
                var theHeaderData = this.headerdata;
                var count = 0;
                if(null != theHeaderData.allAnnotationGroups && null != theHeaderData.corpusAnnotationGroups && typeof theHeaderData.corpusAnnotationGroups != 'undefined'){
                    Object.keys(this.headerdata.corpusAnnotationGroups).forEach(function(key, index) {
                        if(key == currentkey || currentkey == "all") {
                            this[key].forEach(function(value){
                                if(foundAnnotationArray.indexOf(value.title) == -1){
                                    count++;
                                    foundAnnotationArray.push(value.title);
                                }
                            })
                        }

                    }, this.headerdata.corpusAnnotationGroups);
                }
                return count;
            },
            goToDocument: function(params) {
                document.location = "/browse/document/"+params.row.document_id
                return params.pageIndex;

            },
            goToAnnotation: function(params) {
                document.location = "/browse/annotation/"+params.row.preparation_annotation_id
                return params.pageIndex;

            },
            hasSameLength: function(attributes) {
                var hasSameLength = false;
                var lastLength = 0;

                if(typeof attributes != 'undefined'){
                    for(var i = 0; i < attributes.length; i++) {
                        if(typeof attributes[i] != 'undefined'){
                            if(lastLength != 0){

                                if(lastLength == attributes[i].length){
                                    hasSameLength = true;
                                }
                                else{
                                    hasSameLength = false;
                                }
                            }
                            lastLength = attributes[i].length;
                        }

                    }
                }

                return hasSameLength;
            },
            onlyUnique: function (arr) {
                var a = [];
                for (var i=0, l=arr.length; i<l; i++)
                    if (a.indexOf(arr[i]) === -1 && arr[i] !== '')
                        a.push(arr[i]);
                return a;
            }
        },
        computed: {

            getAnnotators: function(){
              if(typeof this.headerdata != 'undefined' && this.headerdata.corpus_annotator_forename.length > 0
                  && this.headerdata.corpus_annotator_surname.length > 0 &&
                  this.headerdata.corpus_annotator_forename.length == this.headerdata.corpus_annotator_surname.length){
                  for(var i = 0; i<  this.headerdata.corpus_annotator_forename.length; i++){
                      this.annotators.push(this.headerdata.corpus_annotator_forename[i].concat(" ").concat(this.headerdata.corpus_annotator_surname[i]))
                  }
              }
              return this.annotators
            },
            getDocumentsByAnnotation: function() {
              if(typeof this.headerdata != 'undefined' && this.headerdata.annotation_name.length > 0) {
                  var annotationterms = [];
                  for(var k = 0; k < this.headerdata.annotation_name.length; k++){
                      annotationterms.push(
                          {
                              'document_list_of_annotations_name': ''+this.headerdata.annotation_name[k]+''
                          }
                      );
                  }
                  var pathArray = window.location.pathname.split( '/' );
                  var corpus_id = pathArray[pathArray.length-1];


                  let postAnnotationData = {
                      searchData: annotationterms,
                      index: 'document',
                      corpus_id: corpus_id
                  };

                  window.axios.post('/api/searchapi/getSearchTotal',postAnnotationData).then(documentsByAnnotationRes => {
                      if (Object.keys(documentsByAnnotationRes.data.results).length > 0) {
                          this.documentsByAnnotation.push(
                              documentsByAnnotationRes.data.results
                        );
                      }
                  });
              }
                //return this.documentsByAnnotation;
            }
        },
        mounted() {
            console.log('CorpusMetadataBlockBody mounted.')
        }
    }
</script>