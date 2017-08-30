import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)
export default new Vuex.Store({
    state: {
        documentsByCorpus: [],
        annotationsByCorpus: [],
        corpusByDocument: [],
        annotationsByDocument: []
    },

    actions: {
        documentByCorpus ({commit}, documents) {
            commit('PUSH_DOCUMENT_BY_CORPUS', documents)
        },
        annotationByCorpus ({commit}, annotations) {
            commit('PUSH_ANNOTATION_BY_CORPUS', annotations)
        },
        annotationByDocument ({commit}, annotations) {
            commit('PUSH_ANNOTATION_BY_DOCUMENT', annotations)
        },
        corpusByDocument ({commit}, corpora) {
            commit('PUSH_CORPUS_BY_DOCUMENT', corpora)
        }
    },
    getters: {
        corpusdocuments: state => {
            return state.documentsByCorpus
        },
        corpusannotations: state => {
            return state.annotationsByCorpus
        },
        documentannotations: state => {
            return state.annotationsByDocument
        },
        documentcorpus: state => {
            return state.corpusByDocument
        }
    },
    mutations: {
        PUSH_DOCUMENT_BY_CORPUS (state, documents) {
            state.documentsByCorpus.push(documents)
        },
        PUSH_ANNOTATION_BY_CORPUS (state, annotations) {
            state.annotationsByCorpus.push(annotations)
        },
        PUSH_ANNOTATION_BY_DOCUMENT (state, annotations) {
            state.annotationsByDocument.push(annotations)
        },
        PUSH_CORPUS_BY_DOCUMENT (state, corpora) {
            state.corpusByDocument.push(corpora)
        }
    },
})
