
<script setup>

</script>

<template>
    <div class="navigation">
        <ul class="navbar">
            <li>
                <RouterLink :to="{ name: 'home' }" class="navbar-brand">Posts management</RouterLink>
            </li>
            <li>
                <RouterLink :to="{ name: 'category' }" class="navbar-brand">Categories management</RouterLink>
            </li>
            <li>
                <RouterLink :to="{ name: 'user' }" class="navbar-brand">Users management</RouterLink>
            </li>
        </ul>
    </div>
</template>
