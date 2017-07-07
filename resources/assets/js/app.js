
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./filters');
window.Vue = require('vue');
const util = require('util')
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
    data: {
        results: [],
        corpusresults: [],
        documentresults: [],
        annotationresults: [],
        searches: [],
        documentsByAnnotation: [],
        corpussearched: false,
        documentsearched: false,
        annotationsearched: false
    },
    methods: {
        askElastic: function(search) {
            this.corpusresults = [];
            this.searches.push(search.generalSearchTerm);
            window.axios.defaults.headers.post['Content-Type'] = 'application/json';
            let postData = {
                index_name: "corpus",
                field: "corpus_author_forename",
                queryString: search.generalSearchTerm
            };

            window.axios.post('api/searchapi/searchCorpus',JSON.stringify(postData)).then(res => {
                if(res.data.results.length > 0) {
                    this.corpusresults.push({search: search, results: res.data.results, total: 5})
                }
            });
        },

        submitCorpusSearch: function(corpusSearchObject) {
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


                window.axios.post('api/searchapi/searchCorpus',JSON.stringify(postData)).then(res => {
                    this.corpussearched = true;
                    if(res.data.results.length > 0) {
                        this.corpusresults.push({
                            search: postDataCollection,
                            results: res.data.results,
                            total: res.data.total
                        })
                    }
                });
            }

        },

        submitDocumentSearch: function(documentSearchObject) {
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
                        this.documentresults.push({
                            search: documentSearchObject.document_title,
                            results: res.data.results,
                            total: res.data.total
                        })
                    }
                });
            }

        },

        submitAnnotationSearch: function(annotationSearchObject) {
            this.annotationresults = [];
            this.annotationsearched = false;

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

                        for(var i = 0; i < res.data.results.length;i++) {
                            annotationterms.push(
                                {
                                    'document_list_of_annotations_name': ''+res.data.results[i]._source.preparation_title+''
                                }
                            );
                        }

                        let postAnnotationData = {
                            searchData: annotationterms,
                        };


                        window.axios.post('api/searchapi/getSearchTotal',postAnnotationData).then(documentsByAnnotationRes => {
                            this.annotationsearched = true;
                            if (Object.keys(documentsByAnnotationRes.data.results).length > 0) {
                                this.annotationresults.push({
                                    search: annotationSearchObject.preparation_title,
                                    results: res.data.results,
                                    total: res.data.total,
                                    documentsByAnnotation: documentsByAnnotationRes.data.results,
                                    scope: 'annotation'
                                });
                            }
                        });
                    }
                });
            }

        }
    }
});
