
<script setup>
import CategoryList from '../../components/category/CategoryList.vue';
import Navigation from '../../components/partials/Navigation.vue';
</script>

<template>
    <div class="homepage">
        <div class="row">
            <div class="col-2">
                <Navigation />
            </div>
            <div class="col-10">
                <CategoryList />
            </div>
        </div>
    </div>
</template>
