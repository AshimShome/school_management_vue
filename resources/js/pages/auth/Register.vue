<template>
    <div>
        <form class="card card-md" @submit.prevent="userRegistration" autocomplete="off">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">{{ $t('create_new_account') }}</h2>
                <div class="mb-3">
                    <label class="form-label">{{ $t('name') }}</label>
                    <input type="text" class="form-control" :placeholder="$t('enter_name')"
                        v-model="registerUserForm.name"
                        :class="{ 'is-invalid': registerUserForm.errors.has('name') }" />
                    <has-error :form="registerUserForm" field="name"></has-error>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ $t('email_address') }}</label>
                    <input type="email" class="form-control" :placeholder="$t('enter_email')"
                        v-model="registerUserForm.email"
                        :class="{ 'is-invalid': registerUserForm.errors.has('email') }" />
                    <has-error :form="registerUserForm" field="email"></has-error>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ $t('password') }}</label>
                    <div class="input-group input-group-flat">
                        <input :type="visibility ? 'text' : 'password'" class="form-control"
                            :placeholder="$t('password')" autocomplete="off" v-model="registerUserForm.password"
                            :class="{ 'is-invalid': registerUserForm.errors.has('password') }" />
                        <span class="input-group-text">
                            <a @click.prevent="visibility = !visibility" href="javascript:void(0)"
                                class="link-secondary" :title="$t('show_password')" data-bs-toggle="tooltip">
                                <svg v-if="visibility" xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <circle cx="12" cy="12" r="2" />
                                    <path
                                        d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-eye-off" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <line x1="3" y1="3" x2="21" y2="21"></line>
                                    <path d="M10.584 10.587a2 2 0 0 0 2.828 2.83"></path>
                                    <path
                                        d="M9.363 5.365a9.466 9.466 0 0 1 2.637 -.365c4 0 7.333 2.333 10 7c-.778 1.361 -1.612 2.524 -2.503 3.488m-2.14 1.861c-1.631 1.1 -3.415 1.651 -5.357 1.651c-4 0 -7.333 -2.333 -10 -7c1.369 -2.395 2.913 -4.175 4.632 -5.341">
                                    </path>
                                </svg>
                            </a>
                        </span>
                        <has-error :form="registerUserForm" field="password"></has-error>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-check">
                        <input type="checkbox" class="form-check-input" />
                        <span class="form-check-label">
                            {{ $t('agree_the') }}
                            <a href="./terms-of-service.html" tabindex="-1">
                                {{ $t('terms_and_policy') }} </a>.
                        </span>
                    </label>
                </div>
                <div class="form-footer">
                    <button type="submit" :disabled="registerUserForm.busy" class="btn btn-primary w-100">
                        {{ $t('create_new_account') }}
                    </button>
                </div>
            </div>
        </form>
        <div class="text-center text-muted mt-3">
            {{ $t('already_have_account') }}?
            <router-link :to="{ name: 'login' }"> {{ $t('login') }} </router-link>
        </div>
    </div>
</template>

<script>
import Vue from "vue";
import { Form, HasError, AlertError } from "vform";

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

export default {
    data() {
        return {
            registerUserForm: new Form({
                name: "",
                email: "",
                password: "",
                password_confirmation: ""
            }),
            visibility: false
        };
    },
    methods: {
        userRegistration() {
            this.registerUserForm.password_confirmation = this.registerUserForm.password;
            // Submit the form via a POST request
            axios.get("/sanctum/csrf-cookie").then(response => {
                // Register...
                this.registerUserForm.post("/register").then(({ data }) => {
                    // Login using this account.
                    this.redirect("home");
                    // axios.post('/login', {
                    //     email: this.registerUserForm.email,
                    //     password: this.registerUserForm.password,
                    // }).then(response => {
                    // });
                });
            });
        }
    },
    mounted() {}
};
</script>

<style>
</style>
