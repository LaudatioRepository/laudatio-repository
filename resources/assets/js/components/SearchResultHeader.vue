<template>
    <div id="resultheader">
        <div class="d-flex justify-content-between my-1">
            <ul class="nav nav-tabs" id="searchtabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tab-corpora" data-toggle="tab" href="#searchtab-corpora" role="tab" aria-controls="searchtab-corpora"
                       aria-selected="true">Corpora ({{corpusresultcounter}})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-documents" data-toggle="tab" href="#searchtab-documents" role="tab" aria-controls="searchtab-documents"
                       aria-selected="false">Documents ({{documentresultcounter}})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-annotations" data-toggle="tab" href="#searchtab-annotations" role="tab" aria-controls="searchtab-annotations"
                       aria-selected="false">Annotations ({{annotationresultcounter}})</a>
                </li>
            </ul>
            <div class="form-row ">
                <div class="col-auto">
                    <div class="dropdown">
                        <button class="btn btn-outline-corpus-dark rounded dropdown-toggle font-weight-bold text-uppercase "
                                type="button" id="searchSorting" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Title - Alphabetical
                        </button>
                        <div class="dropdown-menu" aria-labelledby="searchSort">
                            <a class="dropdown-item text-14" href="#">Title - alphabetical</a>
                            <a class="dropdown-item text-14" href="#">Tokens - ascending</a>
                            <a class="dropdown-item text-14" href="#">Tokens - descending</a>
                            <a class="dropdown-item text-14" href="#">Corpus release - oldest</a>
                            <a class="dropdown-item text-14" href="#">Corpus release - newest</a>
                            <a class="dropdown-item text-14" href="#">Date Document - oldest</a>
                            <a class="dropdown-item text-14" href="#">Date Document - newest</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-100 py-3 px-6 mb-1 bg-corpus-light d-flex flex-column">
            <div class="btn btn-sm font-weight-bold text-uppercase btn-outline-corpus-dark align-self-end disabled">
                Apply Filter
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['corpusresults','documentresults','annotationresults','documentsbycorpus','annotationsbycorpus','corpusresultcounter','documentresultcounter','annotationresultcounter'],
        mounted() {
            console.log('CorpusResultHeaderComponent mounted.')
        }
    }
</script>