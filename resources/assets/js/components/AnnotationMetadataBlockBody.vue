<template lang="html">
    <div class="headerRow headerNav">
        <div class="bodyColumn left">

        </div>
        <div class="bodyColumn middle">
            <!-- start guidelines -->
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
                                  :rows=guidelineRows(guidelinekey)
                                  :paginate="true"
                                  :lineNumbers="false"
                                  styleClass="table table-striped"/>
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
                <!-- end guidelines -->
                <!-- start preparation steps -->
                <div class="tab-pane fade" id="preparationsteps">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="sidebar-nav">
                                <div class="navbar-collapse collapse sidebar-navbar-collapse">
                                  <ul class="nav nav-stacked">
                                    <li class="nav-link" role="tab">
                                        <a href="#" data-toggle="collapse" data-target="#authorship">AUTHORSHIP</a>
                                        <ul class="nav nav-stacked collapsed" id="authorship">
                                            <li role="tab" class="nav-link active"><a href="#editors" data-toggle="pill" v-if="this.annotatorRows().length > 0">EDITORS</a></li>
                                            <li role="tab" class="nav-link"><a href="#annotators" data-toggle="pill" v-if="this.annotatorRows().length > 0">ANNOTATORS</a></li>
                                            <li role="tab" class="nav-link"><a href="#transcription" data-toggle="pill" v-if="this.transcriptionRows().length > 0">TRANSCRIPTION</a></li>
                                            <li role="tab" class="nav-link" v-if="this.infrastructureRows().length > 0"><a href="#infrastructure" data-toggle="pill">INFRASTRUCTURE</a></li>
                                        </ul>
                                    </li>
                                    <li role="tab" class="nav-link" v-if="this.versionRows().length > 0"><a href="#versions" data-toggle="pill">VERSIONS</a></li>
                                    <li role="tab" class="nav-link" v-if="this.licenseRows().length > 0"><a href="#license" data-toggle="pill">LICENSE/SOURCE</a></li>
                                    <li role="tab" class="nav-link"><a href="#preparation" data-toggle="pill">PREPARATION</a></li>
                                  </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="editors" v-if="header == 'annotation' && this.editorRows().length > 0">
                                    <h2>EDITORS</h2>
                                    <vue-good-table
                                      title=""
                                      :columns="personColumns"
                                      :rows=editorRows()
                                      :paginate="true"
                                      :lineNumbers="false"
                                      styleClass="table table-striped"/>
                                </div>

                                <div class="tab-pane fade" id="annotators" v-if="header == 'annotation' && this.annotatorRows().length > 0">
                                    <h2>ANNOTATORS</h2>
                                    <vue-good-table
                                      title=""
                                      :columns="personColumns"
                                      :rows=annotatorRows()
                                      :paginate="true"
                                      :lineNumbers="false"
                                      styleClass="table table-striped"/>
                                </div>

                                <div class="tab-pane fade" id="transcription" v-if="header == 'annotation' && this.transcriptionRows().length > 0">
                                    <h2>TRANSCRIPTION</h2>
                                     <vue-good-table
                                      title=""
                                      :columns="personColumns"
                                      :rows=transcriptionRows()
                                      :paginate="true"
                                      :lineNumbers="false"
                                      styleClass="table table-striped"/>
                                </div>

                                <div class="tab-pane fade" id="infrastructure" v-if="header == 'annotation' && this.infrastructureRows().length > 0">
                                    <h2>INFRASTRUCTURE</h2>
                                    <vue-good-table
                                      title=""
                                      :columns="personColumns"
                                      :rows=infrastructureRows()
                                      :paginate="true"
                                      :lineNumbers="false"
                                      styleClass="table table-striped"/>
                                </div>

                                <div class="tab-pane fade" id="versions" v-if="header == 'annotation' && this.versionRows().length > 0">
                                    <h2>VERSIONS</h2>
                                    <vue-good-table
                                      title=""
                                      :columns="versionColumns"
                                      :rows=versionRows()
                                      :paginate="true"
                                      :lineNumbers="false"
                                      styleClass="table table-striped"/>
                                </div>

                                <div class="tab-pane fade" id="license" v-if="header == 'annotation' && this.licenseRows().length > 0">
                                    <h2>LICENSE/SOURCE</h2>
                                    <vue-good-table
                                      title=""
                                      :columns="licenseColumns"
                                      :rows=licenseRows()
                                      :paginate="true"
                                      :lineNumbers="false"
                                      styleClass="table table-striped"/>
                                </div>

                                <div class="tab-pane fade" id="preparation" v-if="header == 'annotation'">
                                    <h2>PREPARATION</h2>
                                    <vue-good-table
                                      title=""
                                      :columns="preparationColumns"
                                      :rows=preparationRows()
                                      :paginate="true"
                                      :lineNumbers="false"
                                      styleClass="table table-striped"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end preparationsteps -->
                <!-- start documents -->
                <div class="tab-pane fade" id="documents">
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="tab-content">
                                <h2>DOCUMENTS</h2>
                                    <vue-good-table
                                      title=""
                                      :columns="documentColumns"
                                      :rows=documentRows()
                                      :paginate="true"
                                      :lineNumbers="false"
                                      :onClick="goToDocument"
                                      styleClass="table table-striped"/>
                            </div>
                         </div>
                    </div>
                </div>
                <!-- end docuemnts -->
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
                        label: '#',
                        field: 'stepnumber',
                        filterable: true
                    },
                    {
                        label: 'Encoding step',
                        field: 'step',
                        filterable: true
                    },
                    {
                        label: 'Encoding model',
                        field: 'model',
                        filterable: true
                    },
                    {
                        label: 'Encoding tool',
                        field: 'tool',
                        filterable: true
                    },
                    {
                        label: 'Version',
                        field: 'version',
                        filterable: true
                    },
                    {
                        label: 'Encoding name',
                        field: 'name',
                        filterable: true
                    },
                    {
                        label: 'Encoding description',
                        field: 'description',
                        filterable: true
                    },
                    {
                        label: 'File extension',
                        field: 'extension',
                        filterable: true
                    },
                    {
                        label: 'Annotation group',
                        field: 'group',
                        filterable: true
                    },
                    {
                        label: 'Annotation sub group',
                        field: 'subgroup',
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
                    typeof theHeaderData.preparation_encoding_step_number != 'undefined' &&
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
                        theHeaderData.preparation_encoding_step_number,
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
                        preparationObject.stepnumber = theHeaderData.preparation_encoding_step_number[i];
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
                        documentObject.tokens = theHeaderData.documents[i].document_size_extent[0];
                        documentObject.date = theHeaderData.documents[i].document_publication_publishing_date[0];
                        documentObject.place = theHeaderData.documents[i].document_history_original_place[0];
                        documentObject.annotations = theHeaderData.documents[i].document_list_of_annotations_id.length;
                        documentObject.document_id = theHeaderData.in_documents[i];
                        documentArray.push(documentObject);
                    }

                }
              return documentArray;
            },
            goToDocument: function(row, index) {
                console.log("ROW: "+JSON.stringify(row)); //the object for the row that was clicked on
                console.log("INDIX: "+index); // index of the row that was clicked on
                document.location = "/browse/document/"+row.document_id
                return index;

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
            console.log('DocumentMetadataBlockBody mounted.')
        }
    }
</script>