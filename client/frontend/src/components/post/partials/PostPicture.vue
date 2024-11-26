<script setup>
import { RouterLink } from 'vue-router'
import { IMAGE_URL } from '@/config';

defineProps({
    post: Object
})
</script>

<template>
    <figure class="post-item-image"
        ><RouterLink :to="{ name: 'postDetail', params: { id: post.id }}"
        ><img :src="(post.picture ? IMAGE_URL + post.picture : '/img/600x450.png')"
            :alt="post.title"
            :class="post.picture ? '' : 'noimage'"
        /></RouterLink></figure>
</template>
