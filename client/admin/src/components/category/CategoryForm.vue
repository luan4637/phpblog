<script>
    import { mapState } from 'pinia'
    import { useCategoryStore } from '../../stores/CategoryStore'

    export default {
        setup() {
            const categoryStore = useCategoryStore();

            return {
                categoryStore,
            };
        },
        computed: {
            ...mapState(useCategoryStore, ['loading', 'category'])
        },
        methods: {
            initCategory() {
                this.categoryStore.initCategory();
            },
            getCategory(id) {
                this.categoryStore.getCategory(id);
            },
            onSubmitForm() {
                this.categoryStore.submitCategory(this.category);
            }
        },
        created() {
            if (this.$route.params.id) {
                this.getCategory(this.$route.params.id);
            } else {
                this.initCategory();
            }
        }
    }
</script>

<template>
    <form>
        <div class="row mb-3">
            <label class="col-2 col-form-label">Category name</label>
            <p class="col-10">
                <input v-model="category.name" class="form-control" />
            </p>
        </div>
        <div class="row mb-3">
            <label class="col-2 col-form-label">Description</label>
            <p class="col-10">
                <textarea v-model="category.description" class="form-control"></textarea>
            </p>
        </div>
        <div class="row mb-3">
            <label class="col-2 col-form-label">Show In Nav</label>
            <p class="col-10">
                <input type="checkbox" v-model="category.showInNav" />
            </p>
        </div>
        <div class="btn-group">
            <RouterLink :to="{ name: 'category'}" class="btn btn-secondary">Back</RouterLink>
            <button type="button" class="btn btn-primary pull-right" @click="onSubmitForm">Save</button>
        </div>
    </form>
</template>