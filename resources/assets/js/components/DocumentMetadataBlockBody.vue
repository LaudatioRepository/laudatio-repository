<template lang="html">
    <div class="container tab-content">
        <div class="tab-pane fade in active" id="documentMetadata">
            <div class="row">
              <div class="col-sm-3">
                <div class="sidebar-nav">
                    <div class="navbar-collapse collapse sidebar-navbar-collapse">
                      <ul class="nav nav-stacked">
                          <li role="tab" class="nav-link active"><a href="#description" data-toggle="pill">DESCRIPTION</a></li>
                          <li role="tab" class="nav-link"><a href="#sourcedescription" data-toggle="pill">SOURCE DESCRIPTION</a></li>
                          <li role="tab" class="nav-link"><a href="#license" data-toggle="pill">LICENSE / REVISION</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-sm-9">
                <div class="tab-content" v-if="header == 'document'">
                    <div class="tab-pane fade in active" id="description">
                        <h2>DESCRIPTION</h2>
                        <table class="table table-condensed">
                            <tr>
                                <th>Title: </th>
                                <td> {{  headerdata.document_title  | arrayToString }} </td>
                            </tr>
                            <tr>
                                <th>Author: </th>
                                <td> {{  documentAuthors() }} </td>
                            </tr>
                            <tr>
                                <th>Editor: </th>
                                <td> {{  documentEditors() }} </td>
                            </tr>
                            <tr>
                                <th>Register: </th>
                                <td> {{  headerdata.document_genre  | arrayToString }} </td>
                            </tr>
                            <tr>
                                <th>Publisher: </th>
                                <td> {{  documentPublisher() }} </td>
                            </tr>
                            <tr>
                                <th>Place: </th>
                                <td> {{  headerdata.document_publication_place  | arrayToString }} </td>
                            </tr>
                            <tr>
                                <th>Publication: </th>
                                <td> {{ publication()  }} </td>
                            </tr>
                            <tr>
                                <th>Series: </th>
                                <td> {{ headerdata.document_publication_series | arrayToString }} </td>
                            </tr>
                            <tr>
                                <th>Scope</th>
                                <td>{{ headerdata.document_publication_pages | arrayToString }}</td>
                            </tr>
                            <tr>
                                <th>Document size</th>
                                <td>{{ headerdata.document_size_extent | arrayToString }} {{ headerdata.document_size_type | arrayToString }}</td>
                            </tr>
                        </table>
                        <h2>Language</h2>
                         <table class="table table-condensed">
                            <tr v-for="(languageData, index) in headerdata.document_languages_style">
                                <th>{{languageData.concat(': ')}}</th>
                                <td>{{headerdata.document_languages_language[index]}}</td>
                            </tr>
                         </table>
                    </div>
                    <div class="tab-pane fade" id="sourcedescription">
                        <h2>SOURCE DESCRIPTION</h2>
                        <table class="table table-condensed">
                            <tr>
                                <th>Title: </th>
                                <td> {{ headerdata.document_history_title  | arrayToString }} </td>
                            </tr>
                            <tr>
                                <th>Original Title: </th>
                                <td> {{ headerdata.document_history_original_title  | arrayToString }} </td>
                            </tr>
                            <tr>
                                <th>Type: </th>
                                <td> {{ headerdata.document_history_document_type  | arrayToString }} </td>
                            </tr>
                            <tr>
                                <th>Date: </th>
                                <td> {{headerdata.document_history_not_before | arrayToString }} : {{ headerdata.document_history_not_after | arrayToString }}</td>
                            </tr>
                            <tr>
                                <th>Place: </th>
                                <td> {{ headerdata.document_history_original_place | arrayToString }} </td>
                            </tr>
                            <tr>
                                <th>Location in manuscript: </th>
                                <td> {{ headerdata.document_history_location_in_manuscript | arrayToString }} </td>
                            </tr>
                            <tr>
                                <th>Collection: </th>
                                <td> {{ headerdata.document_history_collection | arrayToString }} </td>
                            </tr>
                            <tr>
                                <th>Repository: </th>
                                <td> {{ headerdata.document_history_repo | arrayToString }} </td>
                            </tr>
                            <tr>
                                <th>Faximile: </th>
                                <td> {{ headerdata.document_history_faximile_link | arrayToString }} </td>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="license">
                        <h2>LIcense / REVISION</h2>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Version</th>
                                <th>Publishing Date</th>
                                <th>Revision Description</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(versionData, index) in headerdata.revision_document_version">
                                    <td>{{versionData}}</td>
                                    <td>{{headerdata.revision_publishing_date[index]}}</td>
                                    <td>{{headerdata.revision_description[index]}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
              </div>
            </div>

        </div>
        <div class="tab-pane fade" id="annotationMetadata">
        <div class="row">
              <div class="col-sm-3">

                <div class="sidebar-nav">
                    <div class="navbar-collapse collapse sidebar-navbar-collapse">
                      <ul class="nav nav-stacked">
                        <li v-for="(annotationGroup, index) in headerdata.annotationGroups" :class="{ 'active': index === 0 }" class="nav-link" role="tab">
                            <a v-bind:href="('#').concat(annotationGroup.key)" data-toggle="pill">{{annotationGroup.key}}</a>
                        </li>

                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-sm-9">
               <div class="tab-content">
                <div class="tab-pane fade" v-for="(annotationGroup, index) in headerdata.annotationGroups" :id="annotationGroup.key" v-if="header == 'document'" :class="{ 'in active': index === 0 }">
                    {{annotationGroup.key}}
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
                documentsByAnnotation: []
            }

        },
        methods: {
            documentAuthors: function(){
                var authorString = "";
                for(var i=0; i < this.headerdata.document_author_forename.length;i++) {
                    authorString += this.headerdata.document_author_surname[i]
                        .concat(', ')
                        .concat(this.headerdata.document_author_forename[i])
                        .concat(';');
                }
                authorString = authorString.substring(0,authorString.lastIndexOf(";"));
                return authorString;
            },
            documentEditors: function(){
                var editorString = "";
                for(var i=0; i < this.headerdata.document_editor_forename.length;i++) {
                    if(this.headerdata.document_editor_forename[i] != "NA" && this.headerdata.document_editor_surname[i] != "NA"){
                        editorString += this.headerdata.document_editor_forename[i]
                            .concat(' ')
                            .concat(this.headerdata.document_editor_surname[i])
                            .concat(',');
                    }
                    else{
                        editorString += "-".concat(',');
                    }

                }
                editorString = editorString.substring(0,editorString.lastIndexOf(","));
                return editorString;
            },
            documentPublisher: function(){
                var publisherString = "";
                for(var i=0; i < this.headerdata.document_publication_publisher.length;i++) {
                    if(this.headerdata.document_publication_publisher[i] != "NA"){
                        publisherString += this.headerdata.document_publication_publisher[i].concat(',');
                    }
                    else{
                        publisherString += "-".concat(',');
                    }

                }
                publisherString = publisherString.substring(0,publisherString.lastIndexOf(","));
                return publisherString;
            },
            publication: function(){
                var publicationString = "";
                publicationString += this.documentAuthors()
                    .concat(' ('+this.headerdata.document_publication_publishing_date[0]+')')
                    .concat(' ').concat(this.headerdata.document_title[0]).concat('.')
                    .concat(' ').concat(this.documentPublisher()).concat('.')
                    .concat(' ').concat(this.headerdata.document_publication_place[0]).concat('.');
                return publicationString;
            }
        },
        computed: {

        },
        mounted() {
            console.log('DocumentMetadataBlockBody mounted.')
        }
    }
</script>