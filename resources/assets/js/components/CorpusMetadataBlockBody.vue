<template lang="html">
<div class="container tab-content">
    <div class="tab-pane fade in active" id="corpusMetadataBody">
        <div class="row">
          <div class="col-sm-3">
            <div class="sidebar-nav">
                <div class="navbar-collapse collapse sidebar-navbar-collapse">
                  <ul class="nav nav-stacked">
                      <li role="tab" class="nav-link active"><a href="#description" data-toggle="pill">DESCRIPTION</a></li>
                      <li role="tab" class="nav-link">
                          <a href="#" data-toggle="collapse" data-target="#authorship" aria-expanded="false" class="collapsed">AUTHORSHIP &gt;&gt;</a>
                          <ul class="nav nav-stacked collapse" id="authorship">
                            <li role="tab" class="nav-link"><a href="#editors" data-toggle="pill" v-if="this.corpusEditorRows().length > 0">CORPUS EDITORS</a></li>
                            <li role="tab" class="nav-link"><a href="#annotators" data-toggle="pill" v-if="this.corpusAnnotatorRows().length > 0">ANNOTATORS</a></li>
                            <li role="tab" class="nav-link"><a href="#transcription" data-toggle="pill" v-if="this.corpusTranscriptionRows().length > 0">TRANSCRIPTION</a></li>
                            <li role="tab" class="nav-link" v-if="this.corpusInfrastructureRows().length > 0"><a href="#infrastructure" data-toggle="pill">INFRASTRUCTURE</a></li>
                          </ul>
                      </li>
                      <li role="tab" class="nav-link"><a href="#versions" data-toggle="pill">VERSIONS</a></li>
                      <li role="tab" class="nav-link"><a href="#license" data-toggle="pill">LICENSE / REVISION</a></li>
                      <li role="tab" class="nav-link"><a href="#formats" data-toggle="pill">FORMATS</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-sm-9">
             <div class="tab-content">
                <div id="description" class="tab-pane fade in active" v-if="header == 'corpus'">
                    <h2> CORPUS DESCRIPTION</h2>
                    <div class="panel-body">{{headerdata.corpus_encoding_project_description | lastElement}}</div>
                </div>
                <div class="tab-pane fade" id="editors" v-if="header == 'corpus' && this.corpusEditorRows().length > 0">
                    <h2> CORPUS EDITORS</h2>
                    <vue-good-table
                      title=""
                      :columns="authorshipColumns"
                      :rows=corpusEditorRows()
                      :paginate="true"
                      :lineNumbers="false"
                      styleClass="table table-striped"/>
                </div>

                <div class="tab-pane fade" id="annotators" v-if="header == 'corpus' && this.corpusAnnotatorRows().length > 0">
                    <h2>ANNOTATORS</h2>
                    <vue-good-table
                      title=""
                      :columns="authorshipColumns"
                      :rows=corpusAnnotatorRows()
                      :paginate="true"
                      :lineNumbers="false"
                      styleClass="table table-striped"/>
                </div>

                <div class="tab-pane fade" id="transcription" v-if="header == 'corpus' && this.corpusTranscriptionRows().length > 0">
                    <h2>TRANSCRIPTION</h2>
                    <vue-good-table
                      title=""
                      :columns="authorshipColumns"
                      :rows=corpusTranscriptionRows()
                      :paginate="true"
                      :lineNumbers="false"
                      styleClass="table table-striped"/>
                </div>

                <div class="tab-pane fade" id="infrastructure" v-if="header == 'corpus' && this.corpusInfrastructureRows().length > 0">
                    <h2>INFRASTRUCTURE</h2>
                    <vue-good-table
                      title=""
                      :columns="authorshipColumns"
                      :rows=corpusInfrastructureRows()
                      :paginate="true"
                      :lineNumbers="false"
                      styleClass="table table-striped"/>
                </div>
                <div id="versions" class="tab-pane fade" v-if="header == 'corpus'">getRevisions
                    <h2>VERSIONS</h2>
                    <vue-good-table
                      title=""
                      :columns="versionColumns"
                      :rows=getRevisions()
                      :paginate="true"
                      :lineNumbers="false"
                      styleClass="table table-striped"/>
                </div>
                <div id="license" class="tab-pane fade" v-if="header == 'corpus'">
                   {{headerdata.corpus_publication_license_description  | arrayToString }}
                </div>
                <div id="formats" class="tab-pane fade" v-if="header == 'corpus'">
                    <vue-good-table
                      title=""
                      :columns="formatColumns"
                      :rows=getFormats()
                      :paginate="true"
                      :lineNumbers="false"
                      styleClass="table table-striped"/>
                </div>
            </div>
          </div>
        </div>
    </div>
    <div class="tab-pane fade" id="documentMetadataBody" v-if="header == 'corpus'">
        <h2>DOCUMENTS</h2>
        <vue-good-table
          title=""
          :columns="documentColumns"
          :rows=documentRows()
          :paginate="true"
          :lineNumbers="false"
          :onClick="goToDocument        "
          styleClass="table table-striped"/>
    </div>
    <div class="tab-pane fade" id="annotationMetadataBody">
        <h2>ANNOTATIONS</h2>
        <div class="row">
              <div class="col-sm-3">

                <div class="sidebar-nav">
                    <div class="navbar-collapse collapse sidebar-navbar-collapse">
                      <ul class="nav nav-stacked">
                        <li class="nav-link active" role="tab">
                            <a href="#allAnnotations" data-toggle="pill">All ({{headerdata.corpusannotationcount}})</a>
                        </li>
                        <li v-for="(annotationGroup) in headerdata.allAnnotationGroups" class="nav-link" role="tab">
                            <a v-bind:href="('#').concat(annotationGroup)" data-toggle="pill" v-if="groupCount(annotationGroup) > 0 ">{{annotationGroup | touppercase}} ({{groupCount(annotationGroup)}})</a>
                            <a href="#" data-toggle="pill" v-else class="disabledLink">{{annotationGroup | touppercase}}</a>
                        </li>


                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-sm-9">
               <div class="tab-content">
                   <div class="tab-pane fade in active" id="allAnnotations" v-if="header == 'corpus'">
                     <h2>Annotations - All ({{headerdata.corpusannotationcount}})</h2>
                        <vue-good-table
                                  title=""
                                  :columns="annotationColumns"
                                  :rows=annotationRows()
                                  :paginate="true"
                                  :lineNumbers="false"
                                  :onClick="goToAnnotation"
                                  styleClass="table table-striped"/>

                    </div>
                    <div class="tab-pane fade" v-for="(annotationGroup) in headerdata.allAnnotationGroups" :id="annotationGroup" v-if="header == 'corpus'">
                        <h2>{{annotationGroup}}  ({{groupCount(annotationGroup)}})</h2>
                        <vue-good-table
                          title=""
                          :columns="annotationColumns"
                          :rows=annotationRows(annotationGroup)
                          :paginate="true"
                          :lineNumbers="false"
                          :onClick="goToAnnotation"
                          styleClass="table table-striped"/>
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
                ],
                annotationColumns: [
                    {
                        label: 'Annotation title',
                        field: 'title',
                        filterable: true,
                    },
                    {
                        label: 'Category',
                        field: 'group',
                        filterable: true,
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
                        theHeaderData.corpus_transcription_surname,
                        theHeaderData.corpus_transcription_affiliation_department,
                        theHeaderData.corpus_transcription_affiliation_department
                    ])
                ){
                    for(var i = 0; i < theHeaderData.corpus_author_transcription_forename.length;i++){
                        var personObject = {}
                        personObject.name = theHeaderData.corpus_author_transcription_forename[i]+" "+theHeaderData.corpus_transcription_surname[i];
                        personObject.affiliation = theHeaderData.corpus_transcription_affiliation_department[i]+", "+theHeaderData.corpus_transcription_affiliation_department[i]
                        transcriptionArray.push(personObject);
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
                        documentObject.tokens = theHeaderData.corpusdocuments[i].document_size_extent[0];
                        documentObject.date = theHeaderData.corpusdocuments[i].document_publication_publishing_date[0];
                        documentObject.place = theHeaderData.corpusdocuments[i].document_publication_place[0];
                        documentObject.annotations = theHeaderData.corpusdocuments[i].document_list_of_annotations_name.length;
                        documentObject.document_id = theHeaderData.corpusdocuments[i].document_id;
                        documentArray.push(documentObject);
                    }

                }
                return documentArray;
            },
            annotationRows2: function(){
                var annotationArray = [];
                var foundAnnotationArray = [];
                var theHeaderData = this.headerdata;
                if(null != this.headerdata.corpusAnnotationGroups && typeof this.headerdata.corpusAnnotationGroups != 'undefined'){
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
                //allAnnotationGroups
                var annotationArray = [];
                var foundAnnotationArray = [];
                var theHeaderData = this.headerdata;
                if(null != theHeaderData.allAnnotationGroups && null != theHeaderData.corpusAnnotationGroups && typeof theHeaderData.corpusAnnotationGroups != 'undefined'){
                    for(var i = 0; i < theHeaderData.allAnnotationGroups.length; i++){

                    }

                    Object.keys(this.headerdata.corpusAnnotationGroups).forEach(function(key, index) {
                        if(key == currentkey) {
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
                        }

                    }, this.headerdata.corpusAnnotationGroups);
                }

                return annotationArray;
            },
            groupCount: function(key) {
                var data = this.headerdata.corpusAnnotationGroups;
                if(typeof data[key] != 'undefined') {
                    return data[key].length;
                }
            },
            goToDocument: function(row, index) {
                document.location = "/browse/document/"+row.document_id
                return index;

            },
            goToAnnotation: function(row, index) {
                document.location = "/browse/annotation/"+row.preparation_annotation_id
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