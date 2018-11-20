<template>
    <div class="card">
        <div class="card-header btn bg-corpus-mid font-weight-bold text-uppercase d-flex justify-content-between align-items-center"
             data-toggle="collapse" data-target="#formPanelActives" aria-expanded="true" aria-controls="formPanelActives">
            <span>Active Filter (x)</span>
            <i class="collapse-indicator fa fa-chevron-circle-down fa-fw fa-lg text-16"></i>
        </div>
        <div v-bind:class="getClass()" id="formPanelActives">
            <div class="card-body p-1">
                <form action="">
                    <div class="d-flex flex-wrap py-2" v-if="activefilters != 'undefined' && activefilters.length >= 1" v-for="(activefilter, index) in activefilters"  v-bind:activefilter="activefilter"
                         :key="index">
                        <div class="m-1">
                            <a href="#" class="badge badge-corpus-mid p-1 text-14 font-weight-normal rounded">
                                <i class="fa fa-close fa-fw"></i>
                                {{activefilter.name}}
                            </a>
                        </div>
                    </div>

                    <div class="d-flex flex-column">
                        <a class="align-self-end text-uppercase text-dark text-12 p-2" href="javascript:" role="button" @click="resetFilters()">
                            Clear all Filter
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapState, mapActions, mapGetters } from 'vuex'
    export default {
        props: ['corpusresults','documentresults','annotationresults','activefilters','corpusresultcounter','documentresultcounter','annotationresultcounter'],
        data: function() {
            return {
                localcorpusresultcounter: this.corpusresultcounter,
                localdocumentresultcounter: this.documentresultcounter,
                localannotationresultcounter: this.annotationresultcounter,
            }
        },
        computed:
            mapGetters({
                stateDocumentCorpusresults: 'documentcorpus',
                stateAnnotationCorpusresults: 'annotationcorpus'
            }),
        methods: {
            getClass: function () {
                var classes = "collapse";
                if(this.corpusresults.length >= 1){
                    classes += " show"
                }
                return classes;
            },
            resetFilters() {
                this.localcorpusresultcounter = this.corpusresultcounter;
                for(var i = 0; i < this.corpusresults.length; i++) {
                    this.corpusresults[i]._source.visibility = 1;
                    if(this.corpusresults[i]._source.visibility == 0) {
                        this.corpusresults[i]._source.visibility = 1;
                        this.localcorpusresultcounter++;
                    }
                }
                this.$emit('corpus-resultcounter',this.localcorpusresultcounter);

                this.localdocumentresultcounter = this.documentresultcounter;
                for(var i = 0; i < this.documentresults.length; i++) {
                    if(this.documentresults[i]._source.visibility == 0) {
                        this.documentresults[i]._source.visibility = 1;
                        this.localdocumentresultcounter++;
                    }
                }
                this.$emit('document-resultcounter',this.localdocumentresultcounter);


                this.localannotationresultcounter = this.annotationresultcounter;
                for(var i = 0; i < this.annotationresults.length; i++) {
                    if(this.annotationresults[i]._source.visibility == 0) {
                        this.annotationresults[i]._source.visibility = 1;
                        this.localannotationresultcounter++;
                    }
                }
                this.$emit('annotation-resultcounter',this.localannotationresultcounter);


            }
        },
        mounted() {
            console.log('CorpusActiveFilterComponent mounted.')
        }
    }
</script>