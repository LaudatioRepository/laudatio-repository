<template lang="html">
    <div id="documentheader" v-if="header == 'document'">
        <div class="headerRow">
              <div class="headerColumn left">

               </div>
             <div class="headerColumn middle">
                <h1 class="documentTitle">{{ headerdata.document_title | arrayToString }}</h1>
                <div class="autorHeader">{{headerdata.document_author_forename | arrayToString}} {{headerdata.document_author_surname | arrayToString}}</div>


                <div class="clearfix pull-left">
                <span v-if="typeof headerdata.document_publication_publishing_date != 'undefined'"><i class="material-icons" aria-hidden="true">access_time</i> Published: {{headerdata.document_publication_publishing_date | arrayToString}}</span>
                <span v-if="typeof headerdata.document_publication_place != 'undefined'"><i class="material-icons" aria-hidden="true">language</i> {{headerdata.document_publication_place | arrayToString}} </span><br />
                <span v-if="typeof headerdata.document_list_of_annotations_name != 'undefined'">{{headerdata.document_list_of_annotations_name.length}} Annotations</span>
                <span v-if="typeof headerdata.document_size_extent != 'undefined'"><i class="material-icons"  aria-hidden="true">publish</i> {{headerdata.document_size_extent | arrayToString}} Tokens</span>
                <span v-if="typeof headerdata.document_languages_language != 'undefined'"><i class="material-icons"  aria-hidden="true">publish</i> {{concatLanguages}} </span>
                <span v-if="typeof headerdata.document_history_faximile_link != 'undefined'"><a v-bind:href="facsimileUri()"><i class="material-icons"  aria-hidden="true">facsimile</i></a> </span>

                </div>
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
        computed: {
            concatLanguages: function(){
                return this.headerdata.document_languages_language.join();
            }
        },
        methods: {
            facsimileUri: function(id) {
                return this.headerdata.document_history_faximile_link
            }
        },
        mounted() {
            console.log('DocumentMetadataBlockHeader mounted.')
        }
    }
</script>