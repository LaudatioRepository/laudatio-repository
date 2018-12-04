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
            <!--label>Corpus Editor Forename <input type="text" name="document-author" v-model="corpusSearchData.corpus_editor_forename" /></label>
            <label>Corpus Editor Surname <input type="text" name="document-author" v-model="corpusSearchData.corpus_editor_surname" /></label-->
        <label>Corpus Editor <input type="text" name="document-author" v-model="corpusSearchData.corpus_merged_editors" /></label>
        <label>Year <input  placeholder="From" type="text" id="corpus-year-from" v-model="corpusSearchData.corpus_publication_publication_date" />
        <input  placeholder="To" type="text" id="corpus-year-to" v-model="corpusSearchData.corpusYearTo" /></label>
        <label>Exact <input class="yearradio" type="radio" id="corpusyeartype_exact" value="exact" v-model="corpusSearchData.corpusyeartype" checked="checked" /></label>
		 <label>Range <input class="yearradio" type="radio" id="corpusyeartype_range" value="range" v-model="corpusSearchData.corpusyeartype"  /></label>

        <label>Size <input placeholder="From"  type="text" name="corpus-size-from" v-model="corpusSearchData.corpus_size_value" /> to <input  placeholder="To" type="text" id="corpus-size-to" v-model="corpusSearchData.corpusSizeTo" /></label>
        <label>Exact <input class="sizeradio" type="radio" id="corpussizetype" value="exact" v-model="corpusSearchData.corpussizetype" checked/></label>
        <label>Range <input class="sizeradio" type="radio" id="corpussizetype" value="range" v-model="corpusSearchData.corpussizetype"/></label>

        <br />
        <label>Language <input placeholder="Corpus language"  type="text" name="corpus-language" v-model="corpusSearchData.corpus_merged_languages" /></label>
        <label>Format <input placeholder="Corpus format"  type="text" name="corpus-format" v-model="corpusSearchData.corpus_merged_formats" /></label>
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
                    corpus_editor_forename: '',
                    corpus_editor_surname: '',
                    corpus_merged_editors: '',
                    corpus_publication_publication_date: '',
                    corpusYearTo: '',
                    corpusyeartype: 'exact',
                    corpussizetype: 'exact',
                    corpus_size_value: '',
                    corpusSizeTo: '',
                    corpus_merged_languages: '',
                    corpus_merged_formats: ''
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

    $(function () {
        $('.sizeradio').change(function () {
            if($(this).attr('value') == 'exact'){
                $('#corpus-size-to').prop('disabled', true);
            }
            else{
                $('#corpus-size-to').prop('disabled', false);
            }
        });


        $('.yearradio').change(function () {
            if($(this).attr('value') == 'exact'){
                $('#corpus-year-to').prop('disabled', true);
            }
            else{
                $('#corpus-year-to').prop('disabled', false);
            }
        });
    });
</script>