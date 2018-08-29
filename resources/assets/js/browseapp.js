/**
 * Created by rolfguescini on 07.07.17.
 */
require("./bootstrap");
require("./filters");
window.Vue = require("vue");
const util = require("util");
import VueGoodTable from "vue-good-table";
import "vue-good-table/dist/vue-good-table.css"
window.Vue.use(VueGoodTable);

const VueNestedList = require('vue-nested-list');
Vue.component("nested-list", VueNestedList);

Vue.component("breadcrumb", require("./components/BreadCrumb.vue"));
Vue.component("corpusheader", require("./components/CorpusHeader.vue"));
Vue.component("documentheader", require("./components/DocumentHeader.vue"));
Vue.component("annotationheader", require("./components/AnnotationHeader.vue"));
Vue.component("metadata-block-body-corpus", require("./components/CorpusMetadataBlockBody.vue"));
Vue.component("metadata-block-body-document", require("./components/DocumentMetadataBlockBody.vue"));
Vue.component("metadata-block-body-annotation", require("./components/AnnotationMetadataBlockBody.vue"));

const browseApp = new Vue({
    el: "#rootContainer",
    data: {
        header: window.laudatioApp.header,
        headerid: window.laudatioApp.header_id,
        headerdata: window.laudatioApp.header_data.result,
        citedata: window.laudatioApp.citedata,
        user: window.laudatioApp.user,
        isloggedin: window.laudatioApp.isLoggedIn,
        corpusid: window.laudatioApp.corpus_id,
        corpusname: window.laudatioApp.corpus_name,
        corpuspath: window.laudatioApp.corpus_path,
        workflowstatus: window.laudatioApp.workflow_status,
        corpusversion: window.laudatioApp.corpus_version,
        corpuselasticsearchid: window.laudatioApp.corpus_elasticsearch_id,
        ccbaseuri: window.laudatioApp.ccBaseUri,
        corpusPublicationLicense: window.laudatioApp.corpusPublicationLicense
    }
});