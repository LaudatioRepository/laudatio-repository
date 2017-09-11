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
            <!--label>Author Forename <input type="text" name="document-author" v-model="documentSearchData.document_author_forename" /></label>
            <label>Author Surname <input type="text" name="document-author" v-model="documentSearchData.document_author_surname" /></label-->
            <label>Author <input type="text" name="document-author" v-model="documentSearchData.document_merged_authors" /></label>
            <label>Place <input type="text" name="document-publication-place" v-model="documentSearchData.document_publication_place" /></label>
            <label>Year <input type="text" id="document-publication-publishing-date-from" v-model="documentSearchData.document_publication_publishing_date" /> to <input type="text" id="document-publication-publishing-date-to" v-model="documentSearchData.document_publication_publishing_date_to"  /></label>
            <label>Exact <input class="yearradio" type="radio" id="documentyeartype_exact" value="exact" v-model="documentSearchData.documentyeartype" /></label>
            <label>Range <input class="yearradio" type="radio" id="documentyeartype_range" value="range"   v-model="documentSearchData.documentyeartype" /></label>
            <label>Size <input type="text" id="document-size-extent-from" v-model="documentSearchData.document_size_extent" /> to <input type="text" id="document-size-extent-to" v-model="documentSearchData.document_size_extent_to" /></label>
            <label>Exact <input class="sizeradio" type="radio" id="documentsizetype_exact" value="exact" v-model="documentSearchData.documentsizetype"  /></label>
            <label>Range <input class="sizeradio"  type="radio" id="documentsizetype_range" value="range" v-model="documentSearchData.documentsizetype"  /></label>
            <br />
            <label>Language <input type="text" name="document-languages-language" v-model="documentSearchData.document_merged_languages"  /></label>
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
                    document_merged_authors: '',
                    document_publication_place: '',
                    document_publication_publishing_date: '',
                    document_publication_publishing_date_to: '',
                    documentyeartype: 'exact',
                    documentsizetype: 'exact',
                    document_size_extent: '',
                    document_size_extent_to: '',
                    document_languages_language: '',
                    document_merged_languages: ''
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

    $(function () {
        $('.sizeradio').change(function () {
            if($(this).attr('value') == 'exact'){
                $('#document-size-extent-to').prop('disabled', true);
            }
            else{
                $('#document-size-extent-to').prop('disabled', false);
            }
        });


        $('.yearradio').change(function () {
            if($(this).attr('value') == 'exact'){
                $('#document-publication-publishing-date-to').prop('disabled', true);
            }
            else{
                $('#document-publication-publishing-date-to').prop('disabled', false);
            }
        });
    });
</script>