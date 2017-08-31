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
            <label>Author Forename <input type="text" name="document-author" v-model="documentSearchData.document_author_forename" /></label>
            <label>Author Surname <input type="text" name="document-author" v-model="documentSearchData.document_author_surname" /></label>
            <label>Place <input type="text" name="document-publication-place" v-model="documentSearchData.document_publication_place" /></label>
            <label>Year <input type="text" name="document-publication-publishing-date-from" v-model="documentSearchData.document_publication_publishing_date" /> to <input type="text" name="document-publication-publishing-date-to" v-model="documentSearchData.document_publication_publishing_date_to"  /></label>
            <label>Exact <input type="checkbox" name="documentyeartype" value="exact" v-model="documentSearchData.documentyeartype" /></label>
            <label>Range <input type="checkbox" name="documentyeartype" value="range"   v-model="documentSearchData.documentyeartype" /></label>
            <label>Size <input type="text" name="document-size-extent-from" v-model="documentSearchData.document_size_extent"  /> to <input type="text" name="document-size-extent-to" v-model="documentSearchData.document_size_extent_to" /></label>
            <label>Exact <input type="checkbox" name="documentsizetype" value="exact" v-model="documentSearchData.documentsizetype"  /></label>
            <label>Range <input type="checkbox" name="documentsizetype" value="range" v-model="documentSearchData.documentsizetype"  /></label>
            <br />
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
                    document_author_forename: '',
                    document_author_surname: '',
                    document_publication_place: '',
                    document_publication_publishing_date: '',
                    document_publication_publishing_date_to: '',
                    documentyeartype: '',
                    documentsizetype: '',
                    document_size_extent: '',
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