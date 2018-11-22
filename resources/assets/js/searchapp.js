
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
        publishedIndexes: window.laudatioApp.publishedIndexes
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
        askElastic: function (search) {
            this.dataloading = true;
            this.corpusresults = [];
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
            this.resetCorpusResults();
            for(var i = 0; i < this.corpusresults.length; i++) {
                for (var key in this.corpusresults[i]._source) {
                    if (this.corpusresults[i]._source.hasOwnProperty(key)) {
                        if(key != "" && corpusFilterObject.hasOwnProperty(key) && (corpusFilterObject[key] != 'undefined' && corpusFilterObject[key].length > 0)) {

                            if(key == "corpus_size_value" && corpusFilterObject.corpus_size_value != ""  && corpusFilterObject.corpusSizeTo != "") {
                                if(! this.isBetween(this.corpusresults[i]._source[key], corpusFilterObject.corpus_size_value,corpusFilterObject.corpusSizeTo)){
                                    this.corpusresults[i]._source.visibility = 0;
                                    this.corpusresultcounter--;
                                }
                            }
                            else if(key == "corpus_merged_formats" && corpusFilterObject.corpus_merged_formats != ""){
                                if(!this.hasFormats(this.corpusresults[i]._source[key],corpusFilterObject[key])){
                                    this.corpusresults[i]._source.visibility = 0;
                                    this.corpusresultcounter--;
                                }
                            }
                            else if(key == "corpus_publication_license" && corpusFilterObject[key].toLowerCase() != "") {
                                if(!this.hasLicense(this.renderArrayToString(this.corpusresults[i]._source[key]).toLowerCase(), corpusFilterObject[key].toLowerCase())){
                                    this.corpusresults[i]._source.visibility = 0;
                                    this.corpusresultcounter--;
                                }
                            }
                            else if(key == "corpus_publication_publication_date" && corpusFilterObject.corpus_publication_publication_date != '' && corpusFilterObject.corpusYearTo != '') {
                                var newest_datum = this.corpusresults[i]._source[key][(this.corpusresults[i]._source[key].length -1)];
                                var dateArray = newest_datum.split("-");
                                var newest_date = dateArray[0];
                                if(! this.isBetween(newest_date, corpusFilterObject.corpus_publication_publication_date,corpusFilterObject.corpusYearTo)){
                                    this.corpusresults[i]._source.visibility = 0;
                                    this.corpusresultcounter--;
                                }

                            }
                            else{
                                if(corpusFilterObject[key] != 'undefined'){
                                    if(this.renderArrayToString(this.corpusresults[i]._source[key]).toLowerCase().indexOf(corpusFilterObject[key].toLowerCase()) == -1) {
                                        this.corpusresults[i]._source.visibility = 0;
                                        this.corpusresultcounter--;
                                    }
                                }

                            }
                        }
                    }
                }
            }
        },
        submitDocumentFilter: function (documentFilterObject) {
            this.resetDocumentResults();
            for(var i = 0; i < this.documentresults.length; i++) {
                for (var key in this.documentresults[i]._source) {
                    if (this.documentresults[i]._source.hasOwnProperty(key)) {
                        if(documentFilterObject.hasOwnProperty(key)) {
                            if(key == "document_size_extent"  && documentFilterObject.document_size_extent != ""  && documentFilterObject.document_size_extent_to != "") {
                                if(! this.isBetween(this.documentresults[i]._source[key], documentFilterObject.document_size_extent,documentFilterObject.document_size_extent_to)){
                                    this.documentresults[i]._source.visibility = 0;
                                    this.documentresultcounter--;
                                }
                            }
                            else if(key == "document_publication_publishing_date" && documentFilterObject.document_publication_publishing_date != '' && documentFilterObject.document_publication_publishing_date_to != '') {
                                var newest_datum = this.documentresults[i]._source[key][(this.documentresults[i]._source[key].length -1)];
                                var dateArray = newest_datum.split("-");
                                var newest_date = dateArray[0];
                                if(! this.isBetween(newest_date, documentFilterObject.document_publication_publishing_date,documentFilterObject.document_publication_publishing_date_to)){
                                    this.documentresults[i]._source.visibility = 0;
                                    this.documentresultcounter--;
                                }

                            }
                            else {
                                if(this.renderArrayToString(this.documentresults[i]._source[key]).toLowerCase().indexOf(documentFilterObject[key].toLowerCase()) == -1) {
                                    this.documentresults[i]._source.visibility = 0;
                                    this.documentresultcounter--;
                                }
                            }
                        }
                    }
                }
            }
        },
        submitAnnotationFilter: function (annotationFilterObject) {
            this.resetAnnotationResults();
            for(var i = 0; i < this.annotationresults.length; i++) {
                for (var key in this.annotationresults[i]._source) {
                    if (this.annotationresults[i]._source.hasOwnProperty(key)) {
                        if(key != "" && annotationFilterObject.hasOwnProperty(key) && (annotationFilterObject[key] != 'undefined' && annotationFilterObject[key].length > 0)) {

                            if(key == "annotation_merged_formats" && annotationFilterObject.annotation_merged_formats != ""){
                                if(!this.hasFormats(this.annotationresults[i]._source[key],annotationFilterObject[key])){
                                    this.annotationresults[i]._source.visibility = 0;
                                    this.annotationresultcounter--;
                                }
                            }
                            else{
                                if(this.renderArrayToString(this.annotationresults[i]._source[key]).toLowerCase().indexOf(annotationFilterObject[key].toLowerCase()) == -1) {
                                    this.annotationresults[i]._source.visibility = 0;
                                    this.annotationresultcounter--;
                                }
                            }
                        }
                    }
                }
            }
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
            if(parseInt(theNumber) >= Math.floor(min) && parseInt(theNumber) <= Math.floor(max)){
                return true;
            }
            else if(parseInt(theNumber) >= parseInt(min) && parseInt(theNumber) <= parseInt(max)){
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
            var hasFormat = true;
            var merged_formats_array = merged_formats.split(',');

            if(Array.isArray(filter_formats) && filter_formats.length > 1) {
                for (var key in filter_formats) {
                    if (filter_formats.hasOwnProperty(key)) {
                        console.log(key + " -> " + filter_formats[key]);
                        if(!merged_formats_array.includes(filter_formats[key])){
                            hasFormat = false;
                            break;
                        }
                    }
                }
            }
            else{
                if(!merged_formats_array.includes(filter_formats)){
                    hasFormat = false;
                }
            }

            return hasFormat;
        }
    }
});
