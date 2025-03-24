<script>
    import { mapState } from 'pinia';
    import { RouterLink } from 'vue-router';
    import { useUserStore } from '../../stores/UserStore';
    import { useNotificationStore } from '../../stores/NotificationStore';
    import { usePostStore } from '../../stores/PostStore';
    import { useSocketStore } from '../../stores/SocketStore';
    import { formatDateMixin } from '@/mixins';

    export default {
        setup() {
            const userStore = useUserStore();
            const notificationStore = useNotificationStore();
            const postStore = usePostStore();
            const socketStore = useSocketStore();
            const user = JSON.parse(localStorage.getItem('user') ?? '{}');

            socketStore.initSocket();

            return {
                userStore,
                notificationStore,
                postStore,
                socketStore,
                user,
            }
        },
        mixins: [ formatDateMixin ],
        components: {
            RouterLink
        },
        computed: {
            ...mapState(useNotificationStore, ['unreadNotifications', 'unreadNotificationsTotal']),
            ...mapState(useSocketStore, ['socket']),
        },
        methods: {
            handleClickLogout() {
                this.userStore.logout();
            }
        },
        created() {
            this.userStore.bindNotifications(this.socket, this.user);
            this.notificationStore.getUnreadNotifications();
            this.postStore.listenPostCreated(this.socket, this.user);
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
                            <button class="btn-notification"><i class="fa fa-bell-o"></i><span id="notification_total">{{ unreadNotificationsTotal }}</span></button>
                            <ul id="notification_list" class="notification-list">
                                <li>
                                    <RouterLink :to="{ name: 'notification' }">View all notifications</RouterLink>
                                </li>
                                <li v-for="notification in unreadNotifications">
                                    <strong>{{ formatDate(notification.created_at) }}</strong>
                                    <p>New post "{{ notification.data.title }}" by {{ notification.data.user?.name }}</p>
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
