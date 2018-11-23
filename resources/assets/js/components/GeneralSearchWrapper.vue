<template lang="html">
    <div class="col-6 d-flex justify-content-center align-items-center ml-auto mr-auto">

        <form class="form-group serviceBarSearch w-100">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search metadata (German or English)" aria-label="search metadata"
                       aria-describedby="basic-addon2" v-model="generalSearchTerm" @keyup.enter="searchGeneral">
                <div class="input-group-append">
                    <button type="button" class="clear-search close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <button class="btn btn-outline-corpus-dark pl-4 pr-4" type="button"  @click="searchGeneral">
                        <i class="text-primary fa fa-fw fa-search fa-lg "></i>
                    </button>
                </div>
            </div>
        </form>

        <i class="btn p-0 fa fa-info-circle fa-fw fa-lg ml-3" data-toggle="tooltip" role="button" data-placement="bottom"
           title="Get help how to search"></i>
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
                console.log("@keyup fired")
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
            console.log('General SearchComponent mounted.')
        }
    }
</script>