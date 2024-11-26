<script>
    import { mapState } from 'pinia'
    import { ref } from 'vue'
    import Pagination from '../Pagination.vue'
    import PostItem from './partials/PostItem.vue'
    import { usePostStore } from '../../stores/PostStore'

    export default {
        props: [ 'showPagination' ],
        setup(props) {
            const postStore = usePostStore();
            const currentPage = ref(1);
            const showPagination = props.showPagination;
            
            return {
                postStore,
                currentPage,
                showPagination
            };
        },
        components: {
            PostItem,
            Pagination
        },
        computed: {
            ...mapState(usePostStore, ['loading', 'posts', 'total', 'page', 'limit']),
        },
        methods: {
            handleClickPagination(pageNumber) {
                this.getPosts(pageNumber, 10);
                this.currentPage = pageNumber;
            },
            getPosts(pageNumber, limit) {
                this.postStore.getPosts('', '', pageNumber, limit);
            }
        },
        created() {
            this.getPosts();
        },
    }
</script>

<template>
    <div class="posts-list-wrapper">
        <ul class="post-list">
            <li v-for="post in posts">
                <PostItem :post=post />
            </li>
        </ul>
        <Pagination
            v-if="showPagination"
            :currentPage="currentPage"
            :perPage="10"
            :total="total"
            :totalPages="Math.ceil(total / limit)"
            :maxVisibleButtons="5"
            @pagechanged="this.handleClickPagination" />
    </div>
</template>
