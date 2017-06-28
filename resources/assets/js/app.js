
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./filters');
var searchClient = require('./elasticsearch.js');

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
        searches: []
    },
    methods: {
        askElastic(search) {
            var that = this;
            //console.log("THIS: "+util.inspect(this, false, null));
            that.searches.push(search.generalSearchTerm);
            searchClient.searchIndex('corpus','corpus_author_forename',search.generalSearchTerm).then(function(res){
                //console.log("HITS: "+util.inspect(res, false, null));
                //that.results.push({search: search, results: res.hits.hits, total: res.hits.total})
                that.results.push({search: search, results: res.hits.hits, total: res.hits.total})
            });





            //console.log(postData);

        }
    }
});