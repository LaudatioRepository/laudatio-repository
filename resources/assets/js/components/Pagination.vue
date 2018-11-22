<template>
    <div class="container d-flex flex-column align-items-center justify-content-center mb-5 mt-5">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="First">
                        <span aria-hidden="true"
                              @click="onClickFirstPage"
                              :disabled="isInFirstPage">&laquo;</span>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                    <span
                            @click="onClickPreviousPage"
                            :disabled="isInFirstPage">Previous</span>
                    </a>
                </li>
                <li  class="page-item font-weight-bold" :class="{ active: isPageActive(page.name) }"
                    v-for="page in pages"
                    >
                    <button type="button" class="page-link" href="#"
                       :disabled="page.isDisabled"
                       @click="onClickPage(page.name)"
                       :aria-label="`Go to page number ${page.name}`">{{page.name}}</button>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                     <span
                             @click="onClickNextPage"
                             :disabled="isInLastPage">Next</span>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Last">
                        <span aria-hidden="true"
                              @click="onClickLastPage"
                              :disabled="isInLastPage">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="form-row">
            <div class="col-auto">
                <select class="custom-select custom-select-sm font-weight-bold text-uppercase" @change="setResultsPerPage">
                    <option selected>5 results / page</option>
                    <option value="10">Ten</option>
                    <option value="20">Twenty</option>
                    <option value="50">Fifty</option>
                </select>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        maxVisibleButtons: {
            type: Number,
            required: false,
            default: 3
        },
        totalPages: {
            type: Number,
            required: true
        },
        total: {
            type: Number,
            required: true
        },
        currentPage: {
            type: Number,
            required: true
        },
        headerType: {
            type: String,
            required: true
        },
        perPage: {
            type: Number,
            required: true
        },
    },
    computed: {
        startPage() {
            if (this.currentPage === 1) {
                return 1;
            }

            if (this.currentPage === this.totalPages) {
                return this.totalPages - this.maxVisibleButtons + 1;
            }

            return this.currentPage - 1;

        },
        endPage() {

            return Math.min(this.startPage + this.maxVisibleButtons - 1, this.totalPages);

        },
        pages() {
            const range = [];

            for (let i = this.startPage; i <= this.endPage; i+= 1 ) {
                range.push({
                    name: i,
                    isDisabled: i === this.currentPage
                });
            }

            return range;
        },
        isInFirstPage() {
            return this.currentPage === 1;
        },
        isInLastPage() {
            return this.currentPage === this.totalPages;
        },
    },
    methods: {
        onClickFirstPage() {
            this.$emit(this.headerType+'_pagechanged', 1);
        },
        onClickPreviousPage() {
            this.$emit(this.headerType+'_pagechanged', this.currentPage - 1);
        },
        onClickPage(page) {
            this.$emit(this.headerType+'_pagechanged', page);
        },
        onClickNextPage() {
            this.$emit(this.headerType+'_pagechanged', this.currentPage + 1);
        },
        onClickLastPage() {
            this.$emit(this.headerType+'_pagechanged', this.totalPages);
        },
        isPageActive(page) {
            return this.currentPage === page;
        },
        setResultsPerPage(results) {
            this.$emit(this.headerType+'_resultsperpage', parseInt(results.target.value));
        }
    }
};
</script>