<template>
  <div>
    <form @submit.prevent="reset" class="card card-md" autocomplete="off">
      <div class="card-body">
        <h2 class="card-title text-center mb-4">{{ $t('reset_password') }}</h2>
        <!-- Email -->
        <div class="mb-3 d-none">
          <label class="form-label"> {{ $t('email_address') }}</label>
          <input
            v-model="form.email"
            type="email"
            class="form-control"
            :class="{ 'is-invalid': form.errors.has('email') }"
            :placeholder="$t('enter_email')"
            readonly
            hidden
          />
          <has-error :form="form" field="email" />
        </div>
        <!-- Password -->
        <div class="mb-3">
          <label class="form-label">{{ $t('new_password') }}</label>
          <input
            v-model="form.password"
            type="password"
            class="form-control"
            :class="{ 'is-invalid': form.errors.has('password') }"
            :placeholder="$t('enter_password')"
          />
          <has-error :form="form" field="password" />
        </div>
        <!-- Password Confirmation -->
        <div class="mb-3">
          <label class="form-label">{{ $t('confirm_password') }}</label>
          <input
            v-model="form.password_confirmation"
            type="password"
            class="form-control"
            :class="{ 'is-invalid': form.errors.has('password_confirmation') }"
            :placeholder="$t('enter_confirm_password')"
          />
          <has-error :form="form" field="password_confirmation" />
        </div>
        <div class="form-footer">
          <button v-if="form.busy" type="button" class="btn btn-primary w-100">
            <div class="input-icon d-inline-block">
              <span class="input-icon-addon">
                <div
                  class="spinner-border spinner-border-sm text-light mr-3"
                  role="status"
                ></div>
              </span>
            </div>
            {{ $t('password_reseting') }}...
          </button>
          <button v-else type="submit" class="btn btn-primary w-100">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="icon"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              stroke-width="2"
              stroke="currentColor"
              fill="none"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <rect x="3" y="5" width="18" height="14" rx="2" />
              <polyline points="3 7 12 13 21 7" />
            </svg>
            {{ $t('reset_password') }}
          </button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
    mounted() {
        this.form.email = this.$route.query.email;
        this.form.token = this.$route.params.token;
    },
    data() {
        return {
            form: new Form({
                token: "",
                email: "",
                password: "",
                password_confirmation: ""
            })
        };
    },
    methods: {
        async reset() {
            try {
                const { data } = await this.form.post("/api/password/reset");
                this.redirect("login");
                this.toastSuccess(data.message);
            } catch (err) {
                this.toastError();
            }
        }
    }
};
</script>
