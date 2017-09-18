
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
        corpusCacheString: "",
        documentCacheString: "",
        annotationCacheString: "",
        annotationloading: false,
    },
    methods: {
        askElastic: function(search) {
            this.corpusresults = [];
            this.searches.push(search.generalSearchTerm);
            let postData = {
                searchData: {
                    fields: ["corpus_title","corpus_editor_forename","corpus_editor_surname","corpus_publication_publisher","corpus_documents","corpus_encoding_format","corpus_encoding_tool","corpus_encoding_project_description","annotation_name","annotation_type","corpus_annotator_forename","corpus_annotator_surname","annotation_tag_description","corpus_encoding_project_description","corpus_publication_license_description"],
                    query: ''+search.generalSearchTerm+''
                }
            };
            console.log("POSTDATA: "+JSON.stringify(postData))
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
        get_if_exist(collection,str) {
            var value = ""
            for(var i = 0; i < collection.length; i++){
                var obj = collection[i];
                if(obj.hasOwnProperty(str)) {
                    value = obj[str];
                }
            }
            return value;
        },
        remove_if_exist(collection,str) {
            for(var i = 0; i < collection.length; i++){
                var obj = collection[i];
                if(obj.hasOwnProperty(str)) {
                    collection.splice(i,1);
                }
            }
            return collection
        },
        submitCorpusSearch: function(corpusSearchObject) {
            this.corpusloading = true;
            this.corpusresults = [];
            this.corpussearched =  false;
            this.corpusCacheString = "";

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
            for(var p in corpusSearchObject){
                if(corpusSearchObject[p].length > 0){
                    if(dateAndSize.indexOf(p) > -1 && corpusSearchObject[p] != ""
                    && (corpusSearchObject['corpusyeartype'] == "range" || corpusSearchObject['corpussizetype'] == "range")){
                        if(!hasDateAndSize){
                            hasDateAndSize = true;
                        }
                    }
                    else {
                        if(!thereAreMore && corpusSearchObject[p] != ""){
                            thereAreMore = true;
                        }
                    }

                    postDataCollection.push(
                        {
                            [p]: corpusSearchObject[p]
                        }
                    );
                    this.corpusCacheString += '|'+p+'|'+corpusSearchObject[p];
                }

            }



            if(postDataCollection.length > 0){
                console.log(JSON.stringify(postDataCollection))

                var corpusyeartype = this.get_if_exist(postDataCollection,'corpusyeartype');
                var corpussizetype = this.get_if_exist(postDataCollection,'corpussizetype');
                var corpus_publication_publication_date = this.get_if_exist(postDataCollection,'corpus_publication_publication_date');
                var corpusYearTo = this.get_if_exist(postDataCollection,'corpusYearTo');

                var corpus_size_value = this.get_if_exist(postDataCollection,'corpus_size_value');
                var corpusSizeTo = this.get_if_exist(postDataCollection,'corpusSizeTo');



                if( (corpusyeartype && ! corpus_publication_publication_date) && (corpusyeartype && ! corpusYearTo) ){
                    postDataCollection = this.remove_if_exist(postDataCollection,"corpusyeartype");
                }

                if( (corpussizetype && ! corpus_size_value) && (corpussizetype && !corpusSizeTo) ){
                    postDataCollection = this.remove_if_exist(postDataCollection,"corpussizetype");
                }


                if(hasDateAndSize && thereAreMore){
                    postDataCollection.push(
                        {"mixedSearch" : "true"}
                    )
                }
                else{
                    postDataCollection.push(
                        {"mixedSearch" : "false"}
                    )
                }


                let postData = {
                    searchData: postDataCollection,
                    scope: 'corpus',
                    cacheString: this.corpusCacheString
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

                        if(corpus_ids.length > 0) {
                            let documentPostData = {
                                corpus_ids: corpus_ids,
                                corpusRefs: corpusRefs,
                                cacheString: this.corpusCacheString
                            }

                            console.log("corpus_ids: "+corpus_ids)
                            console.log("corpusRefs: "+corpusRefs)

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
                    }//end if data


                    this.corpusloading = false;
                });
            }

        },

        submitDocumentSearch: function(documentSearchObject) {
            this.documentloading = true;
            this.documentresults = [];
            this.documentsearched = false;
            this.documentCacheString = "";
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
            for(var p in documentSearchObject){
                if(documentSearchObject[p].length > 0){
                    if(dateAndSize.indexOf(p) > -1 && documentSearchObject[p] != ""
                        && (documentSearchObject['documentyeartype'] == "range" || documentSearchObject['documentsizetype'] == "range")){
                        if(!hasDateAndSize){
                            hasDateAndSize = true;
                        }
                    }
                    else {
                        if(!thereAreMore && documentSearchObject[p] != ""){
                            thereAreMore = true;
                        }
                    }
                    postDataCollection.push(
                        {
                            [p]: documentSearchObject[p]
                        }
                    );
                    this.documentCacheString += '|'+p+'|'+documentSearchObject[p];
                }

            }



            if(postDataCollection.length > 0){
                let postData = {
                    searchData: postDataCollection,
                    cacheString: this.documentCacheString,
                    scope: 'document'
                };



                var documentyeartype = this.get_if_exist(postDataCollection,'documentyeartype');
                var documentsizetype = this.get_if_exist(postDataCollection,'documentsizetype');

                var document_publication_publishing_date = this.get_if_exist(postDataCollection,'document_publication_publishing_date');
                var document_publication_publishing_date_to = this.get_if_exist(postDataCollection,'document_publication_publishing_date_to');
                var document_size_extent = this.get_if_exist(postDataCollection,'document_size_extent');
                var document_size_extent_to = this.get_if_exist(postDataCollection,'document_size_extent_to');
                if( (documentyeartype && ! document_publication_publishing_date) && (documentyeartype && ! document_publication_publishing_date_to)) {
                    postDataCollection = this.remove_if_exist(postDataCollection,"documentyeartype");
                }

                if( (documentsizetype && ! document_size_extent) && (documentsizetype && ! document_size_extent_to)) {
                    postDataCollection = this.remove_if_exist(postDataCollection,"documentsizetype");
                }


                if(hasDateAndSize && thereAreMore){
                    postDataCollection.push(
                        {"mixedSearch" : "true"}
                    )
                }
                else{
                    postDataCollection.push(
                        {"mixedSearch" : "false"}
                    )
                }
                console.log("POSTDATACOLLECTION: "+JSON.stringify(postData))

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
                            document_ids: document_ids,
                            cacheString: this.documentCacheString,
                        };


                        let corpusPostData = {
                            documentRefs: documentRefs,
                            corpusRefs: corpusRefs,
                            cacheString: this.documentCacheString
                        };
                        console.log("annotationPostData: "+this.documentCacheString);
                        window.axios.post('api/searchapi/getAnnotationsByDocument', JSON.stringify(annotationPostData)).then(annotationRes => {
                            if (Object.keys(annotationRes.data.results).length > 0) {
                                var annotationsByDocument = {}
                                Object.keys(annotationRes.data.results).forEach(function(key) {
                                    annotationsByDocument[key] = annotationRes.data.results[key]
                                });
                            }

                            this.annotationsByDocument = annotationsByDocument;

                        });


                        //console.log("corpusPostData: "+JSON.stringify(corpusPostData));
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
                            cacheString: this.documentCacheString
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

                        });

                    }
                    this.documentloading = false;
                });
            }
        },

        submitAnnotationSearch: function(annotationSearchObject) {
            this.annotationloading = true;
            this.annotationresults = [];
            this.annotationsearched = false;
            let postAnnotationData = {}
            let postDataCollection = [];

            this.annotationCacheString = "";

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
                        postAnnotationData.cacheString =  this.annotationCacheString;


                        window.axios.post('api/searchapi/getDocumentsByAnnotation',postAnnotationData).then(documentsByAnnotationRes => {
                            this.annotationsearched = true;
                            console.log("documentsByAnnotationRes: "+documentsByAnnotationRes);
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


                        });
                        this.annotationloading = false;

                    }
                });
            }
        },

        fetchDocumentsByCorpusId: function(corpus_id) {

        }
    }

});
