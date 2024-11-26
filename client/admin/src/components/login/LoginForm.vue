<script>
    import { mapState } from 'pinia'
    import { useUserStore } from '../../stores/UserStore'

    export default {
        setup() {
            const userStore = useUserStore();
            let userObject = {
                email: '',
                password: ''
            };

            return {
                userStore,
                userObject
            };
        },
        computed: {
            ...mapState(useUserStore, ['loading', 'user'])
        },
        methods: {
            onSubmitForm() {
                this.userStore.login(this.user);
            }
        },
        created() {
            this.user = Object.assign(this.user, this.userObject);
        }
    }
</script>

<template>
    <form class="row">
        <div class="col-6 offset-3">
            <div class="row mb-3">
                <label class="col-2 col-form-label">Email</label>
                <p class="col-10">
                    <input v-model="user.email" class="form-control" />
                </p>
            </div>
            <div class="row mb-3">
                <label class="col-2 col-form-label">Password</label>
                <p class="col-10">
                    <input v-model="user.password" class="form-control" type="password" />
                </p>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary" @click="onSubmitForm">Login</button>
            </div>
        </div>
    </form>
</template>