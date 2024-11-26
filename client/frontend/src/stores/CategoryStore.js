import { defineStore } from "pinia";
import axios from "axios";
import { ref } from "vue";
import { BaseClient } from './BaseClient';
import { API_URL } from "@/config";

export const useCategoryStore = defineStore('categoryStore', {
    state: () => ({
        loading: false,
        total: 0,
        page: 1,
        limit: 10,
        categories: ref([]),
        category: ref({}),
    }),
    actions: {
        getCategories(page, limit) {
            let URL = API_URL + "/category?page=" + (page ?? 1) + "&limit=" + (limit ?? 10) + "&showInNav=1";
            const _this = this;
            this.loading = true;
            BaseClient.get(URL).then(function(response) {
                _this.loading = false;
                _this.categories = response.data.data;
                _this.total = response.data.total;
                _this.page = 1;
            });
        },
        getCategory(id) {
            const URL = API_URL + "/category/" + id;
            const _this = this;
            this.loading = true;
            _this.category = {};
            BaseClient.get(URL).then(function(response) {
                _this.loading = false;
                _this.category = response.data;
            });
        },
    },
});
