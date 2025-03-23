
<script setup>
import NotificationList from '../../components/notification/NotificationList.vue';
import Navigation from '../../components/partials/Navigation.vue';
</script>

<template>
    <div class="homepage">
        <div class="row">
            <div class="col-2">
                <Navigation />
            </div>
            <div class="col-10">
                <NotificationList />
            </div>
        </div>
    </div>
</template>
