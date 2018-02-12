<template lang="html">
<div class="container tab-content">
    <div class="tab-pane fade in active" id="corpusMetadataBody">
        <div class="row">
          <div class="col-sm-3">
            <div class="sidebar-nav">
                <div class="navbar-collapse collapse sidebar-navbar-collapse">
                  <ul class="nav nav-stacked">
                      <li role="tab" class="nav-link active"><a href="#description" data-toggle="pill">DESCRIPTION</a></li>
                      <li role="tab" class="nav-link"><a href="#authorship" data-toggle="pill">AUTHORSHIP</a></li>
                      <li role="tab" class="nav-link"><a href="#versions" data-toggle="pill">VERSIONS</a></li>
                      <li role="tab" class="nav-link"><a href="#license" data-toggle="pill">LICENSE / REVISION</a></li>
                      <li role="tab" class="nav-link"><a href="#formats" data-toggle="pill">FORMATS</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-sm-9">
            <div class="tab-content" v-if="header == 'corpus'">
                <div id="description" class="tab-pane fade in active">
                <div class="panel-body">{{headerdata.corpus_encoding_project_description | lastElement}}</div>
                </div>
                <div id="authorship" class="tab-pane fade">
                    <ul class="list-group">
                        <li v-for="annotator in getAnnotators"  v-bind:annotator="annotator" :key="annotator" class="list-group-item"><i class="fa fa-user" aria-hidden="true"></i> {{annotator}}</li>
                    </ul>
                </div>
                <div id="versions" class="tab-pane fade">
                    <ul class="list-group">
                        <li v-for="revision in getRevisions" v-bind:revision="revision" :key="revision" class="list-group-item">
                        <i class="fa fa-code-fork" aria-hidden="true"></i> {{revision.date.concat(' ').concat(revision.version).concat(' ').concat(revision.description)}}
                        </li>
                    </ul>
                </div>
                <div id="license" class="tab-pane fade">
                    <ul class="list-group">
                        <li v-for="(annotation, index) in headerdata.annotation_name" v-bind:annotation="annotation" :key="annotation" class="list-group-item">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{annotation}} ({{headerdata.annotation_type[index]}}) {{getDocumentsByAnnotation}} <span class="badge" v-if="typeof documentsByAnnotation[0] != 'undefined'">{{documentsByAnnotation[0][annotation]}}</span>
                        </li>
                    </ul>
                </div>
                <div id="formats" class="tab-pane fade">
                    <ul class="list-group">
                        <li v-for="(annotation, index) in headerdata.annotation_name" v-bind:annotation="annotation" :key="annotation" class="list-group-item">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{annotation}} ({{headerdata.annotation_type[index]}}) {{getDocumentsByAnnotation}} <span class="badge" v-if="typeof documentsByAnnotation[0] != 'undefined'">{{documentsByAnnotation[0][annotation]}}</span>
                        </li>
                    </ul>
                </div>
            </div>
          </div>
        </div>
    </div>
    <div class="tab-pane fade" id="documentMetadataBody">
        Documents
    </div>
    <div class="tab-pane fade" id="annotationMetadataBody">
        Annotations
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
                documentsByAnnotation: []
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
          getRevisions: function(){
              if(typeof this.headerdata != 'undefined' && this.headerdata.corpus_version.length > 0
                    && this.headerdata.corpus_version_publishing_date.length > 0
                    && this.headerdata.corpus_version_description.length > 0
                    && this.headerdata.corpus_version.length
                    == this.headerdata.corpus_version_description.length
                    && this.headerdata.corpus_version.length
                    == this.headerdata.corpus_version_publishing_date.length){
                    for(var j = 0; j < this.headerdata.corpus_version.length; j++) {
                        let revisiondata = {};
                        revisiondata['date'] = this.headerdata.corpus_version_publishing_date[j];
                        revisiondata['version'] = this.headerdata.corpus_version[j];
                        revisiondata['description'] = this.headerdata.corpus_version_description[j];
                        this.revisions.push(revisiondata);
                    }
              }
              return this.revisions.reverse()
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
                  console.log("postAnnotationData: "+postAnnotationData)
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