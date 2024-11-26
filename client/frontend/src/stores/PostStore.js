import { defineStore } from "pinia";
import axios from "axios";
import { ref } from "vue";
import { BaseClient } from './BaseClient';
import { API_URL } from "./constants";

export const usePostStore = defineStore('postStore', {
    state: () => ({
        loading: false,
        total: 0,
        page: 1,
        limit: 10,
        posts: ref([]),
        featurePosts: ref([]),
        popularPosts: ref([]),
        post: ref({}),
    }),
    actions: {
        getPosts(category, searchQuery, page, limit) {
            let queryFilter = '';
            if (category !== undefined && category !== '') {
                queryFilter += '&category=' + category;
            }

            if (searchQuery !== undefined && searchQuery !== '') {
                queryFilter += '&searchQuery=' + searchQuery;
            }

            let URL = API_URL + "/post?page=" + (page ?? this.page) + "&limit=" + (limit ?? this.limit) + queryFilter;
            const _this = this;
            this.loading = true;
            BaseClient.get(URL).then(function(response) {
                _this.loading = false;
                _this.posts = response.data.data;
                _this.total = response.data.total;
            });
        },
        getFeaturePosts() {
            let URL = API_URL + "/post?position=FEATURE&page=1&limit=3";
            const _this = this;
            this.loading = true;
            BaseClient.get(URL).then(function(response) {
                _this.loading = false;
                _this.featurePosts = response.data.data;
                _this.total = response.data.total;
            });
        },
        getPopularPosts() {
            let URL = API_URL + "/post?position=POPULAR&page=1&limit=5";
            const _this = this;
            this.loading = true;
            BaseClient.get(URL).then(function(response) {
                _this.loading = false;
                _this.popularPosts = response.data.data;
                _this.total = response.data.total;
            });
        },
        getPost(id) {
            const URL = API_URL + "/post/" + id;
            const _this = this;
            this.loading = true;
            _this.post = {};
            BaseClient.get(URL).then(function(response) {
                _this.loading = false;
                _this.post = response.data.data;
            });
        },
    },
});
