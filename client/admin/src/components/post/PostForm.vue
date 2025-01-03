<script>
    import { mapState } from 'pinia'
    import { ref } from 'vue'
    import { IMAGE_URL } from '@/config'
    import { usePostStore } from '../../stores/PostStore'
    import { useCategoryStore } from '../../stores/CategoryStore'

    export default {
        setup() {
            const postStore = usePostStore();
            const categoryStore = useCategoryStore();
            const uploadPicture = ref(null);

            return {
                IMAGE_URL,
                postStore,
                categoryStore,
                uploadPicture
            };
        },
        computed: {
            ...mapState(usePostStore, ['loading', 'post']),
            ...mapState(useCategoryStore, ['categories']),
        },
        methods: {
            initPost() {
                this.postStore.initPost();
            },
            getPost(id) {
                this.postStore.getPost(id);
            },
            onSubmitForm() {
                this.postStore.submitPost(this.post, this.uploadPicture);
            },
            onFileChange(e) {
                const file = e.target.files[0];
                this.uploadPicture = file;
                this.post.picture = URL.createObjectURL(file);
            }
        },
        created() {
            if (this.$route.params.id) {
                this.getPost(this.$route.params.id);
            } else {
                this.initPost();
            }
            this.categoryStore.getCategories({}, 1, Number.MAX_SAFE_INTEGER);
        }
    }
</script>

<template>
    <form>
        <div class="row mb-3">
            <label class="col-2 col-form-label">Title</label>
            <p class="col-10">
                <input v-model="post.title" class="form-control" />
            </p>
        </div>
        <div class="row mb-3">
            <label class="col-2 col-form-label">Image</label>
            <p class="col-10">
                <input type="file" accept="image/*" @change="onFileChange" />
                <div id="preview" class="mt-2">
                    <img v-if="post.picture"
                        class="w-25"
                        :src="(post.picture.indexOf('blob:') > -1 || post.picture.indexOf('http') === 0 ? '' : IMAGE_URL) + post.picture" />
                </div>
            </p>
        </div>
        <div class="row mb-3">
            <label class="col-2 col-form-label">Content</label>
            <p class="col-10">
                <textarea v-model="post.content" class="form-control" style="height: 10em"></textarea>
            </p>
        </div>
        <div class="row mb-3">
            <label class="col-2 col-form-label">Position</label>
            <p class="col-10">
                <select v-model="post.position" class="form-select">
                    <option value="">NONE</option>
                    <option value="FEATURE">FEATURE</option>
                    <option value="POPULAR">POPULAR</option>
                </select>
            </p>
        </div>
        <div class="row mb-3">
            <label class="col-2 col-form-label">Category</label>
            <p class="col-10">
                <select v-model="post.categories" class="form-select" multiple style="height: 15em">
                    <option value="">--Choose Category--</option>
                    <option
                        v-for="category in categories"
                        :value="category"
                    >{{ category.name }}</option>
                </select>
            </p>
        </div>
        <div class="row mb-3">
            <label class="col-2 col-form-label">Published</label>
            <p class="col-10">
                <input type="checkbox" v-model="post.published" :checked="post.published == 1" />
            </p>
        </div>
        <div class="row mb-3">
            <label class="col-2 col-form-label">Created by</label>
            <p class="col-10">
                <span v-if="post.user">{{ post.user.name }}</span>
            </p>
        </div>
        <div class="btn-group">
            <RouterLink :to="{ name: 'home'}" class="btn btn-secondary">Back</RouterLink>
            <button type="button" class="btn btn-primary pull-right" @click="onSubmitForm">Save</button>
        </div>
    </form>
</template>