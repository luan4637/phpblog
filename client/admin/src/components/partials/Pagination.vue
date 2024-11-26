<script>
export default {
    name: 'Pagination',
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
        perPage: {
            type: Number,
            required: true
        },
        currentPage: {
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
            this.$emit('pagechanged', 1);
        },
        onClickPreviousPage() {
            this.$emit('pagechanged', this.currentPage - 1);
        },
        onClickPage(page) {
            this.$emit('pagechanged', page);
        },
        onClickNextPage() {
            this.$emit('pagechanged', this.currentPage + 1);
        },
        onClickLastPage() {
            this.$emit('pagechanged', this.totalPages);
        },
        isPageActive(page) {
            return this.currentPage === page;
        },
    }
}
</script>

<template>
    <div class="pagination-wrapper">
        <ul class="pagination justify-content-center mt-4">
            <li class="page-item">
                <a class="page-link" :href="'#/' + ($route.name == 'home' ? '' : $route.name)" @click="onClickFirstPage" :disabled="isInFirstPage">
                    First
                </a>
            </li>
            <li>
                <a class="page-link" :href="'#/' + ($route.name == 'home' ? '' : $route.name)" @click="onClickPreviousPage" :disabled="isInFirstPage">
                    Previous
                </a>
            </li>
            <li v-for="page in pages" :key="page.name">
                <a class="page-link" :href="'#/' + ($route.name == 'home' ? '' : $route.name)" @click="onClickPage(page.name)" :disabled="page.isDisabled">
                    {{ page.name }}
                </a>
            </li>
            <li>
                <a class="page-link" :href="'#/' + ($route.name == 'home' ? '' : $route.name)" @click="onClickNextPage" :disabled="isInLastPage">
                    Next
                </a>
            </li>
            <li>
                <a class="page-link" :href="'#/' + ($route.name == 'home' ? '' : $route.name)" @click="onClickLastPage" :disabled="isInLastPage">
                    Last
                </a>
            </li>
        </ul>
    </div>
</template>

<style scoped>

</style>
