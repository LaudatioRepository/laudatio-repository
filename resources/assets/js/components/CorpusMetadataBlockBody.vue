<template lang="html">
   <div class="container-fluid tab-content content">
        <div role="tabpanel"  class="tab-pane active" id="corpusMetadataBody">
        <div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-2">
                <nav class="headernav sidebar text-14 nav flex-column border-top border-light mt-7" role="tablist">
                    <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link tablink active" data-toggle="tab" role="tab" data-headertype="corpus" href="#corpusDescription">DESCRIPTION</a>
                    <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link tablink collapsed"  href="#" data-toggle="collapse" data-target="#authorship" aria-expanded="false">AUTHORSHIP</a>
                    <ul class="nav nav-stacked collapse" id="authorship">
                            <li role="tab" class="nav-link"><a href="#editors" data-toggle="pill" v-if="this.corpusEditorRows().length > 0">CORPUS EDITORS</a></li>
                            <li role="tab" class="nav-link"><a href="#annotators" data-toggle="pill" v-if="this.corpusAnnotatorRows().length > 0">ANNOTATORS</a></li>
                            <li role="tab" class="nav-link"><a href="#transcription" data-toggle="pill" v-if="this.corpusTranscriptionRows().length > 0">TRANSCRIPTION</a></li>
                            <li role="tab" class="nav-link" v-if="this.corpusInfrastructureRows().length > 0"><a href="#infrastructure" data-toggle="pill">INFRASTRUCTURE</a></li>
                          </ul>
                    <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link tablink" data-toggle="tab" role="tab" data-headertype="annotation" href="#corpusVersions">VERSIONS</a>
                    <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link tablink" data-toggle="tab" role="tab" data-headertype="formatdata" href="#corpusLicense">LICENSE / REVISION</a>
                    <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link tablink" data-toggle="tab" role="tab" data-headertype="license" href="#corpusFormats">FORMATS</a>
                </nav>
            </div>
            <div class="col">
                <div id="tabcontainer" class="container-fluid tab-content content">


                    <div role="tabpanel"  class="tab-pane active" id="corpusDescription" v-if="header == 'corpus'">
                        <h2> CORPUS DESCRIPTION</h2>
                        <div class="panel-body">{{headerdata.corpus_encoding_project_description | lastElement}}</div>
                    </div>

                    <div role="tabpanel"  class="tab-pane fade in" id="corpusAuthorship">
                        docu
                    </div>

                    <div role="tabpanel"  class="tab-pane fade in" id="corpusVersions">
                        anno
                    </div>

                    <div role="tabpanel"  class="tab-pane fade in" id="corpusLicense">

                    </div>

                    <div role="tabpanel"  class="tab-pane fade in" id="corpusFormats">

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
        </div>





        <div role="tabpanel"  class="tab-pane fade in" id="documentMetadataBody" v-if="header == 'corpus'">documentMetadataBody</div>
        <div role="tabpanel"  class="tab-pane fade in" id="annotationMetadataBody" v-if="header == 'corpus'">annotationMetadataBody</div>
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