
<script setup>
import UserList from '../../components/user/UserList.vue';
import Navigation from '../../components/partials/Navigation.vue';
</script>

<template>
    <div class="homepage">
        <div class="row">
            <div class="col-2">
                <Navigation />
            </div>
            <div class="col-10">
                <UserList />
            </div>
        </div>
    </div>
</template>
