/**
 * Created by rolfguescini on 07.07.17.
 */
require('./bootstrap');
require('./filters');
window.Vue = require('vue');
const util = require('util');

import VueGoodTable from 'vue-good-table';
window.Vue.use(VueGoodTable);

Vue.component('breadcrumb', require('./components/BreadCrumb.vue'));
Vue.component('corpusheader', require('./components/CorpusHeader.vue'));
Vue.component('documentheader', require('./components/DocumentHeader.vue'));
Vue.component('annotationheader', require('./components/AnnotationHeader.vue'));
Vue.component('metadata-block-body-corpus', require('./components/CorpusMetadataBlockBody.vue'));
Vue.component('metadata-block-header-document', require('./components/DocumentMetadataBlockHeader.vue'));
Vue.component('metadata-block-body-document', require('./components/DocumentMetadataBlockBody.vue'));
Vue.component('metadata-block-header-annotation', require('./components/AnnotationMetadataBlockHeader.vue'));
Vue.component('metadata-block-body-annotation', require('./components/AnnotationMetadataBlockBody.vue'));

const browseApp = new Vue({
    el: '#browseapp',
    data: {
        header: window.laudatioApp.header,
        headerid: window.laudatioApp.header_id,
        headerdata: window.laudatioApp.header_data.result,
        user: window.laudatioApp.user,
        isloggedin: window.laudatioApp.isLoggedIn
    }
});