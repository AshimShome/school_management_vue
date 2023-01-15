<template>
    <div>
        <div class="row row-deck row-cards justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ $t('add_role') }}</h4>
                        <router-link :to="{ name: 'role' }" class="btn btn-primary">{{ $t('back') }}</router-link>
                    </div>
                    <div class="card-body border-bottom py-3">
                        <form @submit.prevent="roleSave" autocomplete="off">
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="form-group mb-3 ">
                                        <label class="form-label">{{ $t('role') }}</label>
                                        <div>
                                            <input v-model="roleForm.name"
                                                :class="{ 'is-invalid': roleForm.errors.has('name') }" type="text"
                                                class="form-control" :placeholder="$t('role')" autocomplete="off">
                                            <has-error :form="roleForm" field="name"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 ">
                                        <button :disabled="roleForm.busy" type="submit"
                                            class="btn btn-primary">{{ $t('add')+' '+$t('role') }}</button>
                                    </div>
                                </div>
                                <div class="col-xl-8">
                                    <div class="form-group">
                                        <label class="form-label">{{ $t('permission') }}</label>
                                        <br />
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="d-inline-block">
                                                    <div>
                                                        <label class="form-check">
                                                            <input @change="checkAllPermission($event)"
                                                                class="form-check-input" type="checkbox">
                                                            <span
                                                                class="form-check-label">{{ $t('all_permission') }}</span>
                                                            <has-error class="d-block" :form="roleForm"
                                                                field="permission"></has-error>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-md-3" v-for="(permission,index) in permissions" :key="index">
                                                <div class="d-inline-block mt-1 m-3">
                                                    <div>
                                                        <label class="form-check">
                                                            <input v-model="roleForm.permission"
                                                                class="form-check-input" type="checkbox"
                                                                :value="permission.id">
                                                            <span class="form-check-label">{{ permission.name }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    created() {
        let hasPermission = this.$store.getters[
            "rolepermission/userHasPermission"
        ]("role-create");

        if (!hasPermission) {
            this.redirect("401");
        }
    },
    data() {
        return {
            roleForm: new Form({
                name: "",
                permission: []
            })
        };
    },
    methods: {
        roleSave() {
            this.roleForm
                .post("/api/roles")
                .then(response => {
                    if (response.data.success) {
                        this.roleForm.reset();

                        // update the permissions
                        this.$store.dispatch(
                            "rolepermission/loadUserPermissions"
                        );

                        this.toastSuccess(response.data.message);
                    } else {
                        console.log(123);
                    }
                })
                .catch(error => {
                    this.toastError();
                });
        },
        checkAllPermission(event) {
            if (event.target.checked) {
                this.roleForm.permission = [];

                for (var permission in this.permissions) {
                    this.roleForm.permission.push(
                        this.permissions[permission].id.toString()
                    );
                }
            } else {
                this.roleForm.permission = [];
            }
        }
    },
    computed: {
        permissions() {
            return this.$store.getters["permission/permissions"];
        }
    },
    async mounted() {
        await this.hasPermisssion("role-create");
        this.$store.dispatch("permission/fetchPermissions");
    }
};
</script>
