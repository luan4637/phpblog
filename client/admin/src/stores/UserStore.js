import { defineStore } from "pinia";
import { ref } from "vue";
import { BaseClient } from './BaseClient';
import router from "../router";
import { formatDateMixin } from '@/mixins'

export const useUserStore = defineStore('userStore', {
    state: () => ({
        loading: false,
        total: 0,
        filterInitial: {
            filter: {
                name: '',
                email: ''
            },
            page: 1,
            limit: 16,
        },
        userObjInit: {
            name: '',
            email: '',
            password: '',
            roles: []
        },
        users: ref([]),
        user: ref({}),
        notifications: ref([]),
    }),
    actions: {
        getUsers(filter, page, limit) {
            let queryFilter = '';
            for (let key in filter) {
                if (filter[key] !== undefined && filter[key] !== '') {
                    queryFilter += '&' + key + '=' + filter[key];
                }
            }

            let URL = "/user?page=" + (page ?? this.filterInitial.page) + "&limit=" + (limit ?? this.filterInitial.limit) + queryFilter;
            const _this = this;
            this.loading = true;
            BaseClient.get(URL).then(function(response) {
                _this.loading = false;
                _this.users = response.data.data;
                _this.total = response.data.total;
                _this.page = 0;
            });
        },
        initUser() {
            this.user = this.userObjInit;
        },
        getUser(id) {
            const URL = "/user/" + id;
            const _this = this;
            this.loading = true;
            _this.user = _this.userObjInit;
            BaseClient.get(URL).then(function(response) {
                _this.loading = false;
                _this.user = response.data.data;
                _this.user.password = '';
            });
        },
        submitUser(userData) {
            let URL = '/user/save';
            BaseClient.post(URL, userData).then(function(response) {
                router.push({ name: 'user' })
            });
        },
        login(userData) {
            let URL = '/login';
            BaseClient.post(URL, userData).then(function(response) {
                const user = response.data.data;
                localStorage.setItem('user', JSON.stringify(user));
                if (user.token !== undefined) {
                    router.push({ name: 'home' });
                    setTimeout(() => {
                        window.location.reload();
                    }, 200);
                }
            });
        },
        logout() {
            let URL = '/logout';
            BaseClient.get(URL, {}).then(function(response) {
                const result = response.data.data;
                if (result == true) {
                    localStorage.removeItem('user');
                    router.push({ name: 'login' })
                }
            });
        },
        getNotifications() {
            let URL = '/notification';
            const _this = this;
            BaseClient.get(URL).then(function(response) {
                _this.notifications = response.data.data;
            });
        },
        bindNotifications(socket, user) {
            const userId = user.id;

            if (!userId) {
                return;
            }
            
            socket.on('private-App.Core.User.UserModel.' + userId, (response) => {
                const node = document.createElement('li');
                const nodeDate = document.createElement('strong');
                const nodeText = document.createElement('p');
                nodeDate.append(document.createTextNode(formatDateMixin.methods.formatDate(response.data.createdAt)));
                nodeText.append(document.createTextNode(response.data.title));
                node.appendChild(nodeDate);
                node.appendChild(nodeText);
                document.getElementById('notification_list').appendChild(node);
                setTimeout(() => {
                    let totalNotification = document.getElementById('notification_list').getElementsByTagName('li').length
                    document.getElementById('notification_total').innerText = totalNotification;
                }, 100)
            });
        }
    },
});
