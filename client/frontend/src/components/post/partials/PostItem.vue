<script setup>
import { RouterLink } from 'vue-router'
import PostPicture from './PostPicture.vue'

defineProps({
    post: Object
})
</script>

<template>
    <div class="post-item">
        <div class="post-item-inner">
            <PostPicture :post=post />
            <h3 class="post-item-title"><RouterLink :to="{ name: 'postDetail', params: { id: post.id }}">{{ post.title }}</RouterLink></h3>
            <div class="post-item-info"><strong>Author</strong><span>{{ post.user.name }}</span></div>
            <div class="post-item-info"><strong>Created Date</strong><span>{{ post.createdAt }}</span></div>
        </div>
    </div>
</template>
