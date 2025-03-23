<script>
    import { mapState } from 'pinia'
    import { ref } from 'vue'
    import { IMAGE_URL } from '@/config'
    import { formatDateMixin } from '@/mixins'
    import Pagination from '../partials/Pagination.vue'
    import { usePostStore } from '../../stores/PostStore'

    export default {
        setup() {
            const postStore = usePostStore();
            const currentPage = ref(1);
            const formFilter = ref({});

            return {
                IMAGE_URL,
                postStore,
                currentPage,
                formFilter
            };
        },
        mixins: [ formatDateMixin ],
        components: {
            Pagination
        },
        computed: {
            ...mapState(usePostStore, ['loading', 'posts', 'total', 'filterInitial']),
        },
        methods: {
            handleClickPagination(pageNumber) {
                this.currentPage = pageNumber;
                this.getPosts(this.formFilter.filter, pageNumber, this.formFilter.limit);
            },
            handleClickDelete(id) {
                if (confirm('Are you sure you want to delete?')) {
                    this.postStore.deletePost(id);
                }
            },
            handleFilter() {
                this.getPosts(this.formFilter.filter, this.formFilter.page, this.formFilter.limit);
            },
            handleClearFilter() {
                this.formFilter = JSON.parse(JSON.stringify(this.filterInitial));
                this.getPosts(this.formFilter.filter, this.formFilter.page, this.formFilter.limit);
            },
            getPosts(filter, page, limit) {
                this.postStore.getPosts(filter, page, limit);
            }
        },
        created() {
            this.formFilter = JSON.parse(JSON.stringify(this.filterInitial));
            this.getPosts(this.formFilter.filter, this.formFilter.page, this.formFilter.limit);
        },
    }
</script>

<template>
    <div class="table-posts">
        <div class="table-posts-filter">
            <form class="row">
                <div class="form-group col-7">
                    <label for="title">Title</label>
                    <input id="title" type="text" placeholder="Title" class="form-control" v-model="formFilter.filter.title" />
                </div>
                <div class="form-group col">
                    <label for="published">Published</label>
                    <select id="published" class="form-select" v-model="formFilter.filter.published">
                        <option value="">--All--</option>
                        <option value="1">True</option>
                        <option value="0">False</option>
                    </select>
                </div>
                <div class="form-group col">
                    <label for="position">Position</label>
                    <select id="position" class="form-select" v-model="formFilter.filter.position">
                        <option value="">--All--</option>
                        <option value="FEATURE">FEATURE</option>
                    </select>
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
            <RouterLink :to="{ name: 'postCreate' }" class="btn btn-primary">Create</RouterLink>
        </div>
        <div class="table-posts-inner">
            <table class="table table-striped table-bordered" id="post_list">
                <thead>
                    <tr>
                        <th>Picture</th>
                        <th>Title</th>
                        <th>Categories</th>
                        <th>Published</th>
                        <th>Position</th>
                        <th class="text-nowrap">Created By</th>
                        <th>Created Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="post in posts">
                        <td>
                            <img v-if="post.picture" :src="(post.picture.indexOf('http') === 0 ? '' : IMAGE_URL) + post.picture" class="w-100 post-picture" />
                        </td>
                        <td>{{ post.title }}</td>
                        <td class="align-middle">
                            <ul v-for="category in post.categories" class="list-group">
                                <li class="list-group-item mb-1">{{ category.name }}</li>
                            </ul>
                        </td>
                        <td class="align-middle">{{ post.published ? 'TRUE' : 'FALSE' }}</td>
                        <td class="align-middle">{{ post.position }}</td>
                        <td class="align-middle"><span v-if="post.user" class="text-nowrap">{{ post.user.name }}</span></td>
                        <td class="align-middle text-nowrap">{{ formatDate(post.createdAt) }}</td>
                        <td class="text-center">
                            <RouterLink :to="{ name: 'postEdit', params: { id: post.id }}" class="btn btn-primary">Edit</RouterLink>
                            <button type="button" class="mt-2 btn btn-danger"
                                @click="this.handleClickDelete(post.id)">Delete</button>
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
