<script setup>
import { RouterLink } from 'vue-router'
import PostPicture from './PostPicture.vue'

defineProps({
    post: Object
})
</script>

<template>
    <div class="post-item post-item-feature">
        <div class="post-item-inner">
            <PostPicture :post=post />
            <h3 class="post-item-title"><RouterLink :to="{ name: 'postDetail', params: { id: post.id }}">{{ post.title }}</RouterLink></h3>
        </div>
    </div>
</template>
