
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('./filters');
window.Vue = require('vue');
const util = require('util')
import store from './store'
import { connect } from 'vuex-connect'
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('searchwrapper_corpus', require('./components/SearchWrapperCorpus.vue'));
Vue.component('searchwrapper_document', require('./components/SearchWrapperDocument.vue'));
Vue.component('searchwrapper_annotation', require('./components/SearchWrapperAnnotation.vue'));

Vue.component('searchpanel_general', require('./components/SearchPanelGeneral.vue'));
Vue.component('searchpanel_corpus', require('./components/SearchBoxPanelCorpus.vue'));
Vue.component('searchpanel_document', require('./components/SearchBoxPanelDocument.vue'));
Vue.component('searchpanel_annotation', require('./components/SearchBoxPanelAnnotation.vue'));


Vue.component('searchresultpanel_corpus', require('./components/SearchResultPanelCorpus.vue'));
Vue.component('searchresultheader_corpus', require('./components/SearchResultHeaderCorpus.vue'));

Vue.component('searchresultpanel_document', require('./components/SearchResultPanelDocument.vue'));
Vue.component('searchresultheader_document', require('./components/SearchResultHeaderDocument.vue'));

Vue.component('searchresultpanel_annotation', require('./components/SearchResultPanelAnnotation.vue'));
Vue.component('searchresultheader_annotation', require('./components/SearchResultHeaderAnnotation.vue'));


window.axios.defaults.headers.post['Content-Type'] = 'application/json';


