<template lang="html">
    <div id="corpusheader">
        <h1>{{ headerdata.corpus_title | arrayToString }}</h1>

        <table class="table table-condensed table-responsive">
             <tr>
                <td>
                    <span class="iconwrapper"><i class="fa fa-university fa-2x" aria-hidden="true" v-if="typeof headerdata.corpus_publication_publication_date != 'undefined'"></i> {{headerdata.corpus_publication_publication_date | lastElement}}</span>
                </td>
                <td>
                    <span class="iconwrapper"><i class="fa fa-file-text fa-2x" aria-hidden="true" v-if="typeof headerdata.corpus_documents != 'undefined'"></i> {{headerdata.corpus_documents.length}}</span>
                </td>
                <td>
                    <span class="iconwrapper"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true" v-if="typeof headerdata.annotation_name != 'undefined'"></i> {{headerdata.annotation_name.length}}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="iconwrapper"><i class="fa fa-cubes fa-2x" aria-hidden="true" v-if="typeof headerdata.corpus_size_value != 'undefined'"></i> {{headerdata.corpus_size_value | arrayToString}}</span>
                </td>
                <td>
                    <span class="iconwrapper"><i class="fa fa-language fa-2x" aria-hidden="true" v-if="typeof headerdata.corpus_size_value != 'undefined'"></i> {{headerdata.corpus_languages_language[0]}}</span>
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