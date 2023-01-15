<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("accountant") }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none" v-if="checkPermission('accountant-create')">
                    <div class="d-flex">
                        <input type="search" class="form-control d-inline-block w-9 me-3"
                            :placeholder="$t('search_here…')" @keyup="searchTeachers" v-model="search" />
                        <router-link :to="{ name: 'user-accountant-add' }" class="btn btn-primary btn-outline">
                            <icon-plus />
                            {{ $t("create") }}
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cards mt-2" v-if="!emptyData">
            <template v-if="accountants && accountants.length">
                <div class="col-md-6 col-xl-3" v-for="(accountant, index) in accountants" :key="index">
                    <div class="card user-card" v-if="accountant.user">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <img :src="accountant.user.image_url" alt="image"
                                    class="avatar avatar-lg avatar-rounded rounded"/>
                            </div>
                            <div class="card-title mb-1">
                                {{ accountant.user.name }}
                            </div>
                        </div>
                        <div class="d-flex">
                            <router-link :to="{
                  name: 'user-accountant-edit',
                  params: { id: accountant.id },
                }" class="card-btn d-inline-block" v-if="checkPermission('accountant-edit')">
                                <icon-edit />
                            </router-link>
                            <router-link :to="{
                  name: 'user-accountant-view',
                  params: { id: accountant.id },
                }" class="card-btn d-inline-block">
                                <icon-eye />
                            </router-link>
                            <a href="javascript:void(0)" @click="deleteConfirmation(accountant.id)"
                                class="card-btn d-inline-block" v-if="checkPermission('accountant-delete')">
                                <icon-trash /></a>
                        </div>
                    </div>
                </div>
            </template>
            <div v-else class="d-flex justify-content-center py-3">
                <NotFound word="accountant" />
            </div>
            <div class="mt-5">
                <div class="d-flex justify-content-center mt-4">
                    <pagination :data="pagination" @pagination-change-page="fetchAccountant"></pagination>
                </div>
            </div>
        </div>
        <div v-else class="d-flex justify-content-center py-3">
            <NotFound word="teachers" route="user-teacher-add" />
        </div>

        <!-- delete modal  -->
        <DeleteModal :isShow="isModalShow" @close-modal="isModalShow = false" @delete-data="deleteUser" />
    </div>
</template>

<script>
    import {
        mapGetters
    } from "vuex";
    import TeacherCard from "../../../../components/teacher/TeacherCard.vue";
    import NotFound from "../../../../components/NotFound.vue";
    import DeleteModal from "../../../../components/modal/DeleteModal.vue";

    export default {
        components: {
            TeacherCard,
            NotFound,
            DeleteModal,
        },
        data() {
            return {
                search: "",
                selectedId: "",
                isModalShow: false,
            };
        },
        computed: {
            ...mapGetters({
                accountants: "accountant/accountants",
                pagination: "accountant/pagination",
            }),
            emptyData() {
                return this.accountants.total == 0;
            },
        },
        async mounted() {
            await this.hasPermisssion("accountant-list");
            this.fetchAccountant();
        },
        methods: {
            deleteConfirmation(id) {
                this.isModalShow = !this.isModalShow;
                this.selectedId = id;
            },
            async deleteUser() {
                let response = await axios.delete(`/api/accountants/${this.selectedId}`);
                this.isModalShow = false;
                this.$store.commit("accountant/REMOVE_ACCOUNTANT", this.selectedId);
                this.toastSuccess(response.data.message);
            },
            fetchAccountant(page = 1) {
                this.$store.dispatch("accountant/fetchAccountants", {
                    page: page,
                    search: this.search,
                });
            },
            searchTeachers() {
                this.fetchAccountant();
            },
        },
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
