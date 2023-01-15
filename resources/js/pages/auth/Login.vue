<template>
    <div>
        <form class="card card-md" @submit.prevent="userLogin" autocomplete="off">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">{{ $t('login_to_your_account') }}</h2>
                <div class="mb-3">
                    <label class="form-label">{{ $t('email_address') }}</label>
                    <input type="email" class="form-control" :placeholder="$t('enter_email')"
                        v-model="loginUserForm.email" :class="{ 'is-invalid': loginUserForm.errors.has('email') }" />
                    <has-error :form="loginUserForm" field="email"></has-error>
                </div>
                <div class="mb-2">
                    <label class="form-label">
                        {{ $t('password') }}
                        <span class="form-label-description">
                            <router-link :to="{ name: 'password.request' }">{{ $t('i_forgot_password') }}</router-link>
                        </span>
                    </label>
                    <div class="input-group input-group-flat">
                        <input :type="visibility ? 'text' : 'password'" class="form-control"
                            :placeholder="$t('password')" autocomplete="off" v-model="loginUserForm.password"
                            :class="{ 'is-invalid': loginUserForm.errors.has('password') }" />
                        <span class="input-group-text">
                            <a @click.prevent="visibility = !visibility" href="javascript:void(0)"
                                class="link-secondary" :title="$t('show_password')" data-bs-toggle="tooltip">
                                <icon-eye-on v-if="visibility" />
                                <icon-eye-off v-else />
                            </a>
                        </span>
                        <has-error :form="loginUserForm" field="password"></has-error>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="form-check">
                        <input type="checkbox" class="form-check-input" v-model="loginUserForm.remember_me" />
                        <span class="form-check-label">{{ $t('remember_me_on_this_device') }}</span>
                    </label>
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100" v-if="loginUserForm.busy">
                        <div class="input-icon d-inline-block">
                            <span class="input-icon-addon">
                                <div class="spinner-border spinner-border-sm text-light mr-3" role="status"></div>
                            </span>
                        </div>
                        {{ $t('signing_in') }}...
                    </button>
                    <button v-else type="submit" :disabled="loginButtonDisabled" class="btn btn-primary w-100">
                        {{ $t('sign_in') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
    data() {
        return {
            loginUserForm: new Form({
                email: "",
                password: "",
                remember_me: ""
            }),
            visibility: false
        };
    },
    computed: {
        loginButtonDisabled() {
            return (
                this.loginUserForm.email === "" ||
                this.loginUserForm.password === ""
            );
        }
    },
    methods: {
        ...mapActions({
            authUser: "auth/authUser",
            login: "auth/login"
        }),
        userLogin() {
            this.login(this.loginUserForm);
        },
        adminLogin() {
            this.loginUserForm.email = "admin@mail.com";
            this.loginUserForm.password = "password";
            this.userLogin();
        }
    }
};
</script>
