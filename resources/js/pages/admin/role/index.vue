<template>
    <div>
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ $t("role_list") }}</h4>
                        <div>
                            <button class="btn btn-primary btn-custom" v-if="!isShowPermission"
                                @click="isShowPermission = !isShowPermission">
                                {{ $t("show_permission") }}
                            </button>
                            <button class="btn btn-primary btn-custom" v-else @click="isShowPermission = !isShowPermission">
                                {{ $t("hide_permission") }}
                            </button>
                            <router-link v-if="checkPermission('role-create')" :to="{ name: 'role-add' }"
                                class="btn btn-primary btn-custom">
                                {{ $t("add") }}
                            </router-link>
                        </div>
                    </div>
                    <div class="card-body border-bottom py-3">
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable" v-if="!emptyData">
                                <thead class="text-center">
                                    <tr v-if="checkPermission('role-edit') || checkPermission('role-delete')">
                                        <th width="25%">{{ $t("role") }}</th>
                                        <th width="60%">{{ $t("permission") }}</th>
                                        <th width="15%">{{ $t("action") }}</th>
                                    </tr>
                                    <tr v-else>
                                        <th width="30%">{{ $t("role") }}</th>
                                        <th width="80%">{{ $t("permission") }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(role, index) in roles.data" :key="index">
                                        <td class="text-center">{{ role.name }}</td>
                                        <td class="text-center">
                                            <div class="d-flex flex-wrap" v-if="isShowPermission">
                                                <span v-for="permission in role.permissions" :key="permission.id"
                                                    class="badge bg-primary mx-1 mb-1">{{ permission.name }}</span>
                                            </div>
                                            <span v-else>({{ $t("click_the") }}
                                                <b>"{{ $t("show_permission") }}"</b>
                                                {{ $t("button_to_view_permissions") }})</span>
                                        </td>
                                        <td class="text-center">
                                            <router-link v-if="checkPermission('role-edit') && isDefaultRole(role.name)" :to="{ name: 'role-edit', params: { roleId: role.id } }" class="btn btn-primary btn-sm">
                                                <icon-edit />
                                            </router-link>
                                            <button v-if="checkPermission('role-delete') && isDefaultRole(role.name)" @click.prevent="toggleDeleteModal(role.id)" class="btn btn-danger btn-sm text-center">
                                                <icon-trash />
                                            </button>
                                            <button v-else :title="$t('you_cant_delete_default_role')"
                                                class="btn btn-danger btn-sm text-center">
                                                <icon-lock />
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div v-else class="d-flex justify-content-center py-3">
                                <NotFound word="role" route="role-add" />
                            </div>
                        </div>
                        <pagination :data="roles" @pagination-change-page="getResults" align="center" :limit="1"
                            :show-disabled="true">
                        </pagination>
                    </div>
                </div>
            </div>
        </div>
        <!-- delete modal  -->
        <DeleteModal :isShow="deleteModal" @close-modal="toggleDeleteModal" @delete-data="deleteRole" />
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import NotFound from "../../../components/NotFound.vue";
import DeleteModal from "../../../components/modal/DeleteModal.vue";

export default {
    components: {
        NotFound,
        DeleteModal
    },
    data() {
        return {
            deleteModal: false,
            selectedId: "",
            isShowPermission: false
        };
    },
    methods: {
        toggleDeleteModal(selectedId) {
            this.deleteModal = !this.deleteModal;
            this.selectedId = selectedId;
        },
        deleteModalShow(selectedId) {
            this.deleteModal = true;
            this.selectedId = selectedId;
        },
        deleteRole() {
            axios
                .delete(`/api/roles/${this.selectedId}`)
                .then(response => {
                    if (response.data.success) {
                        this.$store.dispatch("role/fetchRolesWithPermissions");
                        this.deleteModal = false;
                        this.toastSuccess(response.data.message);
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
        async getResults(page = 1) {
            await axios.get("/api/roles?page=" + page).then(response => {
                this.$store.commit("role/FETCH_ROLES", response.data.roles);
            });
            window.scroll({
                top: 60,
                left: 0,
                behavior: "smooth"
            });
        },
        isDefaultRole(role) {
            if (role != "Admin" && role != "Accountant" && role != "Teacher") {
                return true;
            }

            return false;
        }
    },
    computed: {
        ...mapGetters({
            getUserPermissions: "getUserPermissions",
            roles: "role/roles"
        }),
        emptyData() {
            let roles = this.roles && this.roles.data && this.roles.data.length;

            if (roles) {
                return false;
            } else {
                return true;
            }
        }
    },
    async mounted() {
        await this.hasPermisssion("role-list");
        this.$store.dispatch("role/fetchRolesWithPermissions");
    }
};
</script>

<style scoped>

    @media (max-width: 425px) {
        .btn-custom {
            font-size: 10px;
            padding: 5px 10px;
        }
    }

    .fade-enter-active,
    .fade-leave-active {
        transition: opacity 1s;
    }

    .fade-enter,
    .fade-leave-active {
        opacity: 0;
    }
</style>
