<script setup>
    import PostForm from '../../components/post/PostForm.vue';
    import Navigation from '../../components/partials/Navigation.vue';
</script>

<template>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-2">
                    <Navigation />
                </div>
                <div class="col-10">
                    <PostForm />
                </div>
            </div>
        </div>
    </div>
</template>
