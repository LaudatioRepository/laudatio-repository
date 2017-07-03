/**
* Created by rolf.guescini@gmail.com on 03.067.17.
*/
<template lang="html">
<div class="Annotation-box">
    <div class="Annotation-header">
        Annotation
    </div>
    <div class="Annotation-body">
        <label>Name <input type="text" name="preparation_title" /></label>
        <label>Category <input type="text" name="preparation_encoding_full_name" /></label>
        <label>Format <input type="text" name="preparation_encoding_file_extension" /></label>
        <button class="btn btn-primary annotation-search-submit-button" @click="emitAnnotationData">Search annotations</button>
    </div>
</div>
</template>
<script>
    export default {
        data: function() {
          return {
              annotationSearchData : {
                  preparation_title: '',
                  preparation_encoding_full_name: '',
                  preparation_encoding_file_extension: '',
              },
              scope: 'annotation'
          }
        },
        methods: {
            emitAnnotationData(){
                this.$emit('annotation-search',this.annotationSearchData);
            }
        },
        mounted() {
            console.log('AnnotationsSearchBlock mounted.')
        }
    }
</script>
