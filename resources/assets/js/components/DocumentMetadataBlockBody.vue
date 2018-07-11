<template lang="html">
    <div class="container-fluid tab-content content"  v-if="header == 'document'">
        <div role="tabpanel"  class="tab-pane active" id="documentMetadataBody">
            <div class="container">
                <div class="row">
                    <div class="col-2">
                        <nav class="headernav sidebar text-14 nav flex-column border-top border-light mt-7" role="tablist">
                            <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link active stacktablink" data-toggle="tab" role="tab" data-headertype="document" href="#documentDescription">Description</a>
                            <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link stacktablink" data-toggle="tab" role="tab" data-headertype="document"  href="#sourceDescription">Source Description</a>
                            <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link stacktablink" data-toggle="tab" role="tab" data-headertype="document" href="#license">License / Revision</a>
                        </nav>
                    </div>
                    <div class="col">
                        <div id="tabcontainer" class="container-fluid tab-content content">
                            <div role="tabpanel"  class="tab-pane active" id="documentDescription" v-if="header == 'document'">
                            <div class="d-flex justify-content-between mt-7 mb-3">
                                <div class="h3 font-weight-normal">DESCRIPTION</div>
                            </div>

                            <dl class="row mb-7">
                                <dt class="col-sm-3">Title: </dt>
                                <dd class="col-sm-9"> {{  headerdata.document_title  | arrayToString }} </dd>


                                <dt class="col-sm-3">Audtor: </dt>
                                <dd class="col-sm-9"> {{  documentAuthors() }} </dd>


                                <dt class="col-sm-3">Editor: </dt>
                                <dd class="col-sm-9"> {{  documentEditors() }} </dd>


                                <dt class="col-sm-3">Register: </dt>
                                <dd class="col-sm-9"> {{  headerdata.document_genre  | arrayToString }} </dd>


                                <dt class="col-sm-3">Publisher: </dt>
                                <dd class="col-sm-9"> {{  documentPublisher() }} </dd>


                                <dt class="col-sm-3">Place: </dt>
                                <dd class="col-sm-9"> {{  headerdata.document_publication_place  | arrayToString }} </dd>


                                <dt class="col-sm-3">Publication: </dt>
                                <dd class="col-sm-9"> {{ publication()  }} </dd>


                                <dt class="col-sm-3">Series: </dt>
                                <dd class="col-sm-9"> {{ headerdata.document_publication_series | arrayToString }} </dd>


                                <dt class="col-sm-3">Scope</dt>
                                <dd class="col-sm-9">{{ headerdata.document_publication_pages | arrayToString }}</dd>


                                <dt class="col-sm-3">Document size</dt>
                                <dd class="col-sm-9">{{ headerdata.document_size_extent | arrayToString }} {{ headerdata.document_size_type | arrayToString }}</dd>
                            </dl>



                             <h2>Language</h2>
                            <span v-for="(langObject,index) in getLanguages()" class="languageLists">
                                <nested-list v-bind:content="langObject"></nested-list>
                            </span>

                            </div>

                            <div role="tabpanel"  class="tab-pane fade" id="sourceDescription" v-if="header == 'document'">
                                <div class="d-flex justify-content-between mt-7 mb-3">
                                    <div class="h3 font-weight-normal">SOURCE DESCRIPTION</div>
                                </div>
                                <table class="table table-condensed">
                                    <tr>
                                        <th>Classification: </th>
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
                                        <th>Original Date: </th>
                                        <td> {{headerdata.document_history_not_before | arrayToString }} : {{ headerdata.document_history_not_after | arrayToString }}</td>
                                    </tr>
                                    <tr>
                                        <th>Original Place: </th>
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
                                        <th>Facsimile: </th>
                                        <td> {{ headerdata.document_history_faximile_link | arrayToString }} </td>
                                    </tr>
                                </table>
                            </div>

                            <div role="tabpanel"  class="tab-pane fade" id="license" v-if="header == 'document'">
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
        <div role="tabpanel"  class="tab-pane fade in" id="annotationMetadataBody" v-if="header == 'document'">
             <div class="container">
                <div class="row">
                    <div class="col-2">
                        <nav class="headernav sidebar text-14 nav flex-column border-top border-light mt-7" role="tablist">
                            <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link stacktablink active" data-toggle="tab" role="tab" data-headertype="document" href="#allAnnotations">All ({{totalAnnotations()}})</a>
                            <span v-for="(annotationGroup) in headerdata.allAnnotationGroups">
                                <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link stacktablink" data-toggle="tab" role="tab" data-headertype="document" v-if="groupCount(annotationGroup) > 0 " v-bind:href="('#').concat(annotationGroup)">{{annotationGroup | touppercase}} ({{groupCount(annotationGroup)}})</a>
                                <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link stacktablink disabledLink" data-toggle="tab" role="tab" data-headertype="document" v-else>{{annotationGroup | touppercase}}</a>
                            </span>
                        </nav>
                    </div>
                    <div class="col">
                    <div id="tabcontainer" class="container-fluid tab-content content">
                        <div role="tabpanel"  class="tab-pane active" id="allAnnotations" v-if="header == 'document'">
                            <div class="d-flex justify-content-between mt-7 mb-3">
                                <div class="h3 font-weight-normal">Annotations - All ({{groupCount("all")}})</div>
                            </div>
                            <vue-good-table
                                 :columns="allAnnotationColumns"
                                 :rows=allAnnotations()
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
                        <div role="tabpanel"  class="tab-pane fade" v-for="(annotationGroup) in headerdata.allAnnotationGroups" :id="annotationGroup" v-if="header == 'document'">
                            <div class="d-flex justify-content-between mt-7 mb-3">
                                <div class="h3 font-weight-normal">{{annotationGroup}}  ({{groupCount(annotationGroup)}})</div>
                            </div>
                            <vue-good-table
                              :columns="allAnnotationColumns"
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
        <div class="verticalBadge text-uppercase font-weight-bold bg-blueadmin text-14 text-white rounded bsh-1" v-show="isloggedin">
              <span>
                WORKING VERSION
              </span>
        </div>
    </div>
