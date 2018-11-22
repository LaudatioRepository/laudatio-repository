<template>
    <div class="card">
        <div class="card-header btn bg-corpus-mid font-weight-bold text-uppercase d-flex justify-content-between align-items-center"
             data-toggle="collapse" data-target="#formPanelCorpus" aria-expanded="true" aria-controls="formPanelCorpus">
            <span>Corpus</span>
            <i class="collapse-indicator fa fa-chevron-circle-down fa-fw fa-lg text-16"></i>
        </div>
        <div v-bind:class="getClass()" id="formPanelCorpus">
            <div class="card-body px-2">
                <form action="">
                    <div class="form-group mb-3">
                        <label class="mb-0 text-14 " for="formCorpusTitle">Title</label>
                        <input type="text" class="form-control" id="formCorpusTitle" aria-describedby="inputTitle" placeholder='"Ridges herbology"' v-model="corpusFilterData.corpus_title">
                    </div>

                    <div class="form-group mb-3">
                        <label class="mb-0 text-14 " for="formCorpusLanguage">Language</label>
                        <input type="text" class="form-control" id="formCorpusLanguage" aria-describedby="inputLanguage" placeholder='"German"' v-model="corpusFilterData.corpus_merged_languages">
                    </div>

                    <div class="d-flex flex-column">
                        <a class="align-self-end text-uppercase text-dark text-14 filter-expander" data-toggle="collapse" href="#"
                           data-target=".formPanelCorpus-all" role="button" aria-expanded="false" aria-controls="#formPanelCorpus-all1 #formPanelCorpus-all2">
                            + Show all Corpusfilter
                        </a>
                    </div>

                    <div id="formPanelCorpus-all1" class="collapse formPanelCorpus-all">

                        <div class="form-group mb-3">
                            <label class="mb-0 text-14 " for="formCorpusPublisher">Publisher</label>
                            <input type="text" class="form-control" id="formCorpusPublisher" aria-describedby="inputPublisher" placeholder='"Humboldt Universität"' v-model="corpusFilterData.corpus_publication_publisher">
                        </div>

                        <div class="form-group mb-3">
                            <label class="mb-0 text-14 " for="formCorpusFormats">Formats</label>
                            <input type="text" name="formatslist" multiple="multiple" list="formatsList-Corpus" class="flexdatalist corpusformatslist form-control"
                                   data-min-length="0" id="formCorpusFormats" v-model="corpusFilterData.corpus_merged_formats" >
                            <datalist id="formatsList-Corpus">
                                <!--[if IE 9]><select disabled style="display:none" class="ie9_fix"><![endif]-->
                                <option v-for="corpusformat in this.uniqueArray(corpusformats)" v-bind:corpusformat="corpusformat">{{corpusformat}}</option>
                                <!--[if IE 9]></select><![endif]-->
                            </datalist>
                        </div>

                        <div class="form-group mb-3">
                            <label class="mb-0 text-14 " for="formCorpusLicenses">License</label>
                            <input type="text" class="form-control" id="formCorpusLicenses" aria-describedby="inputLicenses" placeholder='"by-sa"' v-model="corpusFilterData.corpus_publication_license">
                        </div>
                    </div>
                </form>

                <div id="formPanelCorpus-all2" class="collapse formPanelCorpus-all">


                    <form action="">
                        <div class="form-group mb-3">
                            <label class="mb-2 text-14 " for="dd">Corpus size (Tokens, Words)</label>
                            <div class="d-flex justify-content-between">
                                <div class="w-75">
                                    <div id="corpusSize"></div>
                                    <div class="d-flex justify-content-between w-100 text-dark font-weight-bold text-14">
                                        <span id="corpusSize-minVal">
                                        </span>
                                        <span id="corpusSize-maxVal">
                                        </span>
                                    </div>
                                </div>
                                <!--button type="submit" class="disabled btn btn-sm btn-corpus-dark p-0">
                                    <i class="fa fa-angle-right fa-fw fa-2x py-1"></i>
                                </button-->
                            </div>
                        </div>
                    </form>

                    <form action="">
                        <div class="form-group mb-3">
                            <label class="mb-0 text-14 " for="formCorpusYear">Year of Publication</label>
                            <div class="d-flex justify-content-between">
                                <div class="d-flex flex-column w-35">
                                    <small id="yearFromHelp" class="form-text text-muted">from</small>
                                    <input class="toBeValidated form-control" placeholder="J J J J" type="number" min="1" max="9999" step="1"
                                           name="yearFrom" id="formCorpusYearFrom"  v-model="corpusFilterData.corpus_publication_publication_date" />
                                </div>
                                <div class="d-flex flex-column w-35">
                                    <small id="yearToHelp" class="form-text text-muted">to</small>
                                    <input class="toBeValidated form-control" placeholder="J J J J" type="number" min="1" max="9999" step="1"
                                           name="yearTo" id="formCorpusYearTo" v-model="corpusFilterData.corpusYearTo"  />
                                </div>
                                <!--button type="submit" class="toCheckValidation disabled btn btn-sm btn-corpus-dark ml-3 p-0 align-self-end">
                                    <i class="fa fa-angle-right fa-fw fa-2x py-1"></i>
                                </button-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapState, mapActions, mapGetters } from 'vuex'
    export default {
        props: ['corpusresults','documentresults','annotationresults','corpusformats'],
        data: function(){
            return {
                corpusFilterData : {
                    corpus_title: '',
                    corpus_publication_publisher: '',
                    corpus_publication_publication_date: '',
                    corpusYearTo: '',
                    corpus_size_value: '',
                    corpusSizeTo: '',
                    corpus_merged_languages: '',
                    corpus_merged_formats: [],
                    corpus_publication_license: ''
                },
                scope: 'corpus'
            }
        },
        methods: {
            emitCorpusFilter(){
                this.$emit('corpus-filter',this.corpusFilterData);
            },
            clearCorpusFilter: function () {
                this.corpusFilterData = {
                    corpus_title: '',
                        corpus_publication_publisher: '',
                        corpus_publication_publication_date: '',
                        corpusYearTo: '',
                        corpus_size_value: '',
                        corpusSizeTo: '',
                        corpus_merged_languages: '',
                        corpus_merged_formats: [],
                        corpus_publication_license: ''
                }
                //There is some strange bug somewhere that makes it impossible to add a filter twice after the following purge:
                $('#formPanelCorpus').find("ul.flexdatalist-multiple li.value").remove();
            },
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
            uniqueArray: function (a) {
                return [ ...new Set(a) ]
            }
        },
        mounted() {
            let mycorpusvue = this;

            var rangeSliderList = ['corpusSize']

            for(var h = 0; h < rangeSliderList.length; h++) {
                let i = h

                let el = document.getElementById(rangeSliderList[i])

                if(el) {
                    //console.log("el: "+el)
                    el.style.height = '8px';
                    el.style.margin = '0 auto 8px';

                    noUiSlider.create(el, {
                        animate: true,
                        start: [ 1, 999999 ], // 4 handles, starting at...
                        margin: 1, // Handles must be at least 300 apart
                        limit: 999998, // ... but no more than 600
                        connect: true, // Display a colored bar between the handles
                        orientation: 'horizontal', // Orient the slider vertically
                        behaviour: 'tap-drag', // Move handle on tap, bar is draggable
                        step: 1,

                        range: {
                            'min': 1,
                            'max': 999999
                        },
                    });

                    let paddingMin = document.getElementById(rangeSliderList[i] + '-minVal'),
                        paddingMax = document.getElementById(rangeSliderList[i] + '-maxVal');

                    el.noUiSlider.on('update', function ( values, handle ) {

                        if ( handle ) {
                            //this.corpusFilterData
                            //console.log($(el).attr("id")+handle+" => "+values+" LAST: "+values[handle])
                            mycorpusvue.corpusFilterData.corpusSizeTo = Math.round(values[handle]);
                            paddingMax.innerHTML = Math.round(values[handle]);

                        } else {
                            //console.log($(el).attr("id")+handle+" => "+values+" FIRST: "+values[handle])
                            mycorpusvue.corpusFilterData.corpus_size_value = Math.round(values[handle]);
                            paddingMin.innerHTML = Math.round(values[handle]);
                        }
                    });

                    el.noUiSlider.on('change', function(){
                        // Validate corresponding form
                        let parentForm = $(el).closest('form')
                        $(parentForm).find('*[type=submit]').removeClass('disabled');
                    });
                }
            }//end for

            $('input.flexdatalist').on('select:flexdatalist', function(event, set, options) {
                if(mycorpusvue != 'undefined' && $(this).hasClass('corpusformatslist')){
                    mycorpusvue.corpusFilterData.corpus_merged_formats.push(set.value)
                }
            });

        }
    }
</script>