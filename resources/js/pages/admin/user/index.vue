<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("admin_setting") }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none" v-if="checkPermission('user-create')">
                    <div class="d-flex">
                        <router-link :to="{ name: 'user-add' }" class="btn btn-primary">
                            <icon-plus />
                            {{ $t("create") }}
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cards mt-2">
            <template v-if="users.data && users.data.length">
                <div class="col-md-6 col-xl-3" v-for="(user, index) in users.data" :key="index">
                    <div class="card user-card">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <img :src="user.image_url" alt="image" class="avatar avatar-lg avatar-rounded rounded"/>
                            </div>
                            <div class="card-title mb-1">
                                {{ user.name }}
                            </div>
                        </div>
                        <div class="d-flex">
                            <router-link :to="{ name: 'user-edit', params: { userId: user.id } }"
                                class="card-btn d-inline-block" v-if="checkPermission('user-edit')">
                                <icon-edit />
                            </router-link>
                            <router-link :to="{ name: 'user-view', params: { id: user.id } }" href="#" class="card-btn">
                                <icon-eye />
                            </router-link>
                            <a href="javascript:void(0)" @click="deleteConfirmation(user.id)"
                                class="card-btn d-inline-block" v-if="checkPermission('user-delete')">
                                <icon-trash /></a>
                        </div>
                    </div>
                </div>
            </template>
            <div v-else class="d-flex justify-content-center py-3">
                <NotFound word="user" />
            </div>
            <div class="mt-5">
                <pagination :data="users" @pagination-change-page="getResults" align="center" :limit="1"
                    :show-disabled="true"></pagination>
            </div>
        </div>

        <!-- delete modal  -->
        <DeleteModal :isShow="isModalShow" @close-modal="isModalShow = false" @delete-data="deleteUser" />
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
            selectedId: "",
            showMenu: false,
            isModalShow: false
        };
    },
    methods: {
        deleteConfirmation(id) {
            this.isModalShow = !this.isModalShow;
            this.selectedId = id;
        },
        async deleteUser() {
            let response = await axios.delete(`/api/users/${this.selectedId}`);
            this.isModalShow = false;
            this.$store.dispatch("user/fetchUsers");
            this.toastSuccess(response.data.message);
        },
        async getResults(page = 1) {
            await axios.get("/api/users?page=" + page).then(response => {
                this.$store.commit("user/FETCH_USERS", response.data.users);
            });

            window.scroll({
                top: 60,
                left: 0,
                behavior: "smooth"
            });
        }
    },
    computed: {
        ...mapGetters({
            userPermissions: "getUserPermissions",
            users: "user/users"
        }),
        emptyData() {
            let users = this.users && this.users.data && this.users.data.length;

            if (users) {
                return false;
            } else {
                return true;
            }
        }
    },
    async created() {
        await this.hasPermisssion("user-list");
        await this.$store.dispatch("user/fetchUsers");
    }
};
</script>


<style>
    .user-card {
        position: relative;
    }

    .dots {
        position: absolute;
        top: 5px;
        right: 10px;
    }
</style>
