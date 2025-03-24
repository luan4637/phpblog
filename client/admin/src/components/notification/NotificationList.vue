<script>
    import { mapState } from 'pinia'
    import { ref } from 'vue'
    import Pagination from '../partials/Pagination.vue'
    import { useNotificationStore } from '../../stores/NotificationStore'
    import { formatDateMixin } from '@/mixins'

    export default {
        setup() {
            const notificationStore = useNotificationStore();
            const currentPage = ref(1);
            const formFilter = ref({});

            return {
                notificationStore,
                currentPage,
                formFilter
            };
        },
        mixins: [ formatDateMixin ],
        components: {
            Pagination
        },
        computed: {
            ...mapState(useNotificationStore, ['loading', 'notifications', 'total', 'filterInitial']),
        },
        methods: {
            handleClickPagination(pageNumber) {
                this.currentPage = pageNumber;
                this.getNotifications(pageNumber);
            },
            getNotifications(page, limit) {
                this.notificationStore.getNotifications(page, limit);
            },
            onMarkAsRead(notificationId, event) {
                this.notificationStore.markAsRead(notificationId);

                const date = new Date();
                const curDate = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + ' ' + date.getHours() + ':' + date.getMinutes();
                event.target.classList.add('hidden');
                event.target.parentNode.parentNode.getElementsByClassName('js-read-at')[0].innerHTML = curDate;
            }
        },
        created() {
            this.formFilter = JSON.parse(JSON.stringify(this.filterInitial));
            this.getNotifications(this.formFilter.page, this.formFilter.limit);
        },
    }
</script>

<template>
    <div class="table-notifications">
        <div class="mt-3 mb-3 d-flex flex-row-reverse">
            &nbsp;
        </div>
        <div class="table-notifications-inner">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="text-nowrap">Type</th>
                        <th class="text-nowrap">notifiable_id</th>
                        <th class="text-nowrap">data</th>
                        <th class="text-nowrap" style="width: 10em;">read_at</th>
                        <th class="text-nowrap" style="width: 10em;">created_at</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="notification in notifications">
                        <td class="align-middle">{{ notification.type }}</td>
                        <td class="align-middle">{{ notification.notifiable_id }}</td>
                        <td class="align-middle">{{ notification.data }}</td>
                        <td class="align-middle js-read-at">{{ notification.read_at ? formatDate(notification.read_at) : '' }}</td>
                        <td class="align-middle">{{ formatDate(notification.created_at) }}</td>
                        <td class="text-center">
                            <button class="btn btn-primary text-nowrap"
                                @click="onMarkAsRead(notification.id, $event)"
                                v-if="!notification.read_at"
                            >Mark as read</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <Pagination
            :currentPage="currentPage"
            :perPage="10"
            :total="total"
            :totalPages="Math.ceil(total / formFilter.limit)"
            :maxVisibleButtons="5"
            @pagechanged="this.handleClickPagination" />
    </div>
</template>
