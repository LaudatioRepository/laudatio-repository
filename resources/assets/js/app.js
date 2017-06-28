
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
            //console.log(postData);
            window.axios.post('http://localhost:4000/search',JSON.stringify(postData)).then(res => {
                this.results.push({search: search, results: res.data.hits.hits, total: res.data.hits.total})
            });


        }
    }
});