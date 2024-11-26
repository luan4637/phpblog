<script>
    import { mapState } from 'pinia'
    import { ref, watch } from 'vue'
    import { useRoute } from 'vue-router'
    import Pagination from '../Pagination.vue'
    import PostItem from './partials/PostItem.vue'
    import { usePostStore } from '../../stores/PostStore'
    
    export default {
        setup() {
            const postStore = usePostStore();
            const currentPage = ref(1);
            const pageLimit = ref(12);
            const route = useRoute();

            watch(
                () => [route.params.category, route.params.searchQuery],
                async newValue => {
                    postStore.getPosts(newValue[0], newValue[1]);
                }
            );
            
            return {
                postStore,
                currentPage,
                pageLimit
            };
        },
        props: {
            layout: String
        },
        components: {
            PostItem,
            Pagination
        },
        computed: {
            ...mapState(usePostStore, ['loading', 'posts', 'total']),
        },
        methods: {
            handleClickPagination(pageNumber) {
                const category = this.$route.params.category;
                const searchQuery = this.$route.params.searchQuery;
                this.getPosts(category, searchQuery, pageNumber, this.pageLimit);
                this.currentPage = pageNumber;
            },
            getPosts(category, searchQuery, pageNumber, limit) {
                this.postStore.getPosts(category, searchQuery, pageNumber, limit);
            }
        },
        created() {
            const category = this.$route.params.category;
            const searchQuery = this.$route.params.searchQuery;
            this.getPosts(category, searchQuery, 1, this.pageLimit);
        },
    }
</script>

<template>
    <div class="posts-list-wrapper">
        <ul :class="'post-list ' + layout">
            <li v-for="post in posts">
                <PostItem :post=post />
            </li>
        </ul>
        <Pagination
            :currentPage="currentPage"
            :perPage="pageLimit"
            :total="total"
            :totalPages="Math.ceil(total / pageLimit)"
            :maxVisibleButtons="5"
            @pagechanged="this.handleClickPagination" />
    </div>
</template>
