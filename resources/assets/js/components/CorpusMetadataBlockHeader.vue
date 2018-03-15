<template lang="html">
    <div class="headerRow headerNav">
        <div class="headerColumn left">

        </div>
        <div class="headerColumn middle">
            <ul class="nav nav-pills" v-if="header == 'corpus'">
                <li class="active" role="tab"><a href="#corpusMetadataBody"  data-toggle="pill">CORPUS <i class="material-icons">book</i></a></li>
                <li role="tab"><a href="#documentMetadataBody" data-toggle="pill">DOCUMENTS <i class="material-icons">description</i> {{headerdata.corpusdocumentcount}}</a></li>
                <li role="tab"><a href="#annotationMetadataBody" data-toggle="pill">ANNOTATIONS <i class="material-icons">create</i> {{headerdata.totalcorpusannotationcount}}</a></li>
            </ul>
        </div>
        <div class="headerColumn right">
        </div>
    </div>
</template>

<script>
    export default {
        props: ['headerdata','header'],
        mounted() {
            console.log('CorpusMetadataBlockHeader mounted.')
        }
    }
</script>