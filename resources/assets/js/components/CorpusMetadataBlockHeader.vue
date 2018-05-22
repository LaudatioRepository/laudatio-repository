<template lang="html">
     <div class="row mt-5">
            <nav class="navbar navbar-expand-sm navbar-light bg-transparent p-0 container" role="tablist">

                <div class="navbar-nav nav row w-100 px-5">
                    <div class="nav-item maintablink col-2 text-center text-14 font-weight-bold active">
                        <a class=" nav-link maintablink text-dark text-uppercase " data-toggle="tab" href="#corpusMetadataBody" role="tab">
                            CORPUS
                        </a>
                    </div>

                    <div class="nav-item maintablink col-auto text-center text-14 font-weight-bold ">
                          <a class="nav-link maintablink  text-dark text-uppercase " href="#documentMetadataBody">
                            Documents <div class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1">
                      <i class="fa fa-text-height fa-fw fa-file-text-o align-baseline fa-lg text-wine"></i>
                      <span class="text-primary text-14 font-weight-bold">{{headerdata.corpusdocumentcount}}</span>
                    </div>
                    </a>
                    </div>

                    <div class="nav-item maintablink col-auto text-center text-14 font-weight-bold ">
                      <a class="nav-link maintablink  text-dark text-uppercase " href="#annotationMetadataBody">
                        Annotations
                        <div class="labelBadge badge bg-white border border-corpus-dark rounded mx-1 py-1 ">
                            <i class="fa fa-text-height fa-fw fa-edit align-text-middle fa-lg text-wine"></i>
                            <span class="text-primary text-14 font-weight-bold">{headerdata.totalcorpusannotationcount}}</span>
                        </div>
                      </a>
                    </div>
                </div>
            </nav>
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