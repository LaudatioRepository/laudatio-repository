<template lang="html">
    <div id="corpusheader" v-if="header == 'corpus'">
        <div class="headerRow">
              <div class="headerColumn left">

               </div>
             <div class="headerColumn middle">
                <h1 class="corpusTitle">{{ headerdata.corpus_title | arrayToString }}</h1>
                <div class="autorHeader">{{corpusAuthors()}}</div>


                <div class="clearfix pull-left">
                <span><i class="material-icons" aria-hidden="true" v-if="typeof headerdata.corpus_documents != 'undefined'">access_time</i> Documents from</span>
                <span><i class="material-icons" aria-hidden="true" v-if="typeof headerdata.corpus_size_value != 'undefined'">language</i> {{headerdata.corpus_languages_language[0]}}</span><br />
                <span v-if="typeof headerdata.corpus_size_value != 'undefined'">{{headerdata.corpus_size_value | arrayToString}} Tokens</span>
                <span><i class="material-icons"  aria-hidden="true" v-if="typeof headerdata.corpus_publication_publication_date != 'undefined'">publish</i> {{headerdata.corpus_publication_publication_date | lastElement}}</span>

                </div>

                <blockquote class="headerCitation clearfix pull-left">
                    <span class="citation">
                    <i class="material-icons">format_quote</i>
                    {{ corpusAuthors() }};
                    {{ headerdata.corpus_title | arrayToString }};
                    {{ headerdata.corpus_publication_publisher[0] }};
                    Homepage: {{ headerdata.corpus_encoding_project_homepage[0] }};
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
            corpusAuthors: function(){
                var authorString = "";
                for(var i=0; i < this.headerdata.corpus_editor_forename.length;i++) {
                    authorString += this.headerdata.corpus_editor_forename[i]
                        .concat(' ')
                        .concat(this.headerdata.corpus_editor_surname[i])
                        .concat(',');
                }
                authorString = authorString.substring(0,authorString.lastIndexOf(","));
                return authorString;
            }
        },
        mounted() {
            console.log('CorpusMetadataBlockHeader mounted.')
        }
    }
</script>