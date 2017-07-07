<template lang="html">
    <div id="corpus-description">
        {{headerdata.corpus_encoding_project_description | lastElement}}
    </div>
</template>

<script>
    export default {
        props: ['headerdata'],
        mounted() {
            console.log('CorpusMetadataBlockBody mounted.')
        }
    }
</script>