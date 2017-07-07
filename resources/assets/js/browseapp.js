/**
 * Created by rolfguescini on 07.07.17.
 */
require('./bootstrap');
require('./filters');
window.Vue = require('vue');
const util = require('util');

Vue.component('corpusheader', require('./components/CorpusHeader.vue'));
Vue.component('metadata-block-header-corpus', require('./components/CorpusMetadataBlockHeader.vue'));

const browseApp = new Vue({
    el: '#browseapp',
    data: {
        header: window.browseApp.header,
        headerid: window.browseApp.header_id,
        headerdata: window.browseApp.header_data.result
    }
});