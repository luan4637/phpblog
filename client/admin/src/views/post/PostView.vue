<script setup>
import PostList from '../../components/post/PostList.vue';
import Navigation from '../../components/partials/Navigation.vue';
</script>

<template>
    <div class="homepage">
        <div class="row">
            <div class="col-2">
                <Navigation />
            </div>
            <div class="col-10">
                <PostList />
            </div>
        </div>
    </div>
</template>
