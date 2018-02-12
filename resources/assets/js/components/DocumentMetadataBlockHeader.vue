<template lang="html">
    <div class="headerRow headerNav">
        <div class="headerColumn left">

        </div>
        <div class="headerColumn middle">
            <ul class="nav nav-pills">
                <li role="tab" class="active"><a href="#documentMetadata" data-toggle="pill">DOCUMENT METADATA <i class="material-icons">description</i> 10</a></li>
                <li role="tab"><a href="#annotationMetadata" data-toggle="pill">ANNOTATIONS <i class="material-icons">create</i> 200</a></li>
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