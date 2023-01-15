<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("parent") }}</h2>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title">{{ $t("edit_new_parent") }}</h3>
                    <Back routeName="user-guardian" />
                </div>
                <div class="card-body border-bottom py-3">
                    <form @submit.prevent="updateGuardian" autocomplete="off">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ $t("name") }}</label>
                                    <div>
                                        <input v-model="guardianForm.name"
                                            :class="{ 'is-invalid': guardianForm.errors.has('name') }" type="text"
                                            class="form-control" :placeholder="$t('enter_name')" />
                                        <has-error :form="guardianForm" field="name"></has-error>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ $t("email") }}</label>
                                    <div>
                                        <input v-model="guardianForm.email" :class="{
                        'is-invalid': guardianForm.errors.has('email'),
                      }" type="email" class="form-control" :placeholder="$t('enter_email')" />
                                        <has-error :form="guardianForm" field="email"></has-error>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ $t("change_password") }}</label>
                                    <div>
                                        <input v-model="guardianForm.password" :class="{
                        'is-invalid': guardianForm.errors.has('password'),
                      }" type="password" class="form-control" :placeholder="$t('enter_password')" />
                                        <has-error :form="guardianForm" field="password"></has-error>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ $t("phone") }}</label>
                                    <div>
                                        <input v-model="guardianForm.phone" :class="{
                        'is-invalid': guardianForm.errors.has('phone'),
                      }" type="text" class="form-control" :placeholder="$t('enter_phone')" />
                                        <has-error :form="guardianForm" field="phone"></has-error>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ $t("gender") }}</label>
                                    <div>
                                        <label class="form-check form-check-inline">
                                            <input v-model="guardianForm.gender" class="form-check-input" type="radio"
                                                value="male" />
                                            <span class="form-check-label">{{ $t("male") }}</span>
                                        </label>
                                        <label class="form-check form-check-inline">
                                            <input v-model="guardianForm.gender" class="form-check-input" type="radio"
                                                value="female" />
                                            <span class="form-check-label">{{ $t("female") }}</span>
                                        </label>
                                    </div>
                                    <has-error :form="guardianForm" field="name"></has-error>
                                </div>
                                <div class="form-footer text-center">
                                    <base-button :loading="guardianForm.busy">{{
                    $t("save")
                  }}</base-button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            guardianForm: new Form({
                name: "",
                email: "",
                password: "",
                phone: "",
                gender: ""
            }),
            guardian: null
        };
    },
    methods: {
        async updateGuardian() {
            try {
                const response = await this.guardianForm.put(
                    `/api/guardians/${this.guardian.id}`
                );
                if (response.data.success) {
                    this.toastSuccess(response.data.message);
                }
            } catch (error) {
                this.toastError("Something went wrong while saving data");
            }
        },
        async getGuardian() {
            try {
                const guardianId = this.$route.params.id;
                const response = await axios.get(
                    `/api/guardians/${guardianId}`
                );
                this.guardian = response.data.data;
                Object.keys(this.guardianForm).forEach(k => {
                    if (this.guardian.hasOwnProperty(k)) {
                        this.guardianForm[k] = response.data.data[k];
                    }
                    if (this.guardian.user.hasOwnProperty(k)) {
                        this.guardianForm[k] = response.data.data.user[k];
                    }
                });
            } catch (error) {
                this.toastError("Something went wrong while saving data");
            }
        }
    },
    async mounted() {
        if (!this.$route.params.id) {
            this.redirect("404");
        }
        await this.hasPermisssion("parent-edit");
        this.getGuardian();
    }
};
</script>
