<script setup>
import { ref } from 'vue';
import router from '../router';

const query = ref('');
// query.value = router.params.searchQuery;

const submitClick = () => {
    router.push({ name: 'search', params: { searchQuery: query.value } })
}
</script>

<template>
    <div class="header-form">
        <form @submit.stop.prevent="submitClick">
            <div class="header-form-search">
                <input v-model="query" type="text" placeholder="Search"/>
                <button type="submit">Search</button>
            </div>
        </form>
    </div>
</template>
