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
        props: ['corpusresults','activefilters'],
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
                for(var i = 0; i < this.corpusresults.length; i++) {
                    this.corpusresults[i]._source.visibility = 1;
                }
            }
        },
        mounted() {
            console.log('CorpusActiveFilterComponent mounted.')
        }
    }
</script>