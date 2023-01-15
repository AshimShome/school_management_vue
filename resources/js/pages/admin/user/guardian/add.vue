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
                    <h3 class="card-title">{{ $t("create_new_parent") }}</h3>
                    <Back routeName="user-guardian" />
                </div>
                <div class="card-body border-bottom py-3">
                    <form @submit.prevent="addGuardian" autocomplete="off">
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
                                    <label class="form-label">{{ $t("password") }}</label>
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
                      }" type="number" class="form-control" :placeholder="$t('enter_phone')" />
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
import BaseButton from "../../../../components/global/form/button/BaseButton.vue";
import BaseTextarea from "../../../../components/global/form/input/BaseTextarea.vue";
export default {
    components: {
        BaseTextarea,
        BaseButton
    },
    data() {
        return {
            guardianForm: new Form({
                name: "",
                email: "",
                password: "",
                phone: "",
                gender: "male"
            })
        };
    },
    methods: {
        async addGuardian() {
            try {
                const response = await this.guardianForm.post("/api/guardians");
                this.guardianForm.reset();
                this.toastSuccess(response.data.message);
                this.$router.go(-1)
            } catch (error) {
                this.toastError("Something went wrong while saving data");
            }
        },
        async dataExistsChecking() {
            let response = await axios.get(`/api/sessions/year`);

            if (
                response.data.sessions.length == null ||
                !response.data.selectedSession.default_session_id
            ) {
                this.redirect("academic-session");
                this.toastWarning(
                    "Please create and set default session first"
                );
            }
        }
    },
    async mounted() {
        await this.hasPermisssion("parent-create");
        await this.dataExistsChecking();
    }
};
</script>
