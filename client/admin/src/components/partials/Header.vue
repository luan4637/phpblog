<script>
    import { RouterLink } from 'vue-router'
    import { useUserStore } from '../../stores/UserStore'

    export default {
        setup() {
            const userStore = useUserStore();
            const user = JSON.parse(localStorage.getItem('user') ?? '{}');

            return {
                userStore,
                user
            }
        },
        components: {
            RouterLink
        },
        methods: {
            handleClickLogout() {
                this.userStore.logout()
            }
        }
    }
</script>

<template>
    <div class="header">
        <div class="container">
            <div class="header-inner">
                <RouterLink class="logo" to="/"><img src="../../assets/logo.svg" /></RouterLink>
                <ul class="header-btns">
                    <li>{{ user?.email }}</li>
                    <li><a href="#" @click="this.handleClickLogout">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</template>
