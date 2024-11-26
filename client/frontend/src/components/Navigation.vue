<script>
    import { mapState } from 'pinia'
    import { RouterLink } from 'vue-router'
    import { useCategoryStore } from '../stores/CategoryStore'

    export default {
        setup() {
            const categoryStore = useCategoryStore();

            return {
                categoryStore
            };
        },
        computed: {
            ...mapState(useCategoryStore, ['loading', 'categories']),
        },
        methods: {
            getCategories(page, limit) {
                this.categoryStore.getCategories(page, limit);
            }
        },
        created() {
            this.getCategories();
        },
    }
</script>

<template>
    <div class="navigation">
        <ul>
            <li v-for="category in categories">
                <RouterLink
                    :to="{ name: 'postsByCategory', params: { category: category.slug }}"
                >{{ category.name }}</RouterLink>
            </li>
        </ul>
    </div>
</template>
