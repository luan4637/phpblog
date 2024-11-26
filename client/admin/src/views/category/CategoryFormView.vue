<script setup>
    import CategoryForm from '../../components/category/CategoryForm.vue';
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
                    <CategoryForm />
                </div>
            </div>
        </div>
    </div>
</template>
