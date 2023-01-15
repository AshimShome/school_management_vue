<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("users") }}</h2>
                </div>
            </div>
        </div>
        <div class="row row-deck row-cards justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="card-title">{{ $t("add_user") }}</h3>
                        <Back routeName="user" />
                    </div>
                    <div class="card-body border-bottom py-3">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <form @submit.prevent="userSave" autocomplete="off">
                                    <div class="form-group mb-3">
                                        <label class="form-label">{{ $t("name") }}</label>
                                        <div>
                                            <input v-model="userForm.name"
                                                :class="{ 'is-invalid': userForm.errors.has('name') }" type="text"
                                                class="form-control" :placeholder="$t('name')" />
                                            <has-error :form="userForm" field="name"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">{{ $t("email") }}</label>
                                        <div>
                                            <input v-model="userForm.email"
                                                :class="{ 'is-invalid': userForm.errors.has('email') }" type="email"
                                                class="form-control" :placeholder="$t('email')" />
                                            <has-error :form="userForm" field="email"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">{{ $t("password") }}</label>
                                        <div>
                                            <input v-model="userForm.password" :class="{
                          'is-invalid': userForm.errors.has('password'),
                        }" type="password" class="form-control" :placeholder="$t('password')" />
                                            <has-error :form="userForm" field="password"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">{{ $t("role") }}</label>
                                        <select class="form-control" v-model="userForm.role">
                                            <option value="" class="d-none">{{ $t('select_role') }}</option>
                                            <option :value="role.id" v-for="role in roles" :key="role.id">
                                                {{ role.name }}
                                            </option>
                                        </select>
                                        <has-error :form="userForm" field="role"></has-error>
                                    </div>
                                    <div class="form-footer text-center">
                                        <base-button :loading="userForm.busy">{{
                        $t("save")
                    }}</base-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            userForm: new Form({
                name: "",
                email: "",
                password: "",
                role: ""
            }),

            roles: []
        };
    },
    methods: {
        async userSave() {
            try {
                let response = await this.userForm.post("/api/users");
                this.userForm.reset();
                this.toastSuccess(response.data.message);
            } catch (e) {
                this.toastError(e.response.data.message);
                this.userForm.errors.record(e);
            }
        },
        async dataExistsChecking() {
            if (!this.roles.length) {
                this.toastWarning("Please create role first");
                this.redirect("role-add");
            }
        }
    },
    computed: {
        allRoles() {
            return this.$store.getters["role/rolesList"];
        }
    },
    async mounted() {
        await this.hasPermisssion("user-create");
        await this.$store.dispatch("role/fetchRoles");

        setTimeout(() => {
            let filteredRoles = this.allRoles.filter(role => {
                return (
                    role.name !== "Student" &&
                    role.name !== "Teacher" &&
                    role.name !== "Guardian" &&
                    role.name !== "Accountant"
                );
            });

            this.roles = filteredRoles;
            this.dataExistsChecking();
        }, 500);
    }
};
</script>
