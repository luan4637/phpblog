<script>
    import { mapState } from 'pinia'
    import { ref } from 'vue'
    import Pagination from '../partials/Pagination.vue'
    import { useUserStore } from '../../stores/UserStore'
    import { formatDateMixin } from '@/mixins'

    export default {
        setup() {
            const userStore = useUserStore();
            const currentPage = ref(1);
            const formFilter = ref({});

            return {
                userStore,
                currentPage,
                formFilter
            };
        },
        mixins: [ formatDateMixin ],
        components: {
            Pagination
        },
        computed: {
            ...mapState(useUserStore, ['loading', 'users', 'total', 'filterInitial']),
        },
        methods: {
            handleClickPagination(pageNumber) {
                this.currentPage = pageNumber;
                this.getUsers(this.formFilter.filter, pageNumber, this.formFilter.limit);
            },
            handleFilter() {
                this.getUsers(this.formFilter.filter, this.formFilter.page, this.formFilter.limit);
            },
            handleClearFilter() {
                this.formFilter = JSON.parse(JSON.stringify(this.filterInitial));
                this.getUsers(this.formFilter.filter, this.formFilter.page, this.formFilter.limit);
            },
            getUsers(filter, page, limit) {
                this.userStore.getUsers(filter, page, limit);
            }
        },
        created() {
            this.formFilter = JSON.parse(JSON.stringify(this.filterInitial));
            this.getUsers(this.formFilter.filter, this.formFilter.page, this.formFilter.limit);
        },
    }
</script>

<template>
    <div class="table-users">
        <div class="table-users-filter">
            <form class="row" autocomplete="off">
                <div class="form-group col-3">
                    <label for="name">Name</label>
                    <input id="name" type="text" placeholder="Name" class="form-control" v-model="formFilter.filter.name" />
                </div>
                <div class="form-group col-4">
                    <label for="email">Email</label>
                    <input id="email" type="text" placeholder="Email" class="form-control" v-model="formFilter.filter.email" />
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
            <RouterLink :to="{ name: 'userCreate' }" class="btn btn-primary">Create</RouterLink>
        </div>
        <div class="table-users-inner">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="text-nowrap">Name</th>
                        <th class="text-nowrap">Email</th>
                        <th class="text-nowrap" style="width: 10em;">Roles</th>
                        <th class="text-nowrap" style="width: 10em;">Created Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users">
                        <td class="align-middle">{{ user.name }}</td>
                        <td class="align-middle">{{ user.email }}</td>
                        <td class="align-middle">
                            <ul v-for="role in user.roles" class="list-group">
                                <li class="list-group-item mb-1">{{ role }}</li>
                            </ul>
                        </td>
                        <td class="align-middle">{{ formatDate(user.created_at) }}</td>
                        <td class="text-center">
                            <RouterLink :to="{ name: 'userEdit', params: { id: user.id }}" class="btn btn-primary">Edit</RouterLink>
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
