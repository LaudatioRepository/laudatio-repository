<template lang="html">
    <div id="corpusheader">
        <h1>{{ headerdata.corpus_title | arrayToString }}</h1>

        <table class="table table-condensed table-responsive">
             <tr>
                <td>
                    <span class="iconwrapper"><i class="fa fa-university fa-2x" aria-hidden="true" v-if="typeof headerdata.corpus_publication_publication_date != 'undefined'"></i> <strong>Published: {{headerdata.corpus_publication_publication_date | lastElement}}</strong></span>
                </td>
                <td>
                    <span class="iconwrapper"><i class="fa fa-file-text fa-2x" aria-hidden="true" v-if="typeof headerdata.corpus_documents != 'undefined'"></i> <strong>{{headerdata.corpus_documents.length}} Documents</strong></span>
                </td>
                <td>
                    <span class="iconwrapper"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true" v-if="typeof headerdata.annotation_name != 'undefined'"></i> <strong>{{headerdata.annotation_name.length}} Annotations</strong></span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="iconwrapper"><i class="fa fa-cubes fa-2x" aria-hidden="true" v-if="typeof headerdata.corpus_size_value != 'undefined'"></i> <strong>{{headerdata.corpus_size_value | arrayToString}} Tokens</strong></span>
                </td>
                <td>
                    <span class="iconwrapper"><i class="fa fa-language fa-2x" aria-hidden="true" v-if="typeof headerdata.corpus_size_value != 'undefined'"></i> <strong>{{headerdata.corpus_languages_language[0]}}</strong></span>
                </td>
                <td>&nbsp;</td>
            </tr>
        </table>

    </div>
</template>

<script>
    export default {
        props: ['headerdata'],
        mounted() {
            console.log('CorpusMetadataBlockHeader mounted.')
        }
    }
</script>