import { defineStore } from "pinia";
import { ref } from "vue";
import { BaseClient } from './BaseClient';
import router from "../router";
import { formatDateMixin } from '@/mixins'

export const useNotificationStore = defineStore('notificationStore', {
    state: () => ({
        loading: false,
        total: 0,
        overlayNotificationsTotal: 0,
        filterInitial: {
            page: 1,
            limit: 10,
        },
        notifications: ref([]),
        overlayNotifications: ref([]),
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
        getOverlayNotifications(page, limit) {
            let URL = "/notification?page=" + page + "&limit=" + limit;
            const _this = this;
            this.loading = true;
            BaseClient.get(URL).then(function(response) {
                _this.loading = false;
                _this.overlayNotifications = response.data.data;
                _this.overlayNotificationsTotal = response.data.total;
                _this.page = 0;
            });
        },
    },
});
