import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

let initialState = {
    "token": null,
    "user": {}
}

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
        },
        clearCorpus ({commit}, corpora) {
            commit('CLEAR_CORPUS_STATE', corpora)
        },
        clearDocuments ({commit}, documents) {
            commit('CLEAR_DOCUMENT_STATE', documents)
        },
        clearAnnotations ({commit}, documents) {
            commit('CLEAR_ANNOTATION_STATE', documents)
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
        },
        CLEAR_CORPUS_STATE (state, corpora) {
            while(state.corpusByDocument.length > 0) {
                state.corpusByDocument.pop();
            }
        },
        CLEAR_DOCUMENT_STATE (state, documents) {
            while(state.documentsByCorpus.length > 0) {
                state.documentsByCorpus.pop();
            }
        },
        CLEAR_ANNOTATION_STATE (state, annotations) {
            while(state.annotationsByCorpus.length > 0) {
                state.annotationsByCorpus.pop();
            }
            while(state.annotationsByDocument.length > 0) {
                state.annotationsByDocument.pop();
            }
        }

    },
})
