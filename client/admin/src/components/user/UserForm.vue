<script>
    import { mapState } from 'pinia'
    import { useUserStore } from '../../stores/UserStore'

    export default {
        setup() {
            const userStore = useUserStore();

            return {
                userStore,
            };
        },
        computed: {
            ...mapState(useUserStore, ['loading', 'user'])
        },
        methods: {
            initUser() {
                this.userStore.initUser();
            },
            getUser(id) {
                this.userStore.getUser(id);
            },
            onSubmitForm() {
                this.userStore.submitUser(this.user);
            }
        },
        created() {
            if (this.$route.params.id) {
                this.getUser(this.$route.params.id);
            } else {
                this.initUser();
            }
        }
    }
</script>

<template>
    <form>
        <div class="row mb-3">
            <label class="col-2 col-form-label">Full name</label>
            <p class="col-10">
                <input v-model="user.name" class="form-control" />
            </p>
        </div>
        <div class="row mb-3">
            <label class="col-2 col-form-label">Email</label>
            <p class="col-10">
                <input v-model="user.email" class="form-control" />
            </p>
        </div>
        <div class="row mb-3">
            <label class="col-2 col-form-label">Password</label>
            <p class="col-10">
                <input v-model="user.password" class="form-control" />
            </p>
        </div>
        <div class="row mb-3">
            <label class="col-2 col-form-label">Roles</label>
            <p class="col-10">
                <select v-model="user.roles" class="form-select" multiple>
                    <option value="ROLE_USER">ROLE_USER</option>
                    <option value="ROLE_ADMIN">ROLE_ADMIN</option>
                </select>
            </p>
        </div>
        <div class="btn-group">
            <RouterLink :to="{ name: 'user'}" class="btn btn-secondary">Back</RouterLink>
            <button type="button" class="btn btn-primary pull-right" @click="onSubmitForm">Save</button>
        </div>
    </form>
</template>