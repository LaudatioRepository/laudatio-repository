
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
        corpussearched: false,
        corpusloading: false,
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
        askElastic: function (search) {
            this.corpusloading = true;
            this.corpusresults = [];
            this.corpussearched = false;
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
                            "corpus_encoding_format",
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
                            "document_author_surname",
                            "document_editor_forename",
                            "document_editor_surname",
                            "document_languages_language",
                            "document_languages_iso_code",
                            "document_publication_place",
                            //"document_publication_publishing_date",
                            "preparation_title",
                            "preparation_annotation_id",
                            "preparation_encoding_annotation_group",
                            "preparation_encoding_annotation_sub_group",
                            "preparation_encoding_full_name"
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
                            console.log(JSON.stringify(res.data.results[ri]._index));
                            if(res.data.results[ri]._index.indexOf("corpus_") == 0){
                                this.corpusresults.push(res.data.results[ri]);
                                this.corpusresultcounter++;
                            }
                            else if(res.data.results[ri]._index.indexOf("document_") == 0){
                                this.documentresults.push(res.data.results[ri]);
                                this.documentresultcounter ++;
                            }
                            else if(res.data.results[ri]._index.indexOf("annotation_") == 0){
                                this.annotationresults.push(res.data.results[ri]);
                                this.annotationresultcounter ++;
                            }///end which index
                        }//end for results
                    }//end if results
                    this.corpusloading = false;
                    this.corpussearched = true;
                    this.searches.push(search.generalSearchTerm);
                });


            }
            else{
                this.corpusloading = false;
            }

        },
        get_if_exist(collection, str) {
            var value = ""
            for (var i = 0; i < collection.length; i++) {
                var obj = collection[i];
                if (obj.hasOwnProperty(str)) {
                    value = obj[str];
                }
            }
            return value;
        },
        remove_if_exist(collection, str) {
            for (var i = 0; i < collection.length; i++) {
                var obj = collection[i];
                if (obj.hasOwnProperty(str)) {
                    collection.splice(i, 1);
                }
            }
            return collection
        },
        triggerFilters: function() {
            console.log("SETFILTERS");
        },
        submitCorpusFilter: function (corpusFilterObject) {
            console.log(JSON.stringify(corpusFilterObject))
            var filter_corpus_title = corpusFilterObject.corpus_title;
            var filter_corpus_publication_publisher = corpusFilterObject.corpus_publication_publisher;
            var filter_corpus_merged_languages = corpusFilterObject.corpus_merged_languages;
            var filter_corpus_publication_publisher = corpusFilterObject.corpus_publication_publisher;
            var filter_corpus_merged_formats = corpusFilterObject.corpus_merged_formats;
            var filter_corpus_publication_license = corpusFilterObject.corpus_publication_license;
            var filter_corpus_publication_publication_date = corpusFilterObject.corpus_publication_publication_date;
            var filter_corpusYearTo = corpusFilterObject.corpusYearTo;

            for(var i = 0; i < this.corpusresults.length; i++) {

                if(this.corpusresults[i]._source.corpus_title[0].toLowerCase().indexOf(filter_corpus_title.toLowerCase()) == -1) {
                    this.corpusresults[i]._source.visibility = 0;
                    this.corpusresultcounter--;
                }
                /*
                else if(this.corpusresults[i]._source.corpus_merged_languages.toLowerCase().indexOf(filter_corpus_merged_languages.toLowerCase()) == -1) {
                    this.corpusresults.splice(i,1);
                }
                else if(this.corpusresults[i]._source.corpus_publication_publisher[0].toLowerCase().indexOf(filter_corpus_publication_publisher.toLowerCase()) == -1) {
                    this.corpusresults.splice(i,1);
                }
                else if(this.corpusresults[i]._source.corpus_merged_formats.toLowerCase().indexOf(filter_corpus_merged_formats.toLowerCase()) == -1) {
                    this.corpusresults.splice(i,1);
                }
                else if(this.corpusresults[i]._source.corpus_publication_license[0].toLowerCase().indexOf(filter_corpus_publication_license.toLowerCase()) == -1) {
                    this.corpusresults.splice(i,1);
                }
                */
            }
        },
        submitDocumentFilter: function (documentFilterObject) {
            console.log("documentFilterObject: "+JSON.stringify(documentFilterObject))
        },
        submitAnnotationFilter: function (annotationFilterObject) {
            console.log("annotationFilterObject: "+JSON.stringify(annotationFilterObject))
        },
        submitCorpusSearch: function (corpusSearchObject) {
            this.corpusloading = true;
            this.corpusresults = [];
            this.corpussearched = false;
            this.corpusCacheString = "";
            this.$store.dispatch('clearCorpus', [])
            this.$store.dispatch('clearDocuments', [])
            this.$store.dispatch('clearAnnotations', [])

            let postDataCollection = [];
            var thereAreMore = false;
            var hasDateAndSize = false;
            var dateAndSize = [
                "corpus_publication_publication_date",
                "corpusYearTo",
                "corpus_size_value",
                "corpusSizeTo",
                "corpusyeartype",
                "corpussizetype"
            ];
            for (var p in corpusSearchObject) {
                if (corpusSearchObject[p].length > 0) {
                    if (dateAndSize.indexOf(p) > -1 && corpusSearchObject[p] != ""
                        && (corpusSearchObject['corpusyeartype'] == "range" || corpusSearchObject['corpussizetype'] == "range")) {
                        if (!hasDateAndSize) {
                            hasDateAndSize = true;
                        }
                    }
                    else {
                        if (!thereAreMore && corpusSearchObject[p] != "") {
                            thereAreMore = true;
                        }
                    }

                    postDataCollection.push(
                        {
                            [p]: corpusSearchObject[p]
                        }
                    );
                    this.corpusCacheString += '|' + p + '|' + corpusSearchObject[p];
                }

            }


            if (postDataCollection.length > 0) {
                console.log(JSON.stringify(postDataCollection))

                var corpusyeartype = this.get_if_exist(postDataCollection, 'corpusyeartype');
                var corpussizetype = this.get_if_exist(postDataCollection, 'corpussizetype');
                var corpus_publication_publication_date = this.get_if_exist(postDataCollection, 'corpus_publication_publication_date');
                var corpusYearTo = this.get_if_exist(postDataCollection, 'corpusYearTo');

                var corpus_size_value = this.get_if_exist(postDataCollection, 'corpus_size_value');
                var corpusSizeTo = this.get_if_exist(postDataCollection, 'corpusSizeTo');


                if ((corpusyeartype && !corpus_publication_publication_date) && (corpusyeartype && !corpusYearTo)) {
                    postDataCollection = this.remove_if_exist(postDataCollection, "corpusyeartype");
                }

                if ((corpussizetype && !corpus_size_value) && (corpussizetype && !corpusSizeTo)) {
                    postDataCollection = this.remove_if_exist(postDataCollection, "corpussizetype");
                }


                if (hasDateAndSize && thereAreMore) {
                    postDataCollection.push(
                        {"mixedSearch": "true"}
                    )
                }
                else {
                    postDataCollection.push(
                        {"mixedSearch": "false"}
                    )
                }


                let postData = {
                    searchData: postDataCollection,
                    scope: 'corpus',
                    cacheString: this.corpusCacheString
                };

                let corpus_ids = [];

                window.axios.post('api/searchapi/searchCorpus', JSON.stringify(postData)).then(res => {
                    this.corpussearched = true;
                    var corpusRefs = [];

                    if (res.data.results.length > 0) {
                        this.corpusresults.push({
                            search: postDataCollection,
                            results: res.data.results,
                            total: res.data.total
                        })

                        for (var ri = 0; ri < res.data.results.length; ri++) {
                            corpusRefs.push(res.data.results[ri]._source.corpus_id[0]);
                            corpus_ids.push({
                                'in_corpora': '' + res.data.results[ri]._source.corpus_id[0] + ''
                            });
                        }

                        if (corpus_ids.length > 0) {
                            let documentPostData = {
                                corpus_ids: corpus_ids,
                                corpusRefs: corpusRefs,
                                cacheString: this.corpusCacheString
                            }



                            /**
                             * Get all documents contained in the corpora
                             */
                            window.axios.post('api/searchapi/getDocumentsByCorpus', JSON.stringify(documentPostData)).then(documentRes => {

                                if (Object.keys(documentRes.data.results).length > 0) {
                                    var documentsByCorpus = {}
                                    Object.keys(documentRes.data.results).forEach(function (key) {
                                        documentsByCorpus[key] = {results: documentRes.data.results[key]}
                                    });
                                }

                                this.documentsByCorpus = documentsByCorpus;
                            });

                            /**
                             * get all annotations contained pro corpus
                             */
                            window.axios.post('api/searchapi/getAnnotationsByCorpus', JSON.stringify(documentPostData)).then(annotationRes => {

                                if (Object.keys(annotationRes.data.results).length > 0) {
                                    var annotationsByCorpus = {}
                                    Object.keys(annotationRes.data.results).forEach(function (key) {
                                        annotationsByCorpus[key] = {results: annotationRes.data.results[key]}
                                    });
                                }
                                this.annotationsByCorpus = annotationsByCorpus;
                            });
                        }
                    }//end if data

                    this.corpussearched = true;
                    this.corpusloading = false;
                });
            }

        },

        submitDocumentSearch: function (documentSearchObject) {
            this.documentloading = true;
            this.documentresults = [];
            this.documentsearched = false;
            this.documentCacheString = "";
            this.$store.dispatch('clearCorpus', [])
            this.$store.dispatch('clearDocuments', [])
            this.$store.dispatch('clearAnnotations', [])
            let postDataCollection = [];
            var thereAreMore = false;
            var hasDateAndSize = false;
            var dateAndSize = [
                "document_publication_publishing_date",
                "document_publication_publishing_date_to",
                "document_size_extent",
                "document_size_extent_to",
                "documentyeartype",
                "documentsizetype"
            ];
            for (var p in documentSearchObject) {
                if (documentSearchObject[p].length > 0) {
                    if (dateAndSize.indexOf(p) > -1 && documentSearchObject[p] != ""
                        && (documentSearchObject['documentyeartype'] == "range" || documentSearchObject['documentsizetype'] == "range")) {
                        if (!hasDateAndSize) {
                            hasDateAndSize = true;
                        }
                    }
                    else {
                        if (!thereAreMore && documentSearchObject[p] != "") {
                            thereAreMore = true;
                        }
                    }
                    postDataCollection.push(
                        {
                            [p]: documentSearchObject[p]
                        }
                    );
                    this.documentCacheString += '|' + p + '|' + documentSearchObject[p];
                }

            }


            if (postDataCollection.length > 0) {
                let postData = {
                    searchData: postDataCollection,
                    cacheString: this.documentCacheString,
                    scope: 'document'
                };


                var documentyeartype = this.get_if_exist(postDataCollection, 'documentyeartype');
                var documentsizetype = this.get_if_exist(postDataCollection, 'documentsizetype');

                var document_publication_publishing_date = this.get_if_exist(postDataCollection, 'document_publication_publishing_date');
                var document_publication_publishing_date_to = this.get_if_exist(postDataCollection, 'document_publication_publishing_date_to');
                var document_size_extent = this.get_if_exist(postDataCollection, 'document_size_extent');
                var document_size_extent_to = this.get_if_exist(postDataCollection, 'document_size_extent_to');
                if ((documentyeartype && !document_publication_publishing_date) && (documentyeartype && !document_publication_publishing_date_to)) {
                    postDataCollection = this.remove_if_exist(postDataCollection, "documentyeartype");
                }

                if ((documentsizetype && !document_size_extent) && (documentsizetype && !document_size_extent_to)) {
                    postDataCollection = this.remove_if_exist(postDataCollection, "documentsizetype");
                }


                if (hasDateAndSize && thereAreMore) {
                    postDataCollection.push(
                        {"mixedSearch": "true"}
                    )
                }
                else {
                    postDataCollection.push(
                        {"mixedSearch": "false"}
                    )
                }
                console.log("POSTDATACOLLECTION: " + JSON.stringify(postData))
                let that = this;
                window.axios.post('api/searchapi/searchDocument', JSON.stringify(postData)).then(res => {
                    this.documentsearched = true;

                    if (res.data.results.length > 0) {

                        var documentRefs = [];
                        var corpusRefs = [];

                        var corpus_ids = [];
                        var document_ids = [];


                        for (var j = 0; j < res.data.results.length; j++) {
                            var in_corpora = res.data.results[j]._source.in_corpora
                            documentRefs.push(res.data.results[j]._id);
                            document_ids.push({
                                'in_documents': '' + res.data.results[j]._id + ''
                            });
                            if (typeof  in_corpora != 'undefined' && in_corpora.length > 0) {
                                for (var jid = 0; jid < in_corpora.length; jid++) {
                                    corpusRefs.push(
                                        {
                                            '_id': '' + in_corpora[jid] + ''
                                        }
                                    );
                                }
                            }
                            else if (typeof  in_corpora != 'undefined' && in_corpora.length == 0 || typeof  in_corpora == 'undefined') {
                                corpusRefs.push(
                                    {
                                        '_id': '0'
                                    }
                                );
                            }
                        }


                        let annotationPostData = {
                            documentRefs: documentRefs,
                            document_ids: document_ids,
                            cacheString: this.documentCacheString,
                        };


                        let corpusPostData = {
                            documentRefs: documentRefs,
                            corpusRefs: corpusRefs,
                            cacheString: this.documentCacheString
                        };
                        console.log("annotationPostData: " + this.documentCacheString);
                        window.axios.post('api/searchapi/getAnnotationsByDocument', JSON.stringify(annotationPostData)).then(annotationRes => {
                            if (Object.keys(annotationRes.data.results).length > 0) {
                                var annotationsByDocument = {}
                                Object.keys(annotationRes.data.results).forEach(function (key) {
                                    annotationsByDocument[key] = annotationRes.data.results[key]
                                });
                            }

                            this.annotationsByDocument = annotationsByDocument;

                        });


                        //console.log("corpusPostData: "+JSON.stringify(corpusPostData));
                        window.axios.post('api/searchapi/getCorpusByDocument', JSON.stringify(corpusPostData)).then(corpusRes => {

                            if (Object.keys(corpusRes.data.results).length > 0) {
                                var corpusByDocument = {}
                                Object.keys(corpusRes.data.results).forEach(function (key) {
                                    corpusByDocument[key] = {results: corpusRes.data.results[key]}
                                });
                            }

                            this.corpusByDocument = corpusByDocument;
                        });


                        let postDocumentData = {
                            documentRefs: documentRefs,
                            corpusRefs: corpusRefs,
                            cacheString: this.documentCacheString
                        };

                        window.axios.post('api/searchapi/getCorpusTitlesByDocument', postDocumentData).then(corpusByDocumentRes => {
                            if (Object.keys(corpusByDocumentRes.data.results).length > 0) {
                                var corpusTitleByDocument = []

                                Object.keys(corpusByDocumentRes.data.results).forEach(function (key) {
                                    corpusTitleByDocument[key] = corpusByDocumentRes.data.results[key]

                                });

                                this.documentresults.push({
                                    search: documentSearchObject.document_title,
                                    results: res.data.results,
                                    total: res.data.total,
                                    corpusByDocument: corpusTitleByDocument
                                })

                            }
                            else {
                                this.documentresults.push({
                                    search: documentSearchObject.document_title,
                                    results: res.data.results,
                                    total: res.data.total,
                                    corpusByDocument: []
                                })
                            }

                        });
                        this.documentloading = false;
                    }

                });
            }
        },
        searchAnnotation: function (postData, postAnnotationData) {
            var annotationterms = [];


            window.axios.post('api/searchapi/searchAnnotation', postData).then(res => {
                this.annotationsearched = true;
                console.log("RESSS: " + JSON.stringify(res));
                var documentRefs = {};
                var corpusRefs = {};
                var annotationRefs = [];
                if (res.data.results.length > 0) {

                    for (var j = 0; j < res.data.results.length; j++) {

                        annotationRefs.push(res.data.results[j]._id);
                        var id = res.data.results[j]._id;

                        if (typeof documentRefs[id] == 'undefined') {
                            documentRefs[id] = []
                        }

                        if (typeof corpusRefs[id] == 'undefined') {
                            corpusRefs[id] = []
                        }


                        if (typeof res.data.results[j]._source.in_documents != 'undefined' && res.data.results[j]._source.in_documents.length > 0) {
                            for (var jid = 0; jid < res.data.results[j]._source.in_documents.length; jid++) {
                                documentRefs[id].push(
                                    {
                                        '_id': '' + res.data.results[j]._source.in_documents[jid] + ''
                                    }
                                );
                            }
                        }
                        else if (typeof  res.data.results[j]._source.in_documents != 'undefined' && res.data.results[j]._source.in_documents.length == 0 || typeof  res.data.results[j]._source.in_documents == 'undefined') {
                            documentRefs[id].push(
                                {
                                    '_id': '0'
                                }
                            );
                        }


                        if (typeof  res.data.results[j]._source.in_corpora != 'undefined' && res.data.results[j]._source.in_corpora.length > 0) {
                            for (var cid = 0; cid < res.data.results[j]._source.in_corpora.length; cid++) {
                                corpusRefs[id].push(
                                    {
                                        '_id': '' + res.data.results[j]._source.in_corpora[cid] + ''
                                    }
                                );
                            }
                        }
                        else if (typeof  res.data.results[j]._source.in_corpora != 'undefined' && res.data.results[j]._source.in_corpora.length == 0 || typeof  res.data.results[j]._source.in_corpora == 'undefined') {
                            corpusRefs[id].push(
                                {
                                    '_id': '0'
                                }
                            );
                        }

                    }//end for annotationResults

                    this.annotationresults.push({
                        results: res.data.results,
                        total: res.data.total,
                    });


                }
                this.postAnnotationData.corpusRefs = corpusRefs
                this.postAnnotationData.documentRefs = documentRefs
                this.postAnnotationData.annotationRefs = annotationRefs
            });


            this.postAnnotationData.cacheString = this.annotationCacheString;

        },
        getDocumentsByAnnotation: function (postAnnotationData) {
            console.log("getDocumentsByAnnotation: " + JSON.stringify(this.postAnnotationData));
            window.axios.post('api/searchapi/getDocumentsByAnnotation', this.postAnnotationData).then(documentsByAnnotationRes => {
                this.annotationsearched = true;
                console.log("documentsByAnnotationRes: " + documentsByAnnotationRes);
                if (Object.keys(documentsByAnnotationRes.data.results).length > 0) {
                    var documentsByAnnotation = {}
                    Object.keys(documentsByAnnotationRes.data.results).forEach(function (key) {
                        documentsByAnnotation[key] = {results: documentsByAnnotationRes.data.results[key]}
                    });

                    this.documentsByAnnotation = documentsByAnnotation;

                    /*
                     this.annotationresults.push({
                     search: annotationSearchObject.preparation_title,
                     results: res.data.results,
                     total: res.data.total,
                     });
                     */
                }
                else {
                    /*
                     this.annotationresults.push({
                     search: annotationSearchObject.preparation_title,
                     results: res.data.results,
                     total: res.data.total,
                     });
                     */
                }


            });


        },
        getCorporaByAnnotation: function (postAnnotationData) {
            console.log("getCorporaByAnnotation: " + JSON.stringify(this.postAnnotationData));
            window.axios.post('api/searchapi/getCorporaByAnnotation', this.postAnnotationData).then(corpussByAnnotationRes => {


                if (Object.keys(corpussByAnnotationRes.data.results).length > 0) {
                    var corpusByAnnotation = {}
                    Object.keys(corpussByAnnotationRes.data.results).forEach(function (key) {
                        corpusByAnnotation[key] = {results: corpussByAnnotationRes.data.results[key]}
                    });

                    this.corpusByAnnotation = corpusByAnnotation;


                }

            });
        },
        removeAnnotationSpinner: function () {
            this.annotationsearched = true;
            this.annotationloading = true;
        },
        submitAnnotationSearch: function (annotationSearchObject) {
            this.annotationloading = true;
            this.annotationresults = [];
            this.annotationsearched = false;
            let postAnnotationData = {}
            let postDataCollection = [];

            this.annotationCacheString = "";
            this.$store.dispatch('clearCorpus',[])
            this.$store.dispatch('clearDocuments',[])
            this.$store.dispatch('clearAnnotations',[])
            var documentsByAnnotationTime = 0;

            for(var p in annotationSearchObject){
                if(annotationSearchObject[p].length > 0){
                    postDataCollection.push(
                        {
                            [p]: annotationSearchObject[p]
                        }
                    );
                    this.annotationCacheString += '|'+p+'|'+annotationSearchObject[p];
                }

            }


            if(postDataCollection.length > 0){
                let postData = {
                    searchData: postDataCollection,
                    cacheString: this.annotationCacheString,
                    scope: 'annotation'
                };
                var searchAnnotation0 = performance.now();
                window.axios.post('api/searchapi/searchAnnotation',postData).then(res => {
                    this.annotationsearched = true;
                    if(res.data.results.length > 0) {
                        var annotationterms = [];

                        var documentRefs = {};
                        var corpusRefs = {};
                        var annotationRefs = [];

                        for(var j = 0; j< res.data.results.length; j++) {

                            annotationRefs.push(res.data.results[j]._id);
                            var id = res.data.results[j]._id;

                            if(typeof documentRefs[id] == 'undefined'){
                                documentRefs[id] = []
                            }

                            if(typeof corpusRefs[id] == 'undefined'){
                                corpusRefs[id] = []
                            }


                            if(typeof res.data.results[j]._source.in_documents != 'undefined' && res.data.results[j]._source.in_documents.length >= 1){
                                for(var jid = 0; jid < res.data.results[j]._source.in_documents.length; jid++) {
                                    documentRefs[id].push(
                                        {
                                            '_id': ''+res.data.results[j]._source.in_documents[jid]+''
                                        }
                                    );
                                }
                            }




                            if(typeof  res.data.results[j]._source.in_corpora != 'undefined' && res.data.results[j]._source.in_corpora.length >= 1){
                                for(var cid = 0; cid < res.data.results[j]._source.in_corpora.length; cid++) {
                                    corpusRefs[id].push(
                                        {
                                            '_id': ''+res.data.results[j]._source.in_corpora[cid]+''
                                        }
                                    );
                                }
                            }


                        }//end for annotationResults
                        var searchAnnotation1 = performance.now();
                        console.log("searchAnnotation took " + (searchAnnotation1 - searchAnnotation0) + " milliseconds.")

                        postAnnotationData.corpusRefs =  corpusRefs
                        postAnnotationData.documentRefs = documentRefs
                        postAnnotationData.annotationRefs = annotationRefs
                        postAnnotationData.cacheString =  this.annotationCacheString;
                        console.log("getDocumentsByAnnotation  " + JSON.stringify(postAnnotationData));
                        var getDocumentsByAnnotation1 = performance.now();

                        window.axios.post('api/searchapi/getDocumentsByAnnotation',postAnnotationData).then(documentsByAnnotationRes => {
                            this.annotationsearched = true;
                            if (Object.keys(documentsByAnnotationRes.data.results).length > 0) {
                                var documentsByAnnotation = {}
                                Object.keys(documentsByAnnotationRes.data.results).forEach(function(key) {
                                    documentsByAnnotation[key] = {results: documentsByAnnotationRes.data.results[key]}
                                });

                                this.documentsByAnnotation = documentsByAnnotation;
                            }

                        });

                        var getDocumentsByAnnotation2 = performance.now();
                        console.log("getDocumentsByAnnotation took " + (getDocumentsByAnnotation2 - getDocumentsByAnnotation1) + " milliseconds.")
                        documentsByAnnotationTime += (getDocumentsByAnnotation2 - getDocumentsByAnnotation1);

                        var getCorporaByAnnotation1 = performance.now();
                        window.axios.post('api/searchapi/getCorporaByAnnotation',postAnnotationData).then(corpussByAnnotationRes => {


                            if (Object.keys(corpussByAnnotationRes.data.results).length > 0) {
                                var corpusByAnnotation = {}
                                Object.keys(corpussByAnnotationRes.data.results).forEach(function(key) {
                                    corpusByAnnotation[key] = {results: corpussByAnnotationRes.data.results[key]}
                                });

                                this.corpusByAnnotation = corpusByAnnotation;

                                this.annotationresults.push({
                                    search: annotationSearchObject.preparation_title,
                                    results: res.data.results,
                                    total: res.data.total,
                                    took: res.data.milliseconds
                                });
                            }
                            else {
                                this.annotationresults.push({
                                    search: annotationSearchObject.preparation_title,
                                    results: res.data.results,
                                    total: res.data.total,
                                    took: res.data.milliseconds
                                });
                            }


                        });
                        this.annotationloading = false;
                        var getCorporaByAnnotation2 = performance.now();
                        console.log("getCorporaByAnnotation took " + (getCorporaByAnnotation2 - getCorporaByAnnotation1) + " milliseconds.")

                    }
                });
            }
            console.log("DocumentsByAnnotation total took " + documentsByAnnotationTime + " milliseconds.")
        }
    }
});
