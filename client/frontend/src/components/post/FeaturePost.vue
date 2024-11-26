<script>
    import { mapState } from 'pinia'
    import { ref } from 'vue'
    import Pagination from '../Pagination.vue'
    import PostItemFeature from './partials/PostItemFeature.vue'
    import { usePostStore } from '../../stores/PostStore'

    export default {
        setup() {
            const postStore = usePostStore();

            return {
                postStore
            };
        },
        components: {
            PostItemFeature,
            Pagination
        },
        computed: {
            ...mapState(usePostStore, ['loading', 'featurePosts']),
        },
        methods: {
            getPosts() {
                this.postStore.getFeaturePosts();
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
            <li v-for="post in featurePosts">
                <PostItemFeature :post=post />
            </li>
        </ul>
    </div>
</template>
