<template>
    <div>
        <form @submit.prevent="resetPassword" class="card card-md" autocomplete="off">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">{{ $t('reset_password') }}</h2>
                <p class="text-muted mb-4">
                    {{ $t('enter_your_registered_email_address_will_be_reset_and_emailed_to_you') }}.
                </p>
                <div class="mb-3">
                    <label class="form-label"> {{ $t('email') }} </label>
                    <input v-model="resetForm.email" type="email" class="form-control"
                        :class="{ 'is-invalid': resetForm.errors.has('email') }" :placeholder="$t('enter_email')" />
                    <has-error :form="resetForm" field="email" />
                </div>
                <div class="form-footer">
                    <button v-if="resetForm.busy" type="button" class="btn btn-primary w-100">
                        <div class="input-icon d-inline-block">
                            <span class="input-icon-addon">
                                <div class="spinner-border spinner-border-sm text-light mr-3" role="status"></div>
                            </span>
                        </div>
                        {{ $t('sending_link') }}...
                    </button>
                    <button v-else type="submit" class="btn btn-primary w-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <rect x="3" y="5" width="18" height="14" rx="2" />
                            <polyline points="3 7 12 13 21 7" />
                        </svg>
                        {{ $t('send_me_password_reset_link') }}
                    </button>
                </div>
            </div>
        </form>
        <div class="text-center text-muted mt-3">
            {{ $t('forget_it') }},
            <router-link :to="{ name: 'login' }">{{ $t('send_me_back') }}</router-link> {{ $t('to_the_login_screen') }}.
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            resetForm: new Form({
                email: ""
            })
        };
    },
    methods: {
        async resetPassword() {
            try {
                let response = await this.resetForm.post("/api/password/email");
                this.resetForm.reset();
                this.toastSuccess(response.data.status);
            } catch (err) {
                // error message
                if (err.data.email) {
                    this.toastError("Something went wrong while saving data");
                }
            }
        }
    }
};
</script>
