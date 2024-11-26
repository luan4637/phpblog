<script setup>
import { RouterLink, RouterView } from 'vue-router'
import Navigation from './components/Navigation.vue';
import SearchForm from './components/SearchForm.vue';
</script>

<template>
    <div class="header">
        <div class="container">
            <div class="header-logo">
                <RouterLink to="/"><img src="./assets/logo.svg" /></RouterLink>
            </div>
            <SearchForm />
        </div>
    </div>
    <div class="navigation-wrapper">
        <div class="container">
            <Navigation />
        </div>
    </div>
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