</template>
<script>
    import DefinitionList from "./DefinitionList";
    export default {
        components: {DefinitionList},
        props: ['headerdata','header','user','isloggedin'],
        data: function(){
            return {
                annotators: [],
                revisions: [],
                documentsByAnnotation: [],
                licenseColumns: [
                    {
                        label: 'Version',
                        field: 'version',
                        filterable: true
                    },
                    {
                        label: 'Publishing date',
                        field: 'date',
                        filterable: true
                    },
                    {
                        label: 'Revision description',
                        field: 'description',
                        filterable: true
                    }
                ],
                allAnnotationColumns: [
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
                    },

                ],
                allAnnotationRows: this.allAnnotations(),
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
            },
            totalAnnotations: function(){
                var total = 0;
                for (var key in this.headerdata.annotationGroups) {
                    let item = this.headerdata.annotationGroups[key];
                    total += item.length;
                }
                return total;
            },
            allAnnotations: function(){
                var allAnnotations = [];
                if(null != this.headerdata.annotationGroups && typeof this.headerdata.annotationGroups != 'undefined'){
                    Object.keys(this.headerdata.annotationGroups).forEach(function(key, index) {

                        this[key].forEach(function(value){
                            value.group = key;
                            if(typeof value.document_count == 'undefined'){
                                value.document_count = 0.0;
                            }
                            allAnnotations.push(value);
                        })
                    }, this.headerdata.annotationGroups);
                }

                return allAnnotations;
            },
            annotationRows: function(currentkey){
                //allAnnotationGroups
                var annotationArray = [];
                var foundAnnotationArray = [];
                var theHeaderData = this.headerdata;
                if(null != theHeaderData.allAnnotationGroups && null != theHeaderData.annotationGroups && typeof theHeaderData.annotationGroups != 'undefined'){
                    Object.keys(this.headerdata.annotationGroups).forEach(function(key, index) {
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

                    }, this.headerdata.annotationGroups);
                }

                return annotationArray;
            },
            licenseRows: function() {
                var licenseArray = []
                var theHeaderData = this.headerdata;

                if( typeof theHeaderData.revision_document_version != 'undefined' &&
                    typeof theHeaderData.revision_publishing_date != 'undefined' &&
                    typeof theHeaderData.revision_description != 'undefined' &&
                    this.hasSameLength([
                        theHeaderData.revision_document_version,
                        theHeaderData.revision_publishing_date,
                        theHeaderData.revision_description
                    ])

                ) {
                    for (var i = 0; i < theHeaderData.revision_document_version.length; i++) {
                        var licenseObject = {}
                        licenseObject.version = theHeaderData.revision_document_version[i];
                        licenseObject.date = theHeaderData.revision_publishing_date[i];
                        licenseObject.description = theHeaderData.revision_description[i];

                        licenseArray.push(licenseObject);
                    }
                }
                return licenseArray;
            },
            groupCount: function(key) {
                var data = this.headerdata.annotationGroups;
                if(typeof  data != 'undefined' && typeof data[key] != 'undefined') {
                    return data[key].length;
                }
            },
            goToAnnotation: function(params) {
                document.location = "/browse/annotation/"+params.row.preparation_annotation_id
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
            },
            getLanguages: function () {
                var languageArray = []
                var theHeaderData = this.headerdata;
                Object.keys(theHeaderData.document_languages_style).forEach(function(key, idx) {
                    var languageObject = {}
                    //languageObject['label'] = theHeaderData.document_languages_style[idx]
                    languageObject[theHeaderData.document_languages_style[idx]] = theHeaderData.document_languages_language[idx];
                    //languageObject['language'] = theHeaderData.document_languages_language[idx];
                    languageArray.push(languageObject);
                },theHeaderData.document_languages_style);
                return languageArray;
            }

        },
        computed: {

        },
        mounted() {
            console.log('DocumentMetadataBlockBody mounted.')
        }
    }
</script>