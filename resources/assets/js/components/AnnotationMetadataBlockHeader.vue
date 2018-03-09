<template lang="html">
    <div class="headerRow headerNav">
        <div class="headerColumn left">

        </div>
        <div class="headerColumn middle">
            <ul class="nav nav-pills">
                <li role="tab" class="active"><a href="#guidelines" data-toggle="pill">GUIDELINES</a></li>
                <li role="tab"><a href="#preparationsteps" data-toggle="pill">PREPARATION STEPS</a></li>
                <li role="tab"><a href="#documents" data-toggle="pill">DOCUMENTS <i class="material-icons">create</i> {{headerdata.documents.length}}</a></a></li>
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
            console.log('AnnotationMetadataBlockHeader mounted.')
        }
    }
</script>