
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./filters');
require('lodash');
window.Vue = require('vue');
const util = require('util')
import store from './store'


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('generalsearchwrapper', require('./components/GeneralSearchWrapper.vue'));
Vue.component('searchfilterwrapper', require('./components/SearchFilterWrapper.vue'));
Vue.component('searchresultwrapper', require('./components/SearchResultWrapper.vue'));

Vue.component('activefilter', require('./components/ActiveFilter.vue'));
Vue.component('corpusfilter', require('./components/CorpusFilter.vue'));
Vue.component('documentfilter', require('./components/DocumentFilter.vue'));
Vue.component('annotationfilter', require('./components/AnnotationFilter.vue'));

Vue.component('searchresultheader', require('./components/SearchResultHeader.vue'));
Vue.component('corpussearchresult', require('./components/CorpusSearchResult.vue'));
Vue.component('documentsearchresult', require('./components/DocumentSearchResult.vue'));
Vue.component('annotationsearchresult', require('./components/AnnotationSearchResult.vue'));
Vue.component('pagination', require('./components/Pagination.vue'));

window.axios.defaults.headers.post['Content-Type'] = 'application/json';


const app = new Vue({
    el: '#searchApp',
    store: store,
    data: {
        results: [],
        corpusresults: [],
        documentresults: [],
        annotationresults: [],
        searches: [],
        activefilters: [],
        activefiltersmap: {},
        documentsByCorpus: [],
        annotationsByCorpus: [],
        corpusByDocument: [],
        annotationsByDocument: [],
        documentsByAnnotation: [],
        corpusByAnnotation: [],
        corpusformats: [],
        annotationformats: [],
        datasearched: false,
        dataloading: false,
        documentsearched: false,
        documentloading: false,
        annotationsearched: false,
        corpusCacheString: "",
        documentCacheString: "",
        annotationCacheString: "",
        annotationloading: false,
        postAnnotationData: {},
        corpusresultcounter: 0,
        documentresultcounter: 0,
        annotationresultcounter: 0,
        publishedIndexes: window.laudatioApp.publishedIndexes,
        frontPageResultData: window.laudatioApp.frontPageResultData
    },
    methods: {
        renderArrayToString (array) {
            var string = "";
            if(array){
                if(array.isArray && array.length == 1) {
                    string = array[0].toString();
                }
                else{
                    string = array.toString();
                }
            }

            return string;
        },
        initialSearch: function(){
            this.dataloading = true;
            this.corpusresults = [];
            //this.frontPageResultData = [];
            //this.corpusformats = [];
            //this.annotationformats = [];
            this.datasearched = false;
            this.corpusCacheString = "";
            this.$store.dispatch('clearCorpus', [])
            this.$store.dispatch('clearDocuments', [])
            this.$store.dispatch('clearAnnotations', [])
            this.corpusresults = [];
            this.documentresults = [];
            this.annotationresults = [];
            this.corpusresultcounter = 0;
            this.documentresultcounter = 0;
            this.annotationresultcounter = 0;
            let postData = {
                searchData: {
                    source: [
                        "corpus_title",
                        "corpus_id",
                        "corpus_editor_forename",
                        "corpus_editor_surname",
                        "corpus_publication_publisher",
                        "corpus_documents",
                        "corpus_merged_formats",
                        "corpus_encoding_tool",
                        "corpus_encoding_project_description",
                        "corpus_annotator_forename",
                        "corpus_annotator_surname",
                        "corpus_publication_license",
                        "corpus_languages_language",
                        "corpus_languages_iso_code",
                        "corpus_publication_publication_date",
                        "corpus_size_type",
                        "corpus_size_value",
                        "document_title",
                        "document_author_forename",
                        "document_author_surname",
                        "document_merged_authors",
                        "document_editor_forename",
                        "document_editor_surname",
                        "document_languages_language",
                        "document_languages_iso_code",
                        "document_publication_place",
                        "document_publication_publishing_date",
                        "document_list_of_annotations_id",
                        "document_size_type",
                        "document_size_extent",
                        "preparation_title",
                        "preparation_annotation_id",
                        "preparation_encoding_annotation_group",
                        "preparation_encoding_annotation_sub_group",
                        "preparation_encoding_full_name",
                        "annotation_merged_formats",
                        "in_documents"
                    ],
                    indices: this.publishedIndexes.allPublishedIndices.join(",")
                }
            };

            let corpus_ids = [];
            window.axios.post('api/searchapi/listAllPublished', JSON.stringify(postData)).then(res => {
                if (res.data.results.length > 0) {
                    /*
                     /* @todo: This is far too brittle: corpus/document/annotation could part of someones corpusname
                     /* Also: when we publish, the new working version shuffles the corpus/doc/anno keyword foirther than place 0
                     */
                    for (var ri = 0; ri < res.data.results.length; ri++) {
                        if(res.data.results[ri]._index.indexOf("corpus_") == 0){
                            this.corpusresults.push(res.data.results[ri]);
                            this.corpusresultcounter++;

                            var formatsarray = res.data.results[ri]._source.corpus_merged_formats.split(",");
                            for (var key in formatsarray) {
                                this.corpusformats.push(formatsarray[key])
                            }

                        }
                        else if(res.data.results[ri]._index.indexOf("document_") == 0){
                            this.documentresults.push(res.data.results[ri]);
                            this.documentresultcounter ++;
                        }
                        else if(res.data.results[ri]._index.indexOf("annotation_") == 0){
                            this.annotationresults.push(res.data.results[ri]);
                            this.annotationresultcounter ++;

                            var annotationformatsarray = res.data.results[ri]._source.annotation_merged_formats.split(",");
                            for (var key in annotationformatsarray) {
                                this.annotationformats.push(annotationformatsarray[key])
                            }
                        }///end which index
                    }//end for results
                }//end if results
                this.dataloading = false;
                this.datasearched = true;
                this.searches.push('laudatio_init');
            });
        },
        frontpageSearch: function(){
            this.dataloading = true;
            this.corpusresults = [];
            //this.corpusformats = [];
            //this.annotationformats = [];
            this.datasearched = false;
            this.corpusCacheString = "";
            this.$store.dispatch('clearCorpus', [])
            this.$store.dispatch('clearDocuments', [])
            this.$store.dispatch('clearAnnotations', [])
            this.corpusresults = [];
            this.documentresults = [];
            this.annotationresults = [];
            this.corpusresultcounter = 0;
            this.documentresultcounter = 0;
            this.annotationresultcounter = 0;
            let corpus_ids = [];

            if(this.frontPageResultData != "undefined"){
                for (var ri = 0; ri < this.frontPageResultData.results.length; ri++) {
                    if(this.frontPageResultData.results[ri]._index.indexOf("corpus_") == 0){
                        this.corpusresults.push(this.frontPageResultData.results[ri]);
                        this.corpusresultcounter++;

                        var formatsarray = this.frontPageResultData.results[ri]._source.corpus_merged_formats.split(",");
                        for (var key in formatsarray) {
                            this.corpusformats.push(formatsarray[key])
                        }

                    }
                    else if(this.frontPageResultData.results[ri]._index.indexOf("document_") == 0){
                        this.documentresults.push(this.frontPageResultData.results[ri]);
                        this.documentresultcounter ++;
                    }
                    else if(this.frontPageResultData.results[ri]._index.indexOf("annotation_") == 0){
                        this.annotationresults.push(this.frontPageResultData.results[ri]);
                        this.annotationresultcounter ++;

                        var annotationformatsarray = this.frontPageResultData.results[ri]._source.annotation_merged_formats.split(",");
                        for (var key in annotationformatsarray) {
                            this.annotationformats.push(annotationformatsarray[key])
                        }
                    }///end which index
                }//end for results
                this.dataloading = false;
                this.datasearched = true;
                this.searches.push(this.frontPageResultData.search);
               // this.$set(this.frontPageResultData, undefined)
                //this.frontPageResultData = undefined;
                window.laudatioApp.frontPageResultData = undefined;
            }


        },
        askElastic: function (search) {
            this.dataloading = true;
            this.corpusresults = [];
            //this.frontPageResultData = []
            //this.corpusformats = [];
            //this.annotationformats = [];
            this.datasearched = false;
            this.corpusCacheString = "";
            this.$store.dispatch('clearCorpus', [])
            this.$store.dispatch('clearDocuments', [])
            this.$store.dispatch('clearAnnotations', [])
            this.corpusresults = [];
            this.documentresults = [];
            this.annotationresults = [];
            this.corpusresultcounter = 0;
            this.documentresultcounter = 0;
            this.annotationresultcounter = 0;
            if(search.generalSearchTerm != ""){
                this.searches = [];
                let postData = {
                    searchData: {
                        fields: [
                            "corpus_title",
                            "corpus_editor_forename",
                            "corpus_editor_surname",
                            "corpus_publication_publisher",
                            "corpus_documents",
                            "corpus_merged_formats",
                            "corpus_encoding_tool",
                            "corpus_encoding_project_description",
                            "corpus_annotator_forename",
                            "corpus_annotator_surname",
                            "corpus_publication_license",
                            "corpus_languages_language",
                            "corpus_languages_iso_code",
                            //"corpus_publication_publication_date",
                            "document_title",
                            "document_author_forename",
                            "document_size_type",
                            "document_size_extent",
                            "document_author_surname",
                            "document_editor_forename",
                            "document_editor_surname",
                            "document_languages_language",
                            "document_languages_iso_code",
                            "document_publication_place",
                            "document_merged_authors",
                            //"document_publication_publishing_date",
                            "preparation_title",
                            "preparation_annotation_id",
                            "preparation_encoding_annotation_group",
                            "preparation_encoding_annotation_sub_group",
                            "preparation_encoding_full_name",
                            "annotation_merged_formats"
                        ],
                        source: [
                            "corpus_title",
                            "corpus_id",
                            "corpus_editor_forename",
                            "corpus_editor_surname",
                            "corpus_publication_publisher",
                            "corpus_documents",
                            "corpus_merged_formats",
                            "corpus_encoding_tool",
                            "corpus_encoding_project_description",
                            "corpus_annotator_forename",
                            "corpus_annotator_surname",
                            "corpus_publication_license",
                            "corpus_languages_language",
                            "corpus_languages_iso_code",
                            "corpus_publication_publication_date",
                            "corpus_size_type",
                            "corpus_size_value",
                            "document_title",
                            "document_author_forename",
                            "document_author_surname",
                            "document_merged_authors",
                            "document_editor_forename",
                            "document_editor_surname",
                            "document_languages_language",
                            "document_languages_iso_code",
                            "document_publication_place",
                            "document_publication_publishing_date",
                            "document_list_of_annotations_id",
                            "document_size_type",
                            "document_size_extent",
                            "preparation_title",
                            "preparation_annotation_id",
                            "preparation_encoding_annotation_group",
                            "preparation_encoding_annotation_sub_group",
                            "preparation_encoding_full_name",
                            "annotation_merged_formats",
                            "in_documents"
                        ],
                        query: "" + search.generalSearchTerm + "",
                        indices: this.publishedIndexes.allPublishedIndices.join(",")
                    }
                };

                let corpus_ids = [];
                window.axios.post('api/searchapi/searchGeneral', JSON.stringify(postData)).then(res => {
                    if (res.data.results.length > 0) {
                        /*
                        /* @todo: This is far too brittle: corpus/document/annotation could part of someones corpusname
                        /* Also: when we publish, the new working version shuffles the corpus/doc/anno keyword foirther than place 0
                         */
                        for (var ri = 0; ri < res.data.results.length; ri++) {
                            if(res.data.results[ri]._index.indexOf("corpus_") == 0){
                                this.corpusresults.push(res.data.results[ri]);
                                this.corpusresultcounter++;

                                var formatsarray = res.data.results[ri]._source.corpus_merged_formats.split(",");
                                for (var key in formatsarray) {
                                    this.corpusformats.push(formatsarray[key])
                                }

                            }
                            else if(res.data.results[ri]._index.indexOf("document_") == 0){
                                this.documentresults.push(res.data.results[ri]);
                                this.documentresultcounter ++;
                            }
                            else if(res.data.results[ri]._index.indexOf("annotation_") == 0){
                                this.annotationresults.push(res.data.results[ri]);
                                this.annotationresultcounter ++;

                                var annotationformatsarray = res.data.results[ri]._source.annotation_merged_formats.split(",");
                                for (var key in annotationformatsarray) {
                                    this.annotationformats.push(annotationformatsarray[key])
                                }
                            }///end which index
                        }//end for results
                    }//end if results
                    this.dataloading = false;
                    this.datasearched = true;
                    this.searches.push(search.generalSearchTerm);
                });


            }
            else{
                this.dataloading = false;
            }

        },
        submitCorpusFilter: function (corpusFilterObject) {
            for(var key in corpusFilterObject) {
                if (corpusFilterObject.hasOwnProperty(key)) {
                    if (corpusFilterObject[key] != 'undefined' && corpusFilterObject[key] != '') {

                        if(key == "corpus_publication_publication_date" || key == "corpusYearTo"  || key == "corpus_publication_license" || key == "corpus_merged_formats" || key == "corpus_size_value" || key == "corpusSizeTo" ) {
                            if(key == "corpus_size_value" && corpusFilterObject.corpus_size_value != ""  && corpusFilterObject.corpusSizeTo != "") {
                                if(corpusFilterObject.corpus_size_value > 1 ||  corpusFilterObject.corpusSizeTo < 999999){
                                    if(!this.activefilters.includes('C_'+corpusFilterObject.corpus_size_value+":"+corpusFilterObject.corpusSizeTo)
                                        && !this.activefiltersmap.hasOwnProperty('C_'+corpusFilterObject.corpus_size_value+":"+corpusFilterObject.corpusSizeTo)
                                    ) {
                                        this.activefilters.push('C_'+corpusFilterObject.corpus_size_value+":"+corpusFilterObject.corpusSizeTo);
                                        this.activefiltersmap['C_'+corpusFilterObject.corpus_size_value+":"+corpusFilterObject.corpusSizeTo] = key;
                                    }
                                }
                            }
                            if(key == "corpus_merged_formats" && corpusFilterObject.corpus_merged_formats != ""){
                                for (var formatkey in corpusFilterObject.corpus_merged_formats) {
                                    if(
                                        !this.activefilters.includes(corpusFilterObject.corpus_merged_formats[formatkey])
                                        && !this.activefiltersmap.hasOwnProperty(corpusFilterObject.corpus_merged_formats[formatkey])
                                        &&
                                        !this.activefilters.includes('C_'+corpusFilterObject.corpus_merged_formats[formatkey])
                                        && !this.activefiltersmap.hasOwnProperty('C_'+corpusFilterObject.corpus_merged_formats[formatkey])) {
                                        this.activefilters.push('C_'+corpusFilterObject.corpus_merged_formats[formatkey]);
                                        this.activefiltersmap['C_'+corpusFilterObject.corpus_merged_formats[formatkey]] = 'corpus_merged_formats';
                                    }

                                }
                            }
                            if(key == "corpus_publication_license" && corpusFilterObject[key].toLowerCase() != "") {
                                if(corpusFilterObject[key].indexOf('C_') == -1
                                    && !this.activefilters.includes(corpusFilterObject[key]) && !this.activefiltersmap.hasOwnProperty(corpusFilterObject[key])
                                    && !this.activefilters.includes('C_'+corpusFilterObject[key]) && !this.activefiltersmap.hasOwnProperty('C_'+corpusFilterObject[key])) {
                                    this.activefilters.push('C_'+corpusFilterObject[key]);
                                    this.activefiltersmap['C_'+corpusFilterObject[key]] = key;
                                }
                            }
                            if(key == "corpus_publication_publication_date" && corpusFilterObject.corpus_publication_publication_date != '' && corpusFilterObject.corpusYearTo != '') {
                                if(!this.activefilters.includes('C_'+corpusFilterObject.corpus_publication_publication_date+":"+corpusFilterObject.corpusYearTo)
                                        && !this.activefiltersmap.hasOwnProperty('C_'+corpusFilterObject.corpus_publication_publication_date + ":" + corpusFilterObject.corpusYearTo)) {
                                    this.activefilters.push('C_'+corpusFilterObject.corpus_publication_publication_date + ":" + corpusFilterObject.corpusYearTo);
                                    this.activefiltersmap['C_'+corpusFilterObject.corpus_publication_publication_date + ":" + corpusFilterObject.corpusYearTo] = key;
                                }
                            }
                        }
                        else{
                            if(key.indexOf('corpus') > -1) {
                                if (corpusFilterObject[key].indexOf('C_') == -1
                                    && !this.activefilters.includes(corpusFilterObject[key]) && !this.activefiltersmap.hasOwnProperty(corpusFilterObject[key])
                                    && !this.activefilters.includes('C_'+corpusFilterObject[key]) && !this.activefiltersmap.hasOwnProperty('C_'+corpusFilterObject[key])) {
                                    this.activefilters.push('C_'+corpusFilterObject[key]);
                                    this.activefiltersmap['C_'+corpusFilterObject[key]] = key;
                                }
                            }
                        }
                    }
                }
            }
            this.filterCorpusResults(corpusFilterObject);
        },
        filterCorpusResults: function (corpusFilterObject){
            this.resetCorpusResults();
            var matches = [];
            var activeFilterCount = this.getActiveFilterCount("corpus");
            for(var i = 0; i < this.activefilters.length; i++) {
                var filterkey = this.activefiltersmap[this.activefilters[i]];


                if(typeof filterkey != 'undefined' && filterkey != 'undefined') {
                    var filtervalue = this.activefilters[i];
                    filtervalue = filtervalue.replace("C_","");

                    for(var j = 0; j < this.corpusresults.length; j++) {
                        if (filterkey == "corpus_publication_publication_date" || filterkey == "corpusYearTo" || filterkey == "corpus_publication_license" || filterkey == "corpus_merged_formats" || filterkey == "corpus_size_value"|| filterkey == "corpusSizeTo" ) {

                            if(filterkey == "corpus_size_value" && corpusFilterObject.corpus_size_value != ""  && corpusFilterObject.corpusSizeTo != "") {
                                if(this.isBetween(this.corpusresults[j]._source[filterkey][0], corpusFilterObject.corpus_size_value,corpusFilterObject.corpusSizeTo)){
                                    if(!matches.includes(this.corpusresults[j]._id)){
                                        matches.push(this.corpusresults[j]._id);
                                    }
                                }

                            }

                            if(filterkey == "corpus_merged_formats" && corpusFilterObject.corpus_merged_formats != ""){
                                for (var formatkey in corpusFilterObject.corpus_merged_formats) {

                                    if(this.hasFormats(this.corpusresults[j]._source[filterkey],corpusFilterObject.corpus_merged_formats[formatkey])){

                                        if(!matches.includes(this.corpusresults[j]._id)){
                                            matches.push(this.corpusresults[j]._id);
                                        }
                                    }
                                }
                            }

                            if(filterkey == "corpus_publication_license" && corpusFilterObject[filterkey].toLowerCase() != "") {
                                if(this.hasLicense(this.renderArrayToString(this.corpusresults[j]._source[filterkey]).toLowerCase(), corpusFilterObject[filterkey].toLowerCase())){

                                    if(!matches.includes(this.corpusresults[j]._id)){
                                        matches.push(this.corpusresults[j]._id);
                                    }
                                }
                            }

                            if(filterkey == "corpus_publication_publication_date" && corpusFilterObject.corpus_publication_publication_date != '' && corpusFilterObject.corpusYearTo != '') {
                                var newest_datum = this.corpusresults[j]._source[filterkey][(this.corpusresults[j]._source[filterkey].length -1)];
                                var dateArray = newest_datum.split("-");
                                var newest_date = dateArray[0];
                                if( this.isBetween(newest_date, corpusFilterObject.corpus_publication_publication_date,corpusFilterObject.corpusYearTo)){

                                    if(!matches.includes(this.corpusresults[j]._id)){
                                        matches.push(this.corpusresults[j]._id);
                                    }

                                }
                            }
                        }
                        else {
                            if(filterkey.indexOf('corpus') > -1){
                                if(this.renderArrayToString(this.corpusresults[j]._source[filterkey]).toLowerCase().indexOf(filtervalue.toLowerCase()) > -1) {
                                    if(!matches.includes(this.corpusresults[j]._id)){
                                        matches.push(this.corpusresults[j]._id);
                                    }
                                }
                            }
                        }
                    }//end for
                }//end if filterkey

            }

            if(matches.length > 0) {
                for(var k = 0; k < this.corpusresults.length; k++) {
                    if(!matches.includes(this.corpusresults[k]._id)){
                        this.corpusresults[k]._source.visibility = 0;
                        this.corpusresultcounter--;
                    }
                }
            }

        },
        submitDocumentFilter: function (documentFilterObject) {
            for(var key in documentFilterObject) {
                if (documentFilterObject.hasOwnProperty(key)) {
                    if (documentFilterObject[key] != 'undefined' && documentFilterObject[key] != '') {
                        if (key == "document_size_extent" || key == "document_publication_publishing_date" || key == "document_size_extent_to" || key == 'document_publication_publishing_date_to') {

                            if(key == "document_size_extent"  && documentFilterObject.document_size_extent != ""  && documentFilterObject.document_size_extent_to != "") {
                                if(documentFilterObject.document_size_extent > 1 ||   documentFilterObject.document_size_extent_to  < 999999){
                                    if(!this.activefilters.includes('D_'+documentFilterObject.document_size_extent+":"+documentFilterObject.document_size_extent_to)
                                        && !this.activefiltersmap.hasOwnProperty('D_'+documentFilterObject.document_size_extent+":"+documentFilterObject.document_size_extent_to)) {
                                        this.activefilters.push('D_'+documentFilterObject.document_size_extent+":"+documentFilterObject.document_size_extent_to);
                                        this.activefiltersmap['D_'+documentFilterObject.document_size_extent+":"+documentFilterObject.document_size_extent_to] = key;
                                    }
                                }

                            }//end if document_size_extent

                            if(key == "document_publication_publishing_date" && documentFilterObject.document_publication_publishing_date != '' && documentFilterObject.document_publication_publishing_date_to != '') {
                                if(!this.activefilters.includes('D_'+documentFilterObject.document_publication_publishing_date+":"+documentFilterObject.document_publication_publishing_date_to)
                                    && !this.activefiltersmap.hasOwnProperty('D_'+documentFilterObject.document_publication_publishing_date+":"+documentFilterObject.document_publication_publishing_date_to)) {
                                    this.activefilters.push('D_'+documentFilterObject.document_publication_publishing_date+":"+documentFilterObject.document_publication_publishing_date_to);
                                    this.activefiltersmap['D_'+documentFilterObject.document_publication_publishing_date+":"+documentFilterObject.document_publication_publishing_date_to] = key;
                                }
                            }//end if publishing date

                        }
                        else {
                            if(key.indexOf('document') > -1){
                                if( documentFilterObject[key].indexOf('D_') == -1
                                    && !this.activefilters.includes(documentFilterObject[key]) && !this.activefiltersmap.hasOwnProperty(documentFilterObject[key])
                                    && !this.activefilters.includes('D_'+documentFilterObject[key]) && !this.activefiltersmap.hasOwnProperty('D_'+documentFilterObject[key])
                                ) {
                                    this.activefilters.push('D_'+documentFilterObject[key]);
                                    this.activefiltersmap['D_'+documentFilterObject[key]] = key;
                                }
                            }
                        }
                    }
                }
            }
            this.filterDocumentResults(documentFilterObject);
        },
        filterDocumentResults: function(documentFilterObject) {
            this.resetDocumentResults();
            var matches = [];

            for(var i = 0; i < this.activefilters.length; i++) {
                var filterkey = this.activefiltersmap[this.activefilters[i]];
                var filtervalue = this.activefilters[i];
                filtervalue = filtervalue.replace("D_","");

                for(var j = 0; j < this.documentresults.length; j++) {
                    if(filterkey == "document_size_extent" || filterkey == "document_publication_publishing_date" || filterkey == "document_size_extent_to" || filterkey == 'document_publication_publishing_date_to') {

                        if(filterkey == "document_size_extent"  && documentFilterObject.document_size_extent != ""  && documentFilterObject.document_size_extent_to != "") {
                            if(this.isBetween(this.documentresults[j]._source[filterkey][0], documentFilterObject.document_size_extent,documentFilterObject.document_size_extent_to)){
                                if(!matches.includes(this.documentresults[j]._id)){
                                    matches.push(this.documentresults[j]._id);
                                }
                            }
                        }//end if document_size_extent

                        if(filterkey == "document_publication_publishing_date" && documentFilterObject.document_publication_publishing_date != '' && documentFilterObject.document_publication_publishing_date_to != '') {
                            var newest_datum = this.documentresults[j]._source[filterkey][(this.documentresults[j]._source[filterkey].length -1)];
                            var newest_date = newest_datum;
                            if(newest_datum.indexOf("-") > -1){
                                var dateArray = newest_datum.split("-");
                                newest_date = dateArray[0];
                            }


                            if(this.isBetween(newest_date, documentFilterObject.document_publication_publishing_date,documentFilterObject.document_publication_publishing_date_to)){
                                if(!matches.includes(this.documentresults[j]._id)){
                                    matches.push(this.documentresults[j]._id);
                                }
                            }
                        }//end if publishing date

                    }
                    else {
                        if(filterkey.indexOf('document') > -1) {
                            if (this.renderArrayToString(this.documentresults[j]._source[filterkey]).toLowerCase().indexOf(filtervalue.toLowerCase()) > -1) {
                                if (!matches.includes(this.documentresults[j]._id)) {
                                    matches.push(this.documentresults[j]._id);
                                }
                            }
                        }
                    }
                }//end for documentresults
            }//end for activefilters

            if(matches.length > 0) {
                for (var k = 0; k < this.documentresults.length; k++) {
                    if (!matches.includes(this.documentresults[k]._id)) {
                        this.documentresults[k]._source.visibility = 0;
                        this.documentresultcounter--;
                    }
                }
            }
        },
        submitAnnotationFilter: function (annotationFilterObject) {
            for(var key in annotationFilterObject) {
                if (annotationFilterObject.hasOwnProperty(key)) {
                    if (annotationFilterObject[key] != 'undefined' && annotationFilterObject[key] != '') {
                        if (key == "annotation_merged_formats") {

                            for (var formatkey in annotationFilterObject.annotation_merged_formats) {
                                if(!this.activefilters.includes('A_'+annotationFilterObject.annotation_merged_formats[formatkey])) {
                                    this.activefilters.push('A_'+annotationFilterObject.annotation_merged_formats[formatkey]);
                                    this.activefiltersmap['A_'+annotationFilterObject.annotation_merged_formats[formatkey]] = 'annotation_merged_formats';
                                }
                            }

                        }
                        else {
                            if(key.indexOf('preparation') > -1){
                                if(annotationFilterObject[key].indexOf('D_') == -1
                                    && !this.activefilters.includes(annotationFilterObject[key]) && !this.activefiltersmap.hasOwnProperty(annotationFilterObject[key])
                                        && !this.activefilters.includes('A_'+annotationFilterObject[key]) && !this.activefiltersmap.hasOwnProperty('A_'+annotationFilterObject[key])
                                    ) {
                                    this.activefilters.push('A_'+annotationFilterObject[key]);
                                    this.activefiltersmap['A_'+annotationFilterObject[key]] = key;
                                }
                            }
                        }
                    }
                }
            }
            this.filterAnnotationResults(annotationFilterObject);
        },
        filterAnnotationResults: function(annotationFilterObject){
            this.resetAnnotationResults();
            var matches = [];

            for(var i = 0; i < this.activefilters.length; i++) {
                var filterkey = this.activefiltersmap[this.activefilters[i]];
                var filtervalue = this.activefilters[i];
                filtervalue = filtervalue.replace("A_","");
                for(var j = 0; j < this.annotationresults.length; j++) {
                    if(filterkey == "annotation_merged_formats") {


                        for (var formatkey in annotationFilterObject.annotation_merged_formats) {

                            if(this.hasFormats(this.annotationresults[j]._source[filterkey],annotationFilterObject.annotation_merged_formats[formatkey])){

                                if(!matches.includes(this.annotationresults[j]._id)){
                                    matches.push(this.annotationresults[j]._id);
                                }
                            }
                        }
                    }
                    else {
                        if(filterkey.indexOf('preparation') > -1) {
                            if (this.renderArrayToString(this.annotationresults[j]._source[filterkey]).toLowerCase().indexOf(filtervalue.toLowerCase()) > -1) {
                                if (!matches.includes(this.annotationresults[j]._id)) {
                                    matches.push(this.annotationresults[j]._id);
                                }
                            }
                        }
                    }
                }//end for documentresults
            }//end for activefilters

            if(matches.length > 0) {
                for (var k = 0; k < this.annotationresults.length; k++) {
                    if (!matches.includes(this.annotationresults[k]._id)) {
                        this.annotationresults[k]._source.visibility = 0;
                        this.annotationresultcounter--;
                    }
                }
            }
        },
        resetActiveFilter: function(filter) {
            var key = this.activefiltersmap[filter];
            if(typeof filter != 'undefined' && this.activefiltersmap.hasOwnProperty(filter)){
                this.activefilters.splice(this.activefilters.indexOf(filter),1);
                delete this.activefiltersmap[filter];
                if(key == "corpus_size_value"){
                    this.$refs.filterwrapper.$refs.corpusFilter.resetNoUiSlider();
                }
                else if(key == "document_size_extent"){
                    this.$refs.filterwrapper.$refs.documentFilter.resetNoUiSlider();
                }
                else if(key == "corpus_merged_formats") {
                    this.$refs.filterwrapper.$refs.corpusFilter.resetFormatField(filter.replace("C_",""));
                }
                else if(key == "annotation_merged_formats") {
                    this.$refs.filterwrapper.$refs.annotationFilter.resetFormatField(filter.replace("A_",""));
                }
            }
            

            if(typeof key != 'undefined') {
                if(key.indexOf('corpus') > -1) {
                    for(var i = 0; i < this.corpusresults.length; i++) {
                        if (this.corpusresults[i]._source.hasOwnProperty(key)){
                            if(this.corpusresults[i]._source.visibility == 0) {
                                this.corpusresults[i]._source.visibility = 1;
                                this.corpusresultcounter++;
                            }
                        }
                    }

                    var corpusFilterData = {}
                    var j = 0;
                    if(this.activefilters.length > 0) {
                        for(j = j; j < this.activefilters.length; j++) {
                            var active_key = this.activefiltersmap[this.activefilters[j]];

                            if(active_key == 'corpus_merged_formats') {
                                corpusFilterData[active_key] = [this.activefilters[j]];
                            }
                            else if(active_key == 'corpus_size_value') {
                                var numberarray = this.activefilters[j].split(":");
                                corpusFilterData['corpus_size_value'] = numberarray[0].trim().replace("C_","");
                                corpusFilterData['corpusSizeTo'] = numberarray[1].trim();
                            }
                            else if(active_key == 'corpus_publication_publication_date') {
                                var numberarray = this.activefilters[j].split(":");
                                corpusFilterData['corpus_publication_publication_date'] = numberarray[0].trim();
                                corpusFilterData['corpusYearTo'] = numberarray[1].trim();
                            }
                            else{
                                corpusFilterData[active_key] = this.activefilters[j];
                            }

                        }
                    }


                    if(j > 0) {
                        this.submitCorpusFilter(corpusFilterData);
                    }

                }
                else if(key.indexOf('document') > -1) {
                    for(var i = 0; i < this.documentresults.length; i++) {
                        if (this.documentresults[i]._source.hasOwnProperty(key)){
                            if(this.documentresults[i]._source.visibility == 0) {
                                this.documentresults[i]._source.visibility = 1;
                                this.documentresultcounter++;
                            }
                        }
                    }//end for

                    var documentFilterData = {}
                    var j = 0;
                    if(this.activefilters.length > 0) {
                        for(var j = j; j < this.activefilters.length; j++) {
                            var active_key = this.activefiltersmap[this.activefilters[j]];
                            if(active_key == 'document_size_extent'){
                                var numberarray = this.activefilters[j].split(":");
                                documentFilterData['document_size_extent'] = numberarray[0].trim().replace("D_","");
                                documentFilterData['document_size_extent_to'] = numberarray[1].trim();
                            }
                            else  if(active_key == 'document_publication_publishing_date'){
                                var publishingnumberarray = this.activefilters[j].split(":");
                                documentFilterData['document_publication_publishing_date'] = publishingnumberarray[0].trim();
                                documentFilterData['document_publication_publishing_date_to'] = publishingnumberarray[1].trim();
                            }
                            else{
                                documentFilterData[active_key] = this.activefilters[j];
                            }
                        }
                    }

                    if(j > 0) {
                        this.submitDocumentFilter(documentFilterData);
                    }

                }
                else if(key.indexOf('annotation') > -1 || key.indexOf('preparation') > -1) {
                    for(var i = 0; i < this.annotationresults.length; i++) {
                        if (this.annotationresults[i]._source.hasOwnProperty(key)){
                            if(this.annotationresults[i]._source.visibility == 0) {
                                this.annotationresults[i]._source.visibility = 1;
                                this.annotationresultcounter++;
                            }
                        }
                    }//end for

                    var annotationFilterData = {}
                    if(this.activefilters.length > 0) {
                        for(var j = 0; j < this.activefilters.length; j++) {
                            var active_key = this.activefiltersmap[this.activefilters[j]];
                            if(active_key == 'annotation_merged_formats') {
                                annotationFilterData[active_key] = [this.activefilters[j]];
                            }
                            else{
                                annotationFilterData[active_key] = this.activefilters[j];
                            }

                        }
                    }

                    this.submitAnnotationFilter(annotationFilterData);
                }
            }

        },
        resetActiveFilters: function () {
            this.activefilters = []
            this.activefiltersmap = {}
        },
        resetCorpusResults() {
            for(var i = 0; i < this.corpusresults.length; i++) {
                if(this.corpusresults[i]._source.visibility == 0) {
                    this.corpusresults[i]._source.visibility = 1;
                    this.corpusresultcounter++;
                }
            }
        },
        resetDocumentResults() {
            for(var i = 0; i < this.documentresults.length; i++) {
                if(this.documentresults[i]._source.visibility == 0) {
                    this.documentresults[i]._source.visibility = 1;
                    this.documentresultcounter++;
                }
            }
        },
        resetAnnotationResults() {
            for(var i = 0; i < this.annotationresults.length; i++) {
                if(this.annotationresults[i]._source.visibility == 0) {
                    this.annotationresults[i]._source.visibility = 1;
                    this.annotationresultcounter++;
                }
            }
        },
        updateCorpusCounter: function (counter) {
            this.corpusresultcounter = counter;
        },
        updateDocumentCounter: function (counter) {
            this.documentresultcounter = counter;
        },
        updateAnnotationCounter: function (counter) {
            this.annotationresultcounter = counter;
        },
        isBetween: function(theNumber, min, max) {

            if(parseInt(theNumber.replace(".","")) >= Math.floor(min) && parseInt(theNumber.replace(".","")) <= Math.floor(max)){
                return true;
            }
            else if(parseInt(theNumber.replace(".","")) >= parseInt(min) && parseInt(theNumber.replace(".","")) <= parseInt(max)){
                return true;
            }
            else{
                return false
            }
        },
        hasLicense: function(license, filter) {
            var licenseArray = license.split("/");
            var ccLicense = licenseArray[4];
            return ccLicense == filter;
        },
        hasFormats: function(merged_formats,filter_formats) {
            return merged_formats.indexOf(filter_formats) > -1;
        },
        getActiveFilterCount: function(type) {
            var activeFilterCount = 0;
            for(var key in this.activefiltersmap) {
                if(this.activefiltersmap[key].indexOf(type) > -1) {
                    activeFilterCount++;
                }
            }
            return activeFilterCount;
        }
    }
});
