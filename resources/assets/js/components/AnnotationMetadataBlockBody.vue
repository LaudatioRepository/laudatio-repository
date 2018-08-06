<template lang="html">
 <div class="container-fluid tab-content content"  v-if="header == 'annotation'">
        <div role="tabpanel"  class="tab-pane mainpanel active" id="guidelines">
            <div class="container">
                <div class="row">
                    <div class="col-2">
                        <nav class="headernav sidebar text-14 nav flex-column border-top border-light mt-7" role="tablist">
                            <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link active tablink" data-toggle="tab" role="tab" data-headertype="annotation" href="#tei-header">Description</a>
                            <a v-for="(guidelinedata, guidelinekey) in headerdata.guidelines" class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link tablink" data-toggle="tab" role="tab" data-headertype="annotation" v-if="Object.keys(guidelinedata['annotations']).length > 0" v-bind:href="('#').concat(guidelinekey)">{{guidelinekey}}</a>
                        </nav>
                    </div>
                    <div class="col">
                        <div id="tabcontainer" class="container-fluid tab-content content">
                            <div role="tabpanel"  class="tab-pane active" id="tei-header" v-if="header == 'annotation'">
                                <div class="d-flex justify-content-between mt-7 mb-3">
                                    <div class="h3 font-weight-normal">GUIDELINES for <em>{{ headerdata.preparation_title | arrayToString }}</em></div>
                                </div>
                                <vue-good-table
                                  title=""
                                  :columns="guidelineColumnsGeneric"
                                  :rows=allGuidelineRows()
                                  :search-options="{
                                    enabled: true,
                                  }"
                                  :pagination-options="{
                                    enabled: true,
                                    perPage: 10,
                                  }"
                                  :lineNumbers="false"
                                  styleClass="vgt-table condensed custom-table table table-corpus-mid table-striped"/>
                            </div>

                            <div role="tabpanel"  class="tab-pane fade" v-for="(guidelinedata, guidelinekey) in headerdata.guidelines" :id="guidelinekey" v-if="header == 'annotation'">
                                <div class="d-flex justify-content-between mt-7 mb-3">
                                    <div class="h3 font-weight-normal">GUIDELINES - for <em>{{ headerdata.preparation_title | arrayToString }}</em> in the {{guidelinekey}} format</div>
                                </div>
                                <vue-good-table
                                  title=""
                                  :columns="guidelineColumns"
                                  :rows=guidelineRows(guidelinekey)
                                  :search-options="{
                                    enabled: true,
                                  }"
                                  :pagination-options="{
                                    enabled: true,
                                    perPage: 10,
                                  }"
                                  :lineNumbers="false"
                                  styleClass="vgt-table condensed custom-table table table-corpus-mid table-striped"/>
                            </div>

                            <div role="tabpanel"  class="tab-pane fade" id="license" v-if="header == 'annotation'">
                                <div class="d-flex justify-content-between mt-7 mb-3">
                                    <div class="h3 font-weight-normal">LICENSE / REVISION</div>
                                </div>
                                <vue-good-table
                                title=""
                                :columns="licenseColumns"
                                :rows=licenseRows()
                                :search-options="{
                                    enabled: true,
                                }"
                                :pagination-options="{
                                    enabled: false,
                                }"
                                :lineNumbers="false"
                                styleClass="vgt-table condensed custom-table table table-corpus-mid table-striped"/>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel"  class="tab-pane mainpanel fade in" id="preparationsteps" v-if="header == 'annotation'">
             <div class="container">
                <div class="row">
                    <div class="col-2">
                        <nav class="sidebar text-14 nav flex-column border-top border-light mt-7"  role="navigation">
                          <div class="border-bottom border-light">
                            <a class="font-weight-normal text-uppercase py-3 px-0 nav-link" href="#" data-target="#authorCollapse"
                              data-toggle="collapse" aria-expanded="false" aria-controls="authorCollapse">
                              Authorship</a>
                            <div class="collapse " id="authorCollapse">
                              <div class="nav flex-column ">
                                <a class="font-weight-normal text-uppercase py-1 mb-1 nav-link stacktablink" data-toggle="tab" role="tab"  href="#editors" data-headertype="annotation"  v-if="this.editorRows().length > 0">EDITORS</a>
                                <a class="font-weight-normal text-uppercase py-1 mb-1 nav-link stacktablink" data-toggle="tab" role="tab"  href="#annotators" data-headertype="annotation"  v-if="this.annotatorRows().length > 0">ANNOTATORS</a>
                                <a class="font-weight-normal text-uppercase py-1 mb-1 nav-link stacktablink" data-toggle="tab" role="tab"  href="#transcription" data-headertype="annotation"  v-if="this.transcriptionRows().length > 0">TRANSCRIPTION</a>
                                <a class="font-weight-normal text-uppercase py-1 mb-1 nav-link stacktablink" data-toggle="tab" role="tab"  href="#infrastructure" data-headertype="annotation"  v-if="this.infrastructureRows().length > 0">INFRASTRUCTURE</a>
                            </div>
                          </div>
                          <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link stacktablink" data-toggle="tab" role="tab"   href="#preparationversions" data-headertype="annotation"  v-if="this.versionRows().length > 0">VERSIONS</a>
                          <!--a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link stacktablink" data-toggle="tab" role="tab"  href="#preparationlicense" data-headertype="annotation"  v-if="this.licenseRows().length > 0">LICENSE / SOURCE</a-->
                          <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link stacktablink active" data-toggle="tab" role="tab"  data-headertype="annotation"  href="#preparations" v-if="this.preparationRows().length > 0">Preparation</a>
                          </div>
                        </nav>
                    </div>
                    <div class="col">
                        <div id="tabcontainer" class="container-fluid tab-content content">
                            <div role="tabpanel"  class="tab-pane fade" id="editors" v-if="header == 'annotation'">
                                <div class="d-flex justify-content-between mt-7 mb-3">
                                    <div class="h3 font-weight-normal">Editors</div>
                                </div>
                                   <vue-good-table
                                  :columns="personColumns"
                                  :rows=editorRows()
                                  :search-options="{
                                    enabled: true,
                                  }"
                                  :pagination-options="{
                                    enabled: true,
                                    perPage: 10,
                                  }"
                                  :lineNumbers="false"
                                  styleClass="vgt-table condensed  custom-table table table-corpus-mid table-striped" />
                            </div>



                            <div role="tabpanel"  class="tab-pane fade" id="annotators" v-if=" this.annotatorRows().length > 0">
                                <div class="d-flex justify-content-between mt-7 mb-3">
                                    <div class="h3 font-weight-normal">Annotators</div>
                                </div>
                               <vue-good-table
                              :columns="personColumns"
                              :rows=annotatorRows()
                              :search-options="{
                                enabled: true,
                              }"
                              :pagination-options="{
                                enabled: true,
                                perPage: 10,
                              }"
                              :lineNumbers="false"
                              styleClass="vgt-table condensed custom-table table table-corpus-mid table-striped" />
                            </div>






                            <div role="tabpanel"  class="tab-pane fade" id="transcription" v-if=" this.transcriptionRows().length > 0">
                                <div class="d-flex justify-content-between mt-7 mb-3">
                                    <div class="h3 font-weight-normal">Transcription</div>
                                </div>
                               <vue-good-table
                              :columns="personColumns"
                              :rows=transcriptionRows()
                              :search-options="{
                                enabled: true,
                              }"
                              :pagination-options="{
                                enabled: true,
                                perPage: 10,
                              }"
                              :lineNumbers="false"
                              styleClass="vgt-table condensed custom-table table table-corpus-mid table-striped" />
                            </div>



                            <div role="tabpanel"  class="tab-pane fade" id="infrastructure" v-if=" this.infrastructureRows().length > 0">
                                <div class="d-flex justify-content-between mt-7 mb-3">
                                    <div class="h3 font-weight-normal">Infrastructure</div>
                                </div>
                               <vue-good-table
                              :columns="personColumns"
                              :rows=infrastructureRows()
                              :search-options="{
                                enabled: true,
                              }"
                              :pagination-options="{
                                enabled: true,
                                perPage: 10,
                              }"
                              :lineNumbers="false"
                              styleClass="vgt-table condensed custom-table table table-corpus-mid table-striped" />
                            </div>



                            <div role="tabpanel"  class="tab-pane fade" id="preparationversions" v-if=" this.versionRows().length > 0">
                                <div class="d-flex justify-content-between mt-7 mb-3">
                                    <div class="h3 font-weight-normal">Versions</div>
                                </div>
                               <vue-good-table
                              :columns="versionColumns"
                              :rows=versionRows()
                              :search-options="{
                                enabled: true,
                              }"
                              :pagination-options="{
                                enabled: true,
                                perPage: 10,
                              }"
                              :lineNumbers="false"
                              styleClass="vgt-table condensed custom-table table table-corpus-mid table-striped" />
                            </div>



                            <div role="tabpanel"  class="tab-pane fade" id="preparationlicense" v-if=" this.licenseRows().length > 0">
                                <div class="d-flex justify-content-between mt-7 mb-3">
                                    <div class="h3 font-weight-normal">License</div>
                                </div>
                               <vue-good-table
                              :columns="licenseColumns"
                              :rows=licenseRows()
                              :search-options="{
                                enabled: true,
                              }"
                              :pagination-options="{
                                enabled: true,
                                perPage: 10,
                              }"
                              :lineNumbers="false"
                              styleClass="vgt-table condensed custom-table table table-corpus-mid table-striped" />
                            </div>



                            <div role="tabpanel" class="tab-pane active" id="preparations" v-if=" this.preparationRows().length > 0">
                                <div class="d-flex justify-content-between mt-7 mb-3">
                                    <div class="h3 font-weight-normal">Preparation steps</div>
                                </div>
                               <vue-good-table
                              :columns="preparationColumns"
                              :rows=preparationRows()
                              :search-options="{
                                enabled: true,
                              }"
                              :pagination-options="{
                                enabled: true,
                                perPage: 10,
                              }"
                              :lineNumbers="false"
                              styleClass="vgt-table condensed custom-table table table-corpus-mid table-striped" />
                            </div>
                        </div>

                    </div>
                </div>
              </div>
        </div>


        <div role="tabpanel"  class="tab-pane mainpanel fade" id="annotationDocumentBody">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div id="tabcontainer" class="container-fluid tab-content content">
                            <div role="tabpanel"  class="tab-pane active" id="tei-header" v-if="header == 'annotation'">
                                <div class="d-flex justify-content-between mt-7 mb-3">
                                    <div class="h3 font-weight-normal">Documents</div>
                                </div>

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
                          styleClass="vgt-table condensed custom-table documents-table table table-corpus-mid  table-striped">
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
        </div>
        <div class="verticalBadge text-uppercase font-weight-bold bg-blueadmin text-14 text-white rounded bsh-1" v-show="isloggedin">
          <span>
            WORKING VERSION
          </span>
        </div>
     </div>
    </div>
</template>

<script>
    export default {
        props: ['headerdata','header','user','isloggedin'],
        data: function(){
            return {
                annotators: [],
                revisions: [],
                documentsByAnnotation: [],
                guidelineColumnsGeneric: [
                    {
                        label: 'Annotation value',
                        field: 'value',
                        filterable: true,
                    },
                    {
                        label: 'Description',
                        field: 'description',
                        filterable: true,
                    }
                ],
                guidelineColumns: [
                    {
                        label: 'Annotation value',
                        field: 'value',
                        filterable: true,
                    },
                    {
                        label: 'Description',
                        field: 'description',
                        filterable: true,
                    }
                ],
                personColumns: [
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
                licenseColumns: [
                    {
                        label: 'Date',
                        field: 'date',
                        filterable: true
                    },
                    {
                        label: 'Release type',
                        field: 'type',
                        filterable: true
                    },
                    {
                        label: 'License description',
                        field: 'license_description',
                        filterable: true
                    }
                ],
                preparationColumns: [
                    {
                        label: 'Encoding step',
                        field: 'step',
                        filterable: true
                    },
                    {
                        label: 'Model',
                        field: 'model',
                        filterable: true
                    },
                    {
                        label: 'Tool',
                        field: 'tool',
                        filterable: true
                    },
                    {
                        label: 'Version',
                        field: 'version',
                        filterable: true
                    },
                    {
                        label: 'Name',
                        field: 'name',
                        filterable: true
                    },
                    {
                        label: 'Description',
                        field: 'description',
                        filterable: true
                    },
                    {
                        label: 'Extension',
                        field: 'extension',
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
                    }
                ]
            }
        },
        methods: {
            guidelineRows: function(format){
                var guidelineArray = [];
                var annotationTitle = this.headerdata.preparation_title[0];
                if(null != this.headerdata.guidelines && typeof this.headerdata.guidelines != 'undefined'){
                    Object.keys(this.headerdata.guidelines).forEach(function(formatKey, formatIndex) {
                        var annotationData = this[formatKey];
                        if(typeof this[formatKey]['annotations'] != 'undefined'){
                            if(format == formatKey && Object.keys(this[formatKey]['annotations']).length > 0){
                                if(null != this[formatKey]['annotations'][annotationTitle] &&
                                typeof this[formatKey]['annotations'][annotationTitle] != 'undefined'){
                                    Object.keys(this[formatKey]['annotations'][annotationTitle]).forEach(function (guidelineKey, guidelineIndex) {
                                        var valueObject = {}
                                        valueObject.title = annotationTitle;
                                        valueObject.value = guidelineKey;
                                        valueObject.description = annotationData['annotations'][annotationTitle][guidelineKey]

                                        guidelineArray.push(valueObject);
                                    }, this[formatKey]['annotations']);
                                }
                            }
                        }

                    }, this.headerdata.guidelines);
                }
                return guidelineArray;
            },
            allGuidelineRows: function(){
                var guidelineArray = [];
                var annotationTitle = this.headerdata.preparation_title[0];
                var foundGuidelines = [];

                if(null != this.headerdata.guidelines && typeof this.headerdata.guidelines != 'undefined'){
                    Object.keys(this.headerdata.guidelines).forEach(function(formatKey, formatIndex) {
                        var annotationData = this[formatKey];
                        if(null != this[formatKey]['annotations'] &&
                            typeof this[formatKey]['annotations'] != 'undefined' &&
                            Object.keys(this[formatKey]['annotations']).length > 0){
                            if(null != this[formatKey]['annotations'][annotationTitle] &&
                            typeof this[formatKey]['annotations'][annotationTitle] != 'undefined'){
                                Object.keys(this[formatKey]['annotations'][annotationTitle]).forEach(function (guidelineKey, guidelineIndex) {
                                    var valueObject = {}
                                    valueObject.title = annotationTitle;
                                    valueObject.value = guidelineKey;
                                    valueObject.description = annotationData['annotations'][annotationTitle][guidelineKey]

                                    if(!foundGuidelines.includes(guidelineKey)){
                                        guidelineArray.push(valueObject);
                                        foundGuidelines.push(guidelineKey);
                                    }


                                }, this[formatKey]['annotations']);
                            }
                        }

                    }, this.headerdata.guidelines);
                }

                return guidelineArray;
            },
            editorRows: function(){
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
            annotatorRows: function(){
                var annotatorArray = [];
                var theHeaderData = this.headerdata;
                if( typeof theHeaderData.preparation_author_annotator_forename != 'undefined' &&
                    typeof theHeaderData.preparation_author_annotator_surname != 'undefined' &&
                    typeof theHeaderData.preparation_author_annotator_affiliation_department != 'undefined' &&
                    typeof theHeaderData.preparation_author_annotator_affiliation_institution != 'undefined' &&
                    this.hasSameLength([
                        theHeaderData.preparation_author_annotator_forename,
                        theHeaderData.preparation_author_annotator_surname,
                        theHeaderData.preparation_author_annotator_affiliation_department,
                        theHeaderData.preparation_author_annotator_affiliation_institution
                    ])
                ){
                    for(var i = 0; i < theHeaderData.preparation_author_annotator_forename.length;i++){
                        var personObject = {}
                        personObject.name = theHeaderData.preparation_author_annotator_forename[i]+" "+theHeaderData.preparation_author_annotator_surname[i];
                        personObject.affiliation = theHeaderData.preparation_author_annotator_affiliation_department[i]+", "+theHeaderData.preparation_author_annotator_affiliation_institution[i]
                        annotatorArray.push(personObject);
                    }
                }

                return annotatorArray;
            },
            infrastructureRows: function(){
                var infrastructureArray = [];
                var theHeaderData = this.headerdata;
                if( typeof theHeaderData.preparation_author_infrastructure_forename != 'undefined' &&
                    typeof theHeaderData.preparation_author_infrastructure_surname != 'undefined' &&
                    typeof theHeaderData.preparation_author_infrastructure_affiliation_department != 'undefined' &&
                    typeof theHeaderData.preparation_author_infrastructure_affiliation_institution != 'undefined' &&
                    this.hasSameLength([
                        theHeaderData.preparation_author_infrastructure_forename,
                        theHeaderData.preparation_author_infrastructure_surname,
                        theHeaderData.preparation_author_infrastructure_affiliation_department,
                        theHeaderData.preparation_author_infrastructure_affiliation_institution
                    ])
                ){
                    for(var i = 0; i < theHeaderData.preparation_author_infrastructure_forename.length;i++){
                        var personObject = {}
                        personObject.name = theHeaderData.preparation_author_infrastructure_forename[i]+" "+theHeaderData.preparation_author_infrastructure_surname[i];
                        personObject.affiliation = theHeaderData.preparation_author_infrastructure_affiliation_department[i]+", "+theHeaderData.preparation_author_infrastructure_affiliation_institution[i]
                        infrastructureArray.push(personObject);
                    }
                }

                return infrastructureArray;
            },
            transcriptionRows: function(){
                var transcriptionArray = [];
                var theHeaderData = this.headerdata;
                if( typeof theHeaderData.preparation_author_transcription_forename != 'undefined' &&
                    typeof theHeaderData.preparation_author_transcription_surname != 'undefined' &&
                    typeof theHeaderData.preparation_author_transcription_affiliation_department != 'undefined' &&
                    typeof theHeaderData.preparation_author_transcription_affilitation_institution != 'undefined' &&
                    this.hasSameLength([
                        theHeaderData.preparation_author_transcription_forename,
                        theHeaderData.preparation_author_transcription_surname,
                        theHeaderData.preparation_author_transcription_affiliation_department,
                        theHeaderData.preparation_author_transcription_affiliation_department
                    ])
                ){
                    for(var i = 0; i < theHeaderData.preparation_author_transcription_forename.length;i++){
                        var personObject = {}
                        personObject.name = theHeaderData.preparation_author_transcription_forename[i]+" "+theHeaderData.preparation_author_transcription_surname[i];
                        personObject.affiliation = theHeaderData.preparation_author_transcription_affiliation_department[i]+", "+theHeaderData.preparation_author_transcription_affilitation_institution[i]
                        transcriptionArray.push(personObject);
                    }
                }

                return transcriptionArray;
            },
            versionRows: function(){
                var versionArray = [];
                var theHeaderData = this.headerdata;
                if( typeof theHeaderData.preparation_revision_corpus_version != 'undefined' &&
                    typeof theHeaderData.preparation_revision_description != 'undefined' &&
                    typeof theHeaderData.preparation_revision_publishing_date != 'undefined' &&
                    this.hasSameLength([theHeaderData.preparation_revision_corpus_version,theHeaderData.preparation_revision_description,theHeaderData.preparation_revision_publishing_date])
                ){
                    for(var i = 0; i < theHeaderData.preparation_revision_corpus_version.length;i++){
                        var versionObject = {}
                        versionObject.revision = theHeaderData.preparation_revision_corpus_version[i];
                        versionObject.date = theHeaderData.preparation_revision_publishing_date[i];
                        versionObject.description = theHeaderData.preparation_revision_description[i];
                        versionArray.push(versionObject);
                    }
                }

                return versionArray;
            },
            licenseRows: function(){
                var licenseArray = [];
                var theHeaderData = this.headerdata;
                if( typeof theHeaderData.preparation_publication_release_date != 'undefined' &&
                    typeof theHeaderData.preparation_publication_release_type != 'undefined' &&
                    typeof theHeaderData.preparation_publication_license_description != 'undefined' &&
                    this.hasSameLength([
                        theHeaderData.preparation_publication_release_date,
                        theHeaderData.preparation_publication_release_type,
                        theHeaderData.preparation_publication_license_description
                    ])
                ){
                    for(var i = 0; i < theHeaderData.preparation_publication_release_date.length;i++){
                        var licenseObject = {}
                        licenseObject.date = theHeaderData.preparation_publication_release_date[i];
                        licenseObject.type = theHeaderData.preparation_publication_release_type[i];
                        licenseObject.license_description  = theHeaderData.preparation_publication_license_description[i];
                        licenseArray.push(licenseObject);
                    }
                }

                return licenseArray;
            },
            preparationRows: function(){
                var preparationArray = [];
                var theHeaderData = this.headerdata;
                if( typeof theHeaderData.preparation_encoding_step != 'undefined' &&
                    typeof theHeaderData.preparation_encoding_models != 'undefined' &&
                    typeof theHeaderData.preparation_encoding_tool != 'undefined' &&
                    typeof theHeaderData.preparation_encoding_full_name != 'undefined' &&
                    typeof theHeaderData.preparation_encoding_description != 'undefined' &&
                    typeof theHeaderData.preparation_encoding_file_extension != 'undefined' &&
                    typeof theHeaderData.preparation_encoding_tool_version != 'undefined' &&
                    typeof theHeaderData.preparation_encoding_annotation_group != 'undefined' &&
                    typeof theHeaderData.preparation_encoding_annotation_sub_group != 'undefined' &&
                    this.hasSameLength([
                        theHeaderData.preparation_encoding_step,
                        theHeaderData.preparation_encoding_models,
                        theHeaderData.preparation_encoding_tool,
                        theHeaderData.preparation_encoding_full_name,
                        theHeaderData.preparation_encoding_description,
                        theHeaderData.preparation_encoding_file_extension,
                        theHeaderData.preparation_encoding_tool_version,
                        theHeaderData.preparation_encoding_annotation_group,
                        theHeaderData.preparation_encoding_annotation_sub_group
                    ])
                ){
                    for(var i = 0; i < theHeaderData.preparation_encoding_step.length;i++){
                        var preparationObject = {}
                        preparationObject.step = theHeaderData.preparation_encoding_step[i];
                        preparationObject.model  = theHeaderData.preparation_encoding_models[i];
                        preparationObject.tool  = theHeaderData.preparation_encoding_tool[i];
                        preparationObject.version  = theHeaderData.preparation_encoding_tool_version[i];
                        preparationObject.name  = theHeaderData.preparation_encoding_full_name[i];
                        preparationObject.description  = theHeaderData.preparation_encoding_description[i];
                        preparationObject.extension  = theHeaderData.preparation_encoding_file_extension[i];
                        preparationObject.group  = theHeaderData.preparation_encoding_annotation_group[i];
                        preparationObject.subgroup  = theHeaderData.preparation_encoding_annotation_sub_group[i];
                        preparationArray.push(preparationObject);
                    }
                }

                return preparationArray;
            },
            documentRows: function(){
              var documentArray = [];
              var theHeaderData = this.headerdata;
                if( typeof theHeaderData.documents != 'undefined' &&
                    theHeaderData.documents.length > 0){

                    for(var i = 0; i < theHeaderData.documents.length; i++) {
                        var documentObject = {}
                        documentObject.title = theHeaderData.documents[i].document_title[0];
                        documentObject.tokens = parseInt(theHeaderData.documents[i].document_size_extent[0].replace('.',''),10);
                        documentObject.date = theHeaderData.documents[i].document_publication_publishing_date[0];
                        documentObject.place = theHeaderData.documents[i].document_history_original_place[0];
                        documentObject.annotations = theHeaderData.documents[i].document_list_of_annotations_id.length;
                        documentObject.document_id = theHeaderData.documents[i].document_indexid;
                        documentArray.push(documentObject);
                    }

                }
              return documentArray;
            },
            goToDocument:function(params) {
                document.location = "/browse/document/"+params.row.document_id
                return params.pageIndex;

            },
            hasSameLength: function(attributes) {
                var hasSameLength = false;
                var lastLength = 0;
                for(var i = 0; i < attributes.length; i++) {
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
                return hasSameLength;
            }


        },
        computed: {

        },
        mounted() {
            console.log('AnnotationMetadataBlockBody mounted.')
        }
    }
</script>