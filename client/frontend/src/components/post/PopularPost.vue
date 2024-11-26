<script>
    import { mapState } from 'pinia'
    import { ref } from 'vue'
    import Pagination from '../Pagination.vue'
    import PostItemPopular from './partials/PostItemPopular.vue'
    import { usePostStore } from '../../stores/PostStore'

    export default {
        setup() {
            const postStore = usePostStore();

            return {
                postStore
            };
        },
        components: {
            PostItemPopular,
            Pagination
        },
        computed: {
            ...mapState(usePostStore, ['loading', 'popularPosts']),
        },
        methods: {
            getPosts() {
                this.postStore.getPopularPosts();
            }
        },
        created() {
            this.getPosts();
        },
    }
</script>

<template>
    <div class="posts-list-wrapper">
        <ul class="post-list display-list">
            <li v-for="post in popularPosts">
                <PostItemPopular :post=post />
            </li>
        </ul>
    </div>
</template>
