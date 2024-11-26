<script setup>
    import PostDetail from '../components/post/PostDetail.vue';
    import PopularPost from '../components/post/PopularPost.vue';
</script>

<template>
    <div>
        <div class="container">
            <div class="post-detail-page">
                <PostDetail />
                <div class="popular-posts">
                    <div class="panel">
                        <div class="panel-inner">
                            <h4 class="panel-title">Popular Posts</h4>
                            <div class="panel-content">
                                <PopularPost />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
