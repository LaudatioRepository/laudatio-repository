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
                        <input type="text" class="form-control" id="formAnnotationsTitle" aria-describedby="inputName" placeholder='"norm"'  v-model="annotationFilterData.preparation_title">
                    </div>

                    <div class="form-group mb-3">
                        <label class="mb-0 text-14 " for="formAnnotationsLanguage">Category</label>
                        <input type="text" class="form-control" id="formAnnotationsLanguage" aria-describedby="inputCategory"
                               placeholder='"Lexical"' v-model="annotationFilterData.preparation_encoding_annotation_group">
                    </div>

                    <div class="form-group mb-3">
                        <label class="mb-0 text-14 " for="formAnnotationsFormats">Formats</label>
                        <input type="text" name="formatslist" multiple="multiple" list="formatsList-Annotations" class="flexdatalist form-control"
                               data-min-length="0" id="formAnnotationsFormats" v-model="annotationFilterData.preparation_encoding_annotation_group">
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
        props: ['corpusresults','documentresults','annotationresults'],
        data: function() {
            return {
                annotationFilterData : {
                    preparation_title: '',
                    annotation_merged_formats: [],
                    preparation_encoding_annotation_group: '',
                },
                scope: 'annotation'
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
                if(
                    this.corpusresults.length >= 1 ||
                    this.documentresults.length >= 1 ||
                    this.annotationresults.length >= 1
                ){
                    classes += " show"
                }
                return classes;
            },
            emitAnnotationFilter: function () {
                this.$emit('annotation-filter',this.annotationFilterData);
            }
        },
        mounted() {
            console.log('AnnotationFilterComponent mounted.')
            let myvue = this;
            $('input.flexdatalist').on('select:flexdatalist', function(event, set, options) {
                console.log(set.value);
                if(myvue != 'undefined'){
                    myvue.annotationFilterData.annotation_merged_formats.push(set.value)
                }
                console.log("PPOP"+JSON.stringify(myvue.annotationFilterData));
            });
        }
    }
</script>