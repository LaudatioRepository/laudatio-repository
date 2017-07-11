<template lang="html">
    <div>
        <ul class="nav nav-pills nav-fill" role="tablist">
          <!--li role="tab" class="nav-link active"><a href="#project" data-toggle="pill">Project</a></li>
          <li role="tab" class="nav-link"><a href="#annotators" data-toggle="pill">Annotators</a></li>
          <li role="tab" class="nav-link"><a href="#revisions" data-toggle="pill">Revisions</a></li-->
          <li role="tab" class="nav-link"><a href="#annotations" data-toggle="pill">Annotations</a></li>
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