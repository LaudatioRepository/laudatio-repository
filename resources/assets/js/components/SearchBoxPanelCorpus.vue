/**
* Created by rolf.guescini@gmail.com on 30.06.17.
*/
<template lang="html">
<div class="Corpus-box">
    <div class="Corpus-header">
      Corpus

    </div>
    <div class="Corpus-body">
        <label>Name <input placeholder="Corpus name" type="text" name="corpus-name" v-model="corpusSearchData.corpus_title" /></label>
        <label>Publisher <input placeholder="Corpus publisher"  type="text" name="corpus-publisher" v-model="corpusSearchData.corpus_publication_publisher" /></label>
        <label>Year <input  placeholder="From" type="text" name="corpus-year-from" v-model="corpusSearchData.corpus_publication_publication_date" /> to <input  placeholder="To" type="text" name="corpus-year-to" v-model="corpusSearchData.corpusYearTo" /></label>
        <label>Size <input placeholder="From"  type="text" name="corpus-size-from" v-model="corpusSearchData.corpus_size_value" /> to <input  placeholder="To" type="text" name="corpus-size-to" v-model="corpusSearchData.corpusSizeTo" /></label>
        <label>Language <input placeholder="Corpus language"  type="text" name="corpus-language" v-model="corpusSearchData.corpus_languages_language" /></label>
        <label>Format <input placeholder="Corpus format"  type="text" name="corpus-format" v-model="corpusSearchData.corpus_encoding_format" /></label>
        <button class="btn btn-primary corpus-search-submit-button" @click="emitCorpusData">Search corpora</button>
    </div>
</div>
</template>

<script>
    export default {
        data: function(){
            return {
                corpusSearchData : {
                    corpus_title: '',
                    corpus_publication_publisher: '',
                    corpus_publication_publication_date: '',
                    corpusYearTo: '',
                    corpus_size_value: '',
                    corpusSizeTo: '',
                    corpus_languages_language: '',
                    corpus_encoding_format: ''
                },
                scope: 'corpus'
            }
        },
        methods: {
            emitCorpusData(){
                this.$emit('corpus-search',this.corpusSearchData);
            }
        },
        mounted() {
            console.log('CorpusSearchBlock mounted.')
        }
    }
</script>