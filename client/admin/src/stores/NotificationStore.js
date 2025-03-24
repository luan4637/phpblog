import { defineStore } from "pinia";
import { ref } from "vue";
import { BaseClient } from './BaseClient';
import router from "../router";
import { formatDateMixin } from '@/mixins'

export const useNotificationStore = defineStore('notificationStore', {
    state: () => ({
        loading: false,
        total: 0,
        unreadNotificationsTotal: 0,
        filterInitial: {
            page: 1,
            limit: 10,
        },
        notifications: ref([]),
        unreadNotifications: ref([]),
    }),
    actions: {
        getNotifications(page, limit) {
            let URL = "/notification?page=" + (page ?? this.filterInitial.page) + "&limit=" + (limit ?? this.filterInitial.limit);
            const _this = this;
            this.loading = true;
            BaseClient.get(URL).then(function(response) {
                _this.loading = false;
                _this.notifications = response.data.data;
                _this.total = response.data.total;
                _this.page = 0;
            });
        },
        getUnreadNotifications() {
            let URL = "/notification/unread";
            const _this = this;
            this.loading = true;
            BaseClient.get(URL).then(function(response) {
                _this.loading = false;
                _this.unreadNotifications = response.data.data;
                _this.unreadNotificationsTotal = response.data.total;
                _this.page = 0;
            });
        },
        markAsRead(id) {
            let URL = "/notification/mark-as-read/" + id;
            BaseClient.post(URL).then(function(response) {
                
            });
        }
    },
});