const app = new Vue({
    el: '#searchapp',
    store: store,
    data: {
        results: [],
        corpusresults: [],
        documentresults: [],
        annotationresults: [],
        searches: [],
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
        annotationloading: false,
    },
    methods: {
        askElastic: function(search) {
            this.corpusresults = [];
            this.searches.push(search.generalSearchTerm);
            let postData = {
                searchData: {
                    fields: ["corpus_title","corpus_editor_forename","corpus_editor_surname","corpus_publication_publisher","corpus_documents","corpus_encoding_format","corpus_encoding_tool","corpus_encoding_project_description","annotation_name","annotation_type","corpus_annotator_forename","corpus_annotator_surname"],
                    query: ''+search.generalSearchTerm+''
                }
            };

            window.axios.post('api/searchapi/searchGeneral',JSON.stringify(postData)).then(res => {
                if(res.data.results.length > 0) {
                    this.corpusresults.push({
                        search: search.generalSearchTerm,
                        results: res.data.results,
                        total: res.data.total
                    })
                }
            });
        },

        submitCorpusSearch: function(corpusSearchObject) {
            this.corpusloading = true;
            this.corpusresults = [];
            this.corpussearched =  false;
            let postDataCollection = [];
            for(var p in corpusSearchObject){
                if(corpusSearchObject[p].length > 0){
                    postDataCollection.push(
                        {
                            [p]: corpusSearchObject[p]
                        }
                    );
                }

            }


            if(postDataCollection.length > 0){
                let postData = {
                    searchData: postDataCollection,
                    scope: 'corpus'
                };

                let corpus_ids = [];

                window.axios.post('api/searchapi/searchCorpus',JSON.stringify(postData)).then(res => {
                    this.corpussearched = true;
                    var corpusRefs = [];

                    if(res.data.results.length > 0) {
                        this.corpusresults.push({
                            search: postDataCollection,
                            results: res.data.results,
                            total: res.data.total
                        })

                        for(var ri = 0; ri < res.data.results.length; ri++){
                            corpusRefs.push(res.data.results[ri]._id);
                            corpus_ids.push({
                                'in_corpora': ''+res.data.results[ri]._id+''
                            });
                        }

                    }

                    if(corpus_ids.length > 0) {
                        let documentPostData = {
                            corpus_ids: corpus_ids,
                            corpusRefs: corpusRefs
                        }

                        /**
                         * Get all documents contained in the corpora
                         */
                        window.axios.post('api/searchapi/getDocumentsByCorpus', JSON.stringify(documentPostData)).then(documentRes => {

                            if (Object.keys(documentRes.data.results).length > 0) {
                                var documentsByCorpus = {}
                                Object.keys(documentRes.data.results).forEach(function(key) {
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
                                Object.keys(annotationRes.data.results).forEach(function(key) {
                                    annotationsByCorpus[key] = {results: annotationRes.data.results[key]}
                                });
                            }
                            this.annotationsByCorpus = annotationsByCorpus;
                        });
                    }


                    this.corpusloading = false;
                });
            }

        },

        submitDocumentSearch: function(documentSearchObject) {
            this.documentloading = true;
            this.documentresults = [];
            this.documentsearched = false;

            let postDataCollection = [];
            for(var p in documentSearchObject){
                if(documentSearchObject[p].length > 0){
                    postDataCollection.push(
                        {
                            [p]: documentSearchObject[p]
                        }
                    );
                }

            }

            if(postDataCollection.length > 0){
                let postData = {
                    searchData: postDataCollection,
                    scope: 'document'
                };

                window.axios.post('api/searchapi/searchDocument',JSON.stringify(postData)).then(res => {
                    this.documentsearched = true;
                    if(res.data.results.length > 0) {

                        var documentRefs = [];
                        var corpusRefs = [];

                        var corpus_ids = [];
                        var document_ids = [];



                        for(var j = 0; j< res.data.results.length; j++) {
                            var in_corpora = res.data.results[j]._source.in_corpora
                            documentRefs.push(res.data.results[j]._id);
                            document_ids.push({
                                'in_documents': ''+res.data.results[j]._id+''
                            });
                            if(typeof  in_corpora != 'undefined' && in_corpora.length > 0){
                                for(var jid = 0; jid < in_corpora.length; jid++) {
                                    corpusRefs.push(
                                        {
                                            '_id': ''+in_corpora[jid]+''
                                        }
                                    );
                                }
                            }
                            else if(typeof  in_corpora != 'undefined' && in_corpora.length == 0 || typeof  in_corpora == 'undefined'){
                                corpusRefs.push(
                                    {
                                        '_id': '0'
                                    }
                                );
                            }
                        }



                        let annotationPostData = {
                            documentRefs: documentRefs,
                            document_ids: document_ids
                        };


                        let corpusPostData = {
                            documentRefs: documentRefs,
                            corpusRefs: corpusRefs,
                        };
                        console.log("DOCUREFLEN: "+documentRefs.length);
                        console.log("corpusRefs: "+corpusRefs.length);
                        window.axios.post('api/searchapi/getAnnotationsByDocument', JSON.stringify(annotationPostData)).then(annotationRes => {
                            if (Object.keys(annotationRes.data.results).length > 0) {
                                var annotationsByDocument = {}
                                Object.keys(annotationRes.data.results).forEach(function(key) {
                                    annotationsByDocument[key] = annotationRes.data.results[key]
                                });
                            }

                            this.annotationsByDocument = annotationsByDocument;

                        });

                        window.axios.post('api/searchapi/getCorpusByDocument', JSON.stringify(corpusPostData)).then(corpusRes => {

                            if (Object.keys(corpusRes.data.results).length > 0) {
                                var corpusByDocument = {}
                                Object.keys(corpusRes.data.results).forEach(function(key) {
                                    corpusByDocument[key] = {results: corpusRes.data.results[key]}
                                });
                            }

                            this.corpusByDocument = corpusByDocument;
                        });



                        let postDocumentData = {
                            documentRefs: documentRefs,
                            corpusRefs: corpusRefs,
                        };

                        window.axios.post('api/searchapi/getCorpusTitlesByDocument',postDocumentData).then(corpusByDocumentRes => {
                            if (Object.keys(corpusByDocumentRes.data.results).length > 0) {
                                var corpusTitleByDocument = []

                                Object.keys(corpusByDocumentRes.data.results).forEach(function(key) {
                                    corpusTitleByDocument[key] = corpusByDocumentRes.data.results[key]

                                });

                                this.documentresults.push({
                                    search: documentSearchObject.document_title,
                                    results: res.data.results,
                                    total: res.data.total,
                                    corpusByDocument: corpusTitleByDocument
                                })

                            }
                            else{
                                this.documentresults.push({
                                    search: documentSearchObject.document_title,
                                    results: res.data.results,
                                    total: res.data.total,
                                    corpusByDocument: []
                                })
                            }
                            this.documentloading = false;
                        });

                    }
                });
            }
        },

        submitAnnotationSearch: function(annotationSearchObject) {
            this.annotationloading = true;
            this.annotationresults = [];
            this.annotationsearched = false;
            let postAnnotationData = {}
            let postDataCollection = [];
            for(var p in annotationSearchObject){
                if(annotationSearchObject[p].length > 0){
                    postDataCollection.push(
                        {
                            [p]: annotationSearchObject[p]
                        }
                    );
                }

            }

            if(postDataCollection.length > 0){
                let postData = {
                    searchData: postDataCollection,
                    scope: 'annotation'
                };

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


                            if(typeof res.data.results[j]._source.in_documents != 'undefined' && res.data.results[j]._source.in_documents.length > 0){
                                for(var jid = 0; jid < res.data.results[j]._source.in_documents.length; jid++) {
                                    documentRefs[id].push(
                                        {
                                            '_id': ''+res.data.results[j]._source.in_documents[jid]+''
                                        }
                                    );
                                }
                            }
                            else if(typeof  res.data.results[j]._source.in_documents != 'undefined' && res.data.results[j]._source.in_documents.length == 0 || typeof  res.data.results[j]._source.in_documents == 'undefined'){
                                documentRefs[id].push(
                                    {
                                        '_id': '0'
                                    }
                                );
                            }



                            if(typeof  res.data.results[j]._source.in_corpora != 'undefined' && res.data.results[j]._source.in_corpora.length > 0){
                                for(var cid = 0; cid < res.data.results[j]._source.in_corpora.length; cid++) {
                                    corpusRefs[id].push(
                                        {
                                            '_id': ''+res.data.results[j]._source.in_corpora[cid]+''
                                        }
                                    );
                                }
                            }
                            else if(typeof  res.data.results[j]._source.in_corpora != 'undefined' && res.data.results[j]._source.in_corpora.length == 0 || typeof  res.data.results[j]._source.in_corpora == 'undefined'){
                                corpusRefs[id].push(
                                    {
                                        '_id': '0'
                                    }
                                );
                            }




                        }//end for annotationResults
                        postAnnotationData.corpusRefs =  corpusRefs
                        postAnnotationData.documentRefs = documentRefs
                        postAnnotationData.annotationRefs = annotationRefs

                        window.axios.post('api/searchapi/getDocumentsByAnnotation',postAnnotationData).then(documentsByAnnotationRes => {
                            this.annotationsearched = true;

                            if (Object.keys(documentsByAnnotationRes.data.results).length > 0) {
                                var documentsByAnnotation = {}
                                Object.keys(documentsByAnnotationRes.data.results).forEach(function(key) {
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

                            this.annotationloading = false;
                        });


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
                                });
                            }
                            else {
                                this.annotationresults.push({
                                    search: annotationSearchObject.preparation_title,
                                    results: res.data.results,
                                    total: res.data.total,
                                });
                            }

                            this.annotationloading = false;
                        });


                    }
                });
            }
        },

        fetchDocumentsByCorpusId: function(corpus_id) {

        }
    }

});
