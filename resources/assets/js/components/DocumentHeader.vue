<template lang="html">
    <div id="corpusheader" v-if="header == 'document'">
        <h1>{{ headerdata.document_title | arrayToString }}</h1>
        <p class="autorhoreader">{{headerdata.document_author_forename | arrayToString}} {{headerdata.document_author_surname | arrayToString}}</p>
        <table class="table table-condensed table-responsive">
             <tr>
                <td>
                    <span class="iconwrapper"><i class="fa fa-university fa-2x" aria-hidden="true" v-if="typeof headerdata.document_publication_publishing_date != 'undefined'"></i> <strong>Published: {{headerdata.document_publication_publishing_date | arrayToString}}</strong></span>
                </td>
                <td>
                    <span class="iconwrapper"><i class="fa fa-map-marker fa-2x" aria-hidden="true" v-if="typeof headerdata.document_publication_place != 'undefined'"></i> <strong>{{headerdata.document_publication_place | arrayToString}}</strong></span>
                </td>
                <td>
                    <span class="iconwrapper"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true" v-if="typeof headerdata.document_list_of_annotations_name != 'undefined'"></i> <strong>{{headerdata.document_list_of_annotations_name.length}} Annotations</strong></span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="iconwrapper"><i class="fa fa-cubes fa-2x" aria-hidden="true" v-if="typeof headerdata.document_size_extent != 'undefined'"></i> <strong>{{headerdata.document_size_extent | arrayToString}} Tokens</strong></span>
                </td>
                <td>
                    <span class="iconwrapper"><i class="fa fa-language fa-2x" aria-hidden="true" v-if="typeof headerdata.document_languages_language != 'undefined'"></i> <strong>{{concatLanguages}}</strong></span>
                </td>
                <td><span class="iconwrapper"><a v-bind:href="facsimileUri()"><i class="fa fa-external-link-square fa-2x" aria-hidden="true"  v-if="typeof headerdata.document_history_faximile_link != 'undefined'"></i> <span class="facsimile">Facsimile</span></a></span> </td>
            </tr>
        </table>

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
            console.log('CorpusMetadataBlockHeader mounted.')
        }
    }
</script>