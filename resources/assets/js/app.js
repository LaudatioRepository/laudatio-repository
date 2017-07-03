
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

Vue.component('searchwrapper', require('./components/SearchWrapper.vue'));
Vue.component('searchpanel_general', require('./components/SearchPanelGeneral.vue'));
Vue.component('searchpanel_corpus', require('./components/SearchBoxPanelCorpus.vue'));
Vue.component('searchpanel_document', require('./components/SearchBoxPanelDocument.vue'));
Vue.component('searchresultpanel_corpus', require('./components/SearchResultPanelCorpus.vue'));



const app = new Vue({
    el: '#searchapp',
    data: {
        results: [],
        corpusresults: [],
        documentresults: [],
        annotationresults: [],
        searches: []
    },
    methods: {
        askElastic: function(search) {
            this.searches.push(search.generalSearchTerm);
            window.axios.defaults.headers.post['Content-Type'] = 'application/json';
            let postData = {
                index_name: "corpus",
                field: "corpus_author_forename",
                queryString: search.generalSearchTerm
            };

            window.axios.post('api/searchapi/searchGeneral',JSON.stringify(postData)).then(res => {
                this.results.push({search: search, results: res.data.results, total: 5})
            });
        },

        submitCorpusSearch: function(corpusSearchObject) {
            /*
             corpus_title: '',
             corpus_publication_publisher: '',
             corpus_publication_publication_date: '',
             corpusYearTo: '',
             corpus_size_value: '',
             corpusSizeTo: '',
             corpus_languages_language: '',
             corpus_encoding_format: ''
             */

            window.axios.defaults.headers.post['Content-Type'] = 'application/json';
            let postData = {
                field: "corpus_title",
                queryString: corpusSearchObject.corpus_title
            };
            console.log("corpusSearchObject: "+corpusSearchObject.corpus_title);
            window.axios.post('api/searchapi/searchGeneral',JSON.stringify(postData)).then(res => {
                this.results.push({search: corpusSearchObject.corpus_title, results: res.data.results, total: 5})
            });
        },

        submitDocumentSearch: function(documentSearchObject) {
            /*
             document_title: '',
             document_author: '',
             document_publication_place: '',
             document_publication_publishing_date_from: '',
             document_publication_publishing_date_to: '',
             document_size_extent_from: '',
             document_size_extent_to: '',
             document_languages_language: '',
                */

            window.axios.defaults.headers.post['Content-Type'] = 'application/json';
            let postData = {
                field: "corpus_title",
                queryString: documentSearchObject.corpus_title
            };
            console.log("corpusSearchObject: "+documentSearchObject.corpus_title);
        }
    }
});
