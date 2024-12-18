<script>
    import { mapState } from 'pinia';
    import { RouterLink } from 'vue-router';
    import { useUserStore } from '../../stores/UserStore';
    import { formatDateMixin } from '@/mixins';

    export default {
        setup() {
            const userStore = useUserStore();
            const user = JSON.parse(localStorage.getItem('user') ?? '{}');

            return {
                userStore,
                user
            }
        },
        mixins: [ formatDateMixin ],
        components: {
            RouterLink
        },
        computed: {
            ...mapState(useUserStore, ['notifications']),
        },
        methods: {
            handleClickLogout() {
                this.userStore.logout();
            }
        },
        created() {
            this.userStore.bindNotifications(this.user);
            this.userStore.getNotifications();
        }
    }
</script>

<template>
    <div class="header">
        <div class="container">
            <div class="header-inner">
                <RouterLink class="logo" to="/"><img src="../../assets/logo.svg" /></RouterLink>
                <ul class="header-btns" v-if="Object.keys(this.user).length">
                    <li>
                        <div class="notification-wrapper">
                            <button class="btn-notification"><i class="fa fa-bell-o"></i><span id="notification_total">{{ notifications.length ?? 0 }}</span></button>
                            <ul id="notification_list" class="notification-list">
                                <li v-for="notification in notifications">
                                    <strong>{{ formatDate(notification.created_at) }}</strong>
                                    <p>{{ notification.data.title }}</p>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>{{ user.email }}</li>
                    <li><a href="#" @click="this.handleClickLogout">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</template>
