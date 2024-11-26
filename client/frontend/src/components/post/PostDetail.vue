<script>
    import { watch } from 'vue'
    import { useRoute } from 'vue-router'
    import { mapState } from 'pinia'
    import { usePostStore } from '../../stores/PostStore'

    export default {
        setup() {
            const postStore = usePostStore();
            const route = useRoute();

            watch(
                () => [route.params.id],
                async newValue => {
                    postStore.getPost(newValue[0]);
                }
            );

            return {
                postStore
            };
        },
        computed: {
            ...mapState(usePostStore, ['loading', 'post'])
        },
        methods: {
            getPost(id) {
                this.postStore.getPost(id);
            }
        },
        created() {
            this.getPost(this.$route.params.id);
        }
    }
</script>

<template>
    <div class="post-detail">
        <h1>{{ post.title }}</h1>
        <p>{{ post.content }}</p>
    </div>
</template>