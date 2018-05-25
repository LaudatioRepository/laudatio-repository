<template lang="html">
    <div class="container-fluid tab-content content">
    <div role="tabpanel"  class="tab-pane active" id="corpusMetadataBody">
    <div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-2">
                <nav class="headernav sidebar text-14 nav flex-column border-top border-light mt-7" role="tablist">
                     <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link active" href="#">Description</a>
  <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link" href="#">Source Description</a>
  <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link" href="#">License / Revision</a>
                </nav>
            </div>
            <div class="col">
                <div id="tabcontainer" class="container-fluid tab-content content">



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
                        <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link tablink active" data-toggle="tab" role="tab" data-headertype="corpus" href="#allAnnotations">All ({{groupCount("all")}})</a>
                        <span v-for="(annotationGroup) in headerdata.allAnnotationGroups">
                            <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link tablink" data-toggle="tab" role="tab" data-headertype="corpus" v-if="groupCount(annotationGroup) > 0 " v-bind:href="('#').concat(annotationGroup)">{{annotationGroup | touppercase}} ({{groupCount(annotationGroup)}})</a>
                            <a class="font-weight-normal text-uppercase py-3 px-0 border-bottom border-light nav-link tablink disabledLink" data-toggle="tab" role="tab" data-headertype="corpus" v-else>{{annotationGroup | touppercase}}</a>
                        </span>
                    </nav>
                </div>
                <div class="col">
                    <div id="tabcontainer" class="container-fluid tab-content content">


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

        },
        mounted() {
            console.log('DocumentMetadataBlockBody mounted.')
        }
    }
</script>