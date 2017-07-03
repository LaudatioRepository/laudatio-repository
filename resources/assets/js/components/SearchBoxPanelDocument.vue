/**
* Created by rolf.guescini@gmail.com on 03.067.17.
*/
<template lang="html">
    <div class="Document-box">
        <div class="Document-header">
            Document
        </div>
        <div class="Document-body">
            <label>Title <input type="text" name="document-title" v-model="documentSearchData.document_title" /></label>
            <label>Author <input type="text" name="document-author" v-model="documentSearchData.document_author" /></label>
            <label>Place <input type="text" name="document-publication-place" v-model="documentSearchData.document_publication_place" /></label>
            <label>Year <input type="text" name="document-publication-publishing-date-from" v-model="documentSearchData.document_publication_publishing_date_from" /> to <input type="text" name="document-publication-publishing-date-to" v-model="documentSearchData.document_publication_publishing_date_to"  /></label>
            <label>Size <input type="text" name="document-size-extent-from" v-model="documentSearchData.document_size_extent_from"  /> to <input type="text" name="document-size-extent-to" v-model="documentSearchData.document_size_extent_to" /></label>
            <label>Language <input type="text" name="document-languages-language" v-model="documentSearchData.document_languages_language"  /></label>
            <button class="btn btn-primary document-search-submit-button" @click="emitDocumentData">Search documents</button>
        </div>
    </div>
</template>

<script>
    export default {
        data: function(){
            return {
                documentSearchData : {
                    document_title: '',
                    document_author: '',
                    document_publication_place: '',
                    document_publication_publishing_date_from: '',
                    document_publication_publishing_date_to: '',
                    document_size_extent_from: '',
                    document_size_extent_to: '',
                    document_languages_language: '',
                },
                scope: 'document'
            }
        },
        methods: {
            emitDocumentData(){
                this.$emit('document-search',this.documentSearchData);
            }
        },
        mounted() {
            console.log('DocumentSearchBlock mounted.')
        }
    }
</script>