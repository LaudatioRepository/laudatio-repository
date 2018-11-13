<template>
    <div class="card">
        <div class="card-header btn bg-corpus-mid font-weight-bold text-uppercase d-flex justify-content-between align-items-center"
             data-toggle="collapse" data-target="#formPanelAnnotations" aria-expanded="true" aria-controls="formPanelAnnotations">
            <span>Annotations</span>
            <i class="collapse-indicator fa fa-chevron-circle-down fa-fw fa-lg text-16"></i>
        </div>
        <div v-bind:class="getClass()"  id="formPanelAnnotations">
            <div class="card-body px-2">
                <form action="">
                    <div class="form-group mb-3">
                        <label class="mb-0 text-14 " for="formAnnotationsTitle">Name</label>
                        <input type="text" class="form-control" id="formAnnotationsTitle" aria-describedby="inputName" placeholder='"Ridges herbology"'>
                    </div>

                    <div class="form-group mb-3">
                        <label class="mb-0 text-14 " for="formAnnotationsLanguage">Category</label>
                        <input type="text" class="form-control" id="formAnnotationsLanguage" aria-describedby="inputCategory"
                               placeholder='"German"'>
                    </div>

                    <div class="form-group mb-3">
                        <label class="mb-0 text-14 " for="formAnnotationsFormats">Formats</label>
                        <input type="text" name="formatslist" multiple="multiple" list="formatsList-Annotations" class="flexdatalist form-control"
                               data-min-length="0" id="formAnnotationsFormats">
                        <datalist id="formatsList-Annotations">
                            <!--[if IE 9]><select disabled style="display:none" class="ie9_fix"><![endif]-->
                            <option value="ANNIS">ANNIS</option>
                            <option value="EXEL">EXEL</option>
                            <option value="PAULA">PAULA</option>
                            <option value="Negra">Negra</option>
                            <option value="TEI-Header">TEI-Header</option>
                            <!--[if IE 9]></select><![endif]-->
                        </datalist>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapState, mapActions, mapGetters } from 'vuex'
    export default {
        props: ['corpusresults'],
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
            }
        },
        mounted() {
            console.log('CorpusActiveFilterComponent mounted.')
        }
    }
</script>