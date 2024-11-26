<script setup>
import { RouterView } from 'vue-router'
import Header from './components/partials/Header.vue';
</script>

<template>
    <Header />
    <div class="main-content">
        <div class="container">
            <RouterView />
        </div>
    </div>
    <div class="footer">
        <div class="container">
            Footer
        </div>
    </div>
</template>
