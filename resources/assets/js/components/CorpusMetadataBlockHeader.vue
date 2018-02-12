<template lang="html">
    <div class="headerRow headerNav">
    <div class="headerColumn left">

    </div>
    <div class="headerColumn middle">
    <ul class="nav nav-pills">
        <li class="active" role="tab"><a href="#corpusMetadataBody"  data-toggle="pill">CORPUS <i class="material-icons">book</i></a></li>
        <li role="tab"><a href="#documentMetadataBody" data-toggle="pill">DOCUMENTS <i class="material-icons">description</i> 10</a></li>
        <li role="tab"><a href="#annotationMetadataBody" data-toggle="pill">ANNOTATIONS <i class="material-icons">create</i> 200</a></li>
    </ul>
    </div>
    <div class="headerColumn right">
    </div>
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