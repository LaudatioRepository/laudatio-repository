<template lang="html">
    <div id="corpusheader" v-if="header == 'annotation'">
        <div class="headerRow">
              <div class="headerColumn left">

               </div>
             <div class="headerColumn middle">
                <h1 class="corpusTitle">{{ headerdata.preparation_title | arrayToString }}</h1>
                 <div class="corpusAffiliationHeader">Annotation in {{headerdata.annotationCorpusdata.corpus_title | arrayToString}}</div>
                <div class="editorHeader">{{ annotationEditors() }}</div>


                <div class="clearfix pull-left">
                    <span v-if="typeof headerdata.preparation_size_valuee != 'undefined'"><i class="material-icons" aria-hidden="true">code</i>{{headerdata.preparation_size_valuee | arrayToString}} {{headerdata.preparation_size_type | arrayToString }}</span>
                </div>

                <blockquote class="headerCitation clearfix pull-left">
                    <span class="citation">
                    <i class="material-icons">format_quote</i>
                    {{ corpusAuthors() }};
                    {{ headerdata.annotationCorpusdata.corpus_title | arrayToString }};
                    {{ headerdata.annotationCorpusdata.corpus_publication_publisher[0] }};
                    Homepage: {{ headerdata.annotationCorpusdata.corpus_encoding_project_homepage[0] }};
                    Corpus-Link: <a href="http://handle">http://handle.net/xxx</a>
                    </span>
                </blockquote>
            </div>
             <div class="headerColumn right">
                 <aside id="info-block">
                    <section class="file-marker">
                        <div>
                            <div class="box-title">CORPUS</div>
                            <div class="box-contents">
                                    <div id="download">
                                        <div class="btn-group  btn-group-xs">
                                          <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            DOWNLOAD <span class="caret"></span>
                                          </button>
                                          <ul class="dropdown-menu">
                                            <li><a href="#">Action</a></li>
                                            <li><a href="#">Another action</a></li>
                                            <li><a href="#">Something else here</a></li>
                                            <li role="separator" class="divider"></li>
                                            <li><a href="#">Separated link</a></li>
                                          </ul>
                                        </div>
                                        <div class="btn-group  btn-group-xs"><button type="button" class="btn btn-xs btn-danger">OPEN IN ANNIS</button></div>
                                        <div class="btn-group btn-group-xs">
                                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            CITE <span class="caret"></span>
                                          </button>
                                          <ul class="dropdown-menu">
                                            <li><a href="#">Action</a></li>
                                            <li><a href="#">Another action</a></li>
                                            <li><a href="#">Something else here</a></li>
                                            <li role="separator" class="divider"></li>
                                            <li><a href="#">Separated link</a></li>
                                          </ul>
                                        </div>
                                        <div class="license">
                                            <i class="cc cc-BY cc-lg"></i>
                                        </div>
                                    </div>
                             </div>
                        </div>
                    </section>
                </aside>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['headerdata','header'],
        methods: {
            annotationEditors: function(){
                var editorString = "";
                for(var i=0; i < this.headerdata.preparation_editor_forename.length;i++) {
                    editorString += this.headerdata.preparation_editor_forename[i]
                        .concat(' ')
                        .concat(this.headerdata.preparation_editor_surname[i])
                        .concat(',');
                }
                editorString = editorString.substring(0,editorString.lastIndexOf(","));
                return editorString;
            },
            facsimileUri: function(id) {
                return this.headerdata.document_history_faximile_link
            },
            corpusAuthors: function(){
                var authorString = "";
                for(var i=0; i < this.headerdata.annotationCorpusdata.corpus_editor_forename.length;i++) {
                    authorString += this.headerdata.annotationCorpusdata.corpus_editor_forename[i]
                        .concat(' ')
                        .concat(this.headerdata.annotationCorpusdata.corpus_editor_surname[i])
                        .concat(',');
                }
                authorString = authorString.substring(0,authorString.lastIndexOf(","));
                return authorString;
            }
        },
        mounted() {
            console.log('AnnotationHeader mounted.')
        }
    }
</script>