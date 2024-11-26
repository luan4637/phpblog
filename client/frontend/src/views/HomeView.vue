<script setup>
import LatestPost from '../components/post/LatestPost.vue';
import FeaturePost from '../components/post/FeaturePost.vue';
import PopularPost from '../components/post/PopularPost.vue';
</script>

<template>
    <div class="homepage">
        <div class="feature-posts">
            <FeaturePost />
        </div>
        <div class="latest-posts">
            <div class="panel">
                <div class="panel-inner">
                    <h4 class="panel-title">
                        Latest Posts
                        <RouterLink :to="{ name: 'latest' }">More</RouterLink>
                    </h4>
                    <div class="panel-content">
                        <LatestPost />
                    </div>
                </div>
            </div>
        </div>
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
</template>
