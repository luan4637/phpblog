import { defineStore } from "pinia";
import { ref } from "vue";
import { BaseClient } from './BaseClient';
import router from "../router";
import { formatDateMixin } from '@/mixins'

export const usePostStore = defineStore('postStore', {
    state: () => ({
        loading: false,
        total: 0,
        filterInitial: {
            filter: {
                title: '',
                published: undefined,
                position: undefined
            },
            page: 1,
            limit: 16,
        },
        storeFormFilter: {},
        postObjInit: {
            title: '',
            picture: '',
            content: '',
            position: '',
            published: true,
            user: {},
            categories: []
        },
        posts: ref([]),
        post: ref({}),
    }),
    actions: {
        getPosts(filter, page, limit) {
            let queryFilter = '';
            for (let key in filter) {
                if (filter[key] !== undefined && filter[key] !== '') {
                    queryFilter += '&' + key + '=' + filter[key];
                }
            }
            
            let URL = "/post?page=" + (page ?? this.filterInitial.page) + "&limit=" + (limit ?? this.filterInitial.limit) + queryFilter;
            const _this = this;
            this.loading = true;
            BaseClient.get(URL).then(function(response) {
                _this.loading = false;
                _this.posts = response.data.data;
                _this.total = response.data.total;
                _this.page = 0;
                _this.storeFormFilter = filter;
            });
        },
        initPost() {
            this.post = this.postObjInit;
        },
        getPost(id) {
            const URL = "/post/" + id;
            const _this = this;
            this.loading = true;
            _this.post = _this.postObjInit;
            BaseClient.get(URL).then(function(response) {
                _this.loading = false;
                _this.post = response.data.data;
            });
        },
        deletePost(id) {
            const URL = "/post/delete/" + id;
            const _this = this;
            this.loading = true;
            _this.post = {};
            BaseClient.get(URL).then(function(response) {
                _this.loading = false;
                _this.post = response.data.data;
                _this.getPosts(_this.storeFormFilter);
            });
        },
        submitPost(postData, file) {
            let formData = new FormData();
            for (let key in postData) {
                let fieldData = postData[key]
                if (typeof fieldData === 'object') {
                    fieldData = JSON.stringify(fieldData);
                }
                formData.append(key, fieldData);
            }
            if (file) {
                formData.append('picture', file); 
            } else {
                formData.delete('picture');
            }
            
            let URL = '/post/save';
            BaseClient.post(URL, formData).then(function(response) {
                router.push({ name: 'home' })
            });
        },
        listenPostCreated(socket, user) {
            socket.on('presence-new-post', (response) => {
                if (response.data.loggedUser.id == user.id) {
                    return;
                }

                const ulNode = document.createElement('ul');
                ulNode.classList.add('list-group');

                for (var i = 0; i < response.data.postModel.categories.length; i++) {
                    let category = response.data.postModel.categories[i];
                    let liNode = document.createElement('li');
                    liNode.classList.add('list-group-item');
                    liNode.classList.add('lmb-1');
                    liNode.append(document.createTextNode(category.name));
                    ulNode.append(liNode);
                }

                const node = document.createElement('tr');
                const nodePicture = document.createElement('td');
                const nodeTitle = document.createElement('td');
                const nodeCategories = document.createElement('td');
                const nodePublished = document.createElement('td');
                const nodePosition = document.createElement('td');
                const nodeCreatedBy = document.createElement('td');
                const nodeCreatedDate = document.createElement('td');
                const nodeCreatedActions = document.createElement('td');

                nodePicture.append(document.createTextNode(''));
                nodeTitle.append(document.createTextNode(response.data.postModel.title));
                nodeCategories.append(ulNode);
                nodePublished.append(document.createTextNode(response.data.postModel.published.toString().toUpperCase()));
                nodePosition.append(document.createTextNode(response.data.postModel.position));
                nodeCreatedBy.append(document.createTextNode(response.data.postModel.user.name));
                nodeCreatedDate.append(document.createTextNode(formatDateMixin.methods.formatDate(response.data.postModel.createdAt)));
                nodeCreatedActions.append(document.createTextNode(''));

                node.appendChild(nodePicture);
                node.appendChild(nodeTitle);
                node.appendChild(nodeCategories);
                node.appendChild(nodePublished);
                node.appendChild(nodePosition);
                node.appendChild(nodeCreatedBy);
                node.appendChild(nodeCreatedDate);
                node.appendChild(nodeCreatedActions);

                const tableBody = document.getElementById('post_list').getElementsByTagName('tbody')[0];
                tableBody.insertBefore(node, tableBody.children[0]);
                
            });
        },
    },
});
