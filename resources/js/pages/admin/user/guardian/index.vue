<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("admin_setting") }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none" v-if="checkPermission('parent-create')">
                    <div class="d-flex">
                        <input type="search" class="form-control d-inline-block w-9 me-3"
                            :placeholder="$t('search_here…')" @keyup="searchGuardians" v-model="search" />
                        <router-link :to="{ name: 'user-guardian-add' }" class="btn btn-primary btn-outline">
                            <icon-plus />
                            {{ $t("create") }}
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cards mt-2" v-if="this.guardians.total !== 0">
            <template v-if="guardians && guardians.length">
                <div class="col-md-6 col-xl-3" v-for="(guardian, index) in guardians" :key="index">
                    <div class="card user-card" v-if="guardian.user">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <img :src="guardian.user.image_url" alt="image" class="avatar avatar-lg avatar-rounded rounded"/>
                            </div>
                            <div class="card-title mb-1">
                                {{ guardian.user.name }}
                            </div>
                        </div>
                        <div class="d-flex">
                            <router-link :to="{
                  name: 'user-guardian-edit',
                  params: { id: guardian.id },
                }" class="card-btn d-inline-block" v-if="checkPermission('parent-edit')">
                                <icon-edit />
                            </router-link>
                            <router-link :to="{
                  name: 'user-guardian-view',
                  params: { id: guardian.id },
                }" class="card-btn">
                                <icon-eye />
                            </router-link>
                            <a href="javascript:void(0)" @click="deleteConfirmation(guardian.id)"
                                class="card-btn d-inline-block" v-if="checkPermission('parent-delete')">
                                <icon-trash /></a>
                        </div>
                    </div>
                </div>
            </template>
            <div v-else class="d-flex justify-content-center py-3">
                <NotFound word="parent" />
            </div>
            <div class="mt-5">
                <div class="d-flex justify-content-center mt-4">
                    <pagination :data="pagination" @pagination-change-page="fetchGuardians" align="center" :limit="1">
                    </pagination>
                </div>
            </div>
        </div>
        <div v-else class="d-flex justify-content-center py-3">
            <NotFound word="guardians" route="user-guardian-add" />
        </div>
        <!-- delete modal  -->
        <DeleteModal :isShow="isModalShow" @close-modal="isModalShow = false" @delete-data="deleteUser" />
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import NotFound from "../../../../components/NotFound.vue";
import DeleteModal from "../../../../components/modal/DeleteModal.vue";

export default {
    components: {
        NotFound,
        DeleteModal
    },
    data() {
        return {
            search: "",
            selectedId: "",
            isModalShow: false
        };
    },
    computed: {
        ...mapGetters({
            guardians: "parent/guardians",
            pagination: "parent/pagination"
        })
    },
    async mounted() {
        await this.hasPermisssion("parent-list");
        this.fetchGuardians();
    },
    methods: {
        deleteConfirmation(id) {
            this.isModalShow = !this.isModalShow;
            this.selectedId = id;
        },
        async deleteUser() {
            let response = await axios.delete(
                `/api/guardians/${this.selectedId}`
            );
            this.isModalShow = false;
            this.$store.commit("parent/REMOVE_GUARDIAN", this.selectedId);
            this.toastSuccess(response.data.message);
        },
        searchGuardians() {
            this.fetchGuardians();
        },
        fetchGuardians(page = 1) {
            this.$store.dispatch("parent/fetchGuardians", {
                page: page,
                search: this.search
            });
        }
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
