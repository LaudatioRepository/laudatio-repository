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
        annotationsByDocument: [],
        corpusByAnnotation: [],
        documentsByAnnotation: []
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
        documentByAnnotation ({commit}, documents) {
            commit('PUSH_DOCUMENT_BY_ANNOTATION', documents)
        },
        corpusByAnnotation ({commit}, corpora) {
            commit('PUSH_CORPUS_BY_ANNOTATION', corpora)
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
        },
        annotationcorpus: state => {
            return state.corpusByAnnotation
        },
        annotationdocuments: state => {
            return state.documentsByAnnotation
        },

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
        PUSH_DOCUMENT_BY_ANNOTATION (state, documents) {
            state.documentsByAnnotation.push(documents)
        },
        PUSH_CORPUS_BY_ANNOTATION (state, corpora) {
            state.corpusByAnnotation.push(corpora)
        },
        CLEAR_CORPUS_STATE (state, corpora) {
            while(state.corpusByDocument.length > 0) {
                state.corpusByDocument.pop();
            }

            while(state.corpusByAnnotation.length > 0) {
                state.corpusByAnnotation.pop();
            }

        },
        CLEAR_DOCUMENT_STATE (state, documents) {
            while(state.documentsByCorpus.length > 0) {
                state.documentsByCorpus.pop();
            }

            while(state.documentsByAnnotation.length > 0) {
                state.documentsByAnnotation.pop();
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
