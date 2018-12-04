<template lang="html">
<div id="search_general">
    <input type="text" placeholder="What ?" v-model="generalSearchTerm" @keyup.enter="searchGeneral"/>
    <button class="btn btn-primary" @click="searchGeneral">Search</button>
</div>
</template>

<script>
    export default {
        data(){
          return{
              generalSearchTerm: ''
          }
        },
        props: ['results'],
        methods: {
            searchGeneral() {
                this.$emit('searchedgeneral',
                    {
                        generalSearchTerm: this.generalSearchTerm,
                        scope: 'general'
                    }
                );
                this.generalSearchTerm = '';
            }
        },
        mounted() {
            console.log('SearchComponent mounted.')
        }
    }
</script>