<template>
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">{{ $t("change_password") }}</h3>
        </div>
        <div class="card-body">
            <form @submit.prevent="passwordUpdate">
                <div class="form-group mb-3 row">
                    <label class="form-label col-3 col-form-label">{{
            $t("current_password")
          }}</label>
                    <div class="col">
                        <input v-model="passwordForm.oldPassword" type="password"
                            :class="{ 'is-invalid': passwordForm.errors.has('oldPassword') }" class="form-control"
                            :placeholder="$t('current_password')" />
                        <has-error :form="passwordForm" field="oldPassword"></has-error>
                    </div>
                </div>
                <div class="form-group mb-3 row">
                    <label class="form-label col-3 col-form-label">{{
            $t("new_password")
          }}</label>
                    <div class="col">
                        <input v-model="passwordForm.newPassword" type="password"
                            :class="{ 'is-invalid': passwordForm.errors.has('newPassword') }" class="form-control"
                            :placeholder="$t('new_password')" />
                        <has-error :form="passwordForm" field="newPassword"></has-error>
                    </div>
                </div>
                <div class="form-footer">
                    <button :disabled="passwordForm.busy" type="submit" class="btn btn-primary">
                        {{ $t("update_password") }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            passwordForm: new Form({
                oldPassword: "",
                newPassword: ""
            })
        };
    },
    methods: {
        passwordUpdate() {
            this.passwordForm
                .put(`/api/user/password/update/${this.user.id}`)
                .then(response => {
                    let responseType = response.data.success;

                    if (responseType) {
                        this.passwordForm.reset();
                        this.$store.dispatch("auth/authUser");
                        this.toastSuccess(response.data.message);
                    } else {
                        this.toastError(response.data.message);
                    }
                });
        }
    },
    computed: {
        user() {
            return this.$store.getters["auth/user"];
        }
    }
};
</script>
