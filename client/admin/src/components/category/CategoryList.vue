<script>
    import { mapState } from 'pinia'
    import { ref } from 'vue'
    import Pagination from '../partials/Pagination.vue'
    import { useCategoryStore } from '../../stores/CategoryStore'
    import { formatDateMixin } from '@/mixins'

    export default {
        setup() {
            const categoryStore = useCategoryStore();
            const currentPage = ref(1);
            const formFilter = ref({});

            return {
                categoryStore,
                currentPage,
                formFilter
            };
        },
        mixins: [ formatDateMixin ],
        components: {
            Pagination
        },
        computed: {
            ...mapState(useCategoryStore, ['loading', 'categories', 'total', 'filterInitial']),
        },
        methods: {
            handleClickPagination(pageNumber) {
                this.currentPage = pageNumber;
                this.getCategories(this.formFilter.filter, pageNumber, this.formFilter.limit);
            },
            handleClickDelete(id) {
                if (confirm('Are you sure you want to delete?')) {
                    this.categoryStore.deleteCategory(id);
                }
            },
            handleFilter() {
                this.getCategories(this.formFilter.filter, this.formFilter.page, this.formFilter.limit);
            },
            handleClearFilter() {
                this.formFilter = JSON.parse(JSON.stringify(this.filterInitial));
                this.getCategories(this.formFilter.filter, this.formFilter.page, this.formFilter.limit);
            },
            getCategories(filter, page, limit) {
                this.categoryStore.getCategories(filter, page, limit);
            }
        },
        created() {
            this.formFilter = JSON.parse(JSON.stringify(this.filterInitial));
            this.getCategories(this.formFilter.filter, this.formFilter.page, this.formFilter.limit);
        },
    }
</script>

<template>
    <div class="table-categories">
        <div class="table-categories-filter">
            <form class="row" autocomplete="off">
                <div class="form-group col-3">
                    <label for="name">Category Name</label>
                    <input id="name" type="text" placeholder="Category Name" class="form-control" v-model="formFilter.filter.name" />
                </div>
                <div class="form-group col">
                    <label for="description">Description</label>
                    <input id="description" type="text" placeholder="Description" class="form-control" v-model="formFilter.filter.description" />
                </div>
                <div class="form-group col-auto">
                    <label>&nbsp;</label>
                    <p>
                        <button type="button" class="btn btn-primary" @click="this.handleFilter">Filter</button>
                        <button type="button" class="btn btn-secondary ms-2" @click="this.handleClearFilter">Clear</button>
                    </p>
                </div>
            </form>
        </div>
        <div class="mt-3 mb-3 d-flex flex-row-reverse">
            <RouterLink :to="{ name: 'categoryCreate' }" class="btn btn-primary">Create</RouterLink>
        </div>
        <div class="table-categories-inner">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="text-nowrap">Category Name</th>
                        <th>Description</th>
                        <th class="text-nowrap">Show In Nav</th>
                        <th class="text-nowrap">Created Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="category in categories">
                        <td class="align-middle">{{ category.name }}</td>
                        <td class="align-middle">{{ category.description }}</td>
                        <td class="align-middle">{{ category.showInNav ? 'TRUE' : 'FALSE' }}</td>
                        <td class="align-middle text-nowrap">{{ formatDate(category.createdAt) }}</td>
                        <td class="text-center">
                            <RouterLink :to="{ name: 'categoryEdit', params: { id: category.id }}"
                                class="btn btn-primary">Edit</RouterLink>
                            <button type="button" class="mt-2 btn btn-danger"
                                @click="this.handleClickDelete(category.id)">Delete</button>
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
