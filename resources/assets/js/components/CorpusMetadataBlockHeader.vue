<template lang="html">
    <div>
        <ul class="nav nav-pills">
          <li role="presentation" class="active"><a href="#">Project</a></li>
          <li role="presentation"><a href="#">Annotators</a></li>
          <li role="presentation"><a href="#">Revisions</a></li>
        </ul>
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