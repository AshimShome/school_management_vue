<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("teacher") }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none" v-if="checkPermission('teacher-create')">
                    <div class="d-flex">
                        <input type="search" class="form-control d-inline-block w-9 me-3"
                            :placeholder="$t('search_here…')" @keyup="searchTeachers" v-model="search" />
                        <router-link :to="{ name: 'user-teacher-add' }" class="btn btn-primary btn-outline">
                            <icon-plus />
                            {{ $t("create") }}
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cards mt-2" v-if="!emptyData">
            <template v-if="teachers && teachers.length">
                <div class="col-md-6 col-xl-3" v-for="(teacher, index) in teachers" :key="index">
                    <div class="card user-card" v-if="teacher.user">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <img :src="teacher.user.image_url" alt="image" class="avatar avatar-lg avatar-rounded rounded"
                                    />
                            </div>
                            <div class="card-title mb-1">
                                {{ teacher.user.name }}
                                <h5>{{ teacher.department.name }}</h5>
                            </div>
                        </div>
                        <div class="d-flex">
                            <router-link :to="{ name: 'user-teacher-edit', params: { id: teacher.id } }"
                                class="card-btn d-inline-block" v-if="checkPermission('teacher-edit')">
                                <icon-edit />
                            </router-link>

                            <router-link :to="{ name: 'user-teacher-view', params: { id: teacher.id } }" href="#"
                                class="card-btn">
                                <icon-eye />
                            </router-link>

                            <a href="javascript:void(0)" @click="deleteConfirmation(teacher.id)"
                                class="card-btn d-inline-block" v-if="checkPermission('teacher-delete')">
                                <icon-trash /></a>
                        </div>
                    </div>
                </div>
            </template>
            <div v-else class="d-flex justify-content-center py-3">
                <NotFound word="teacher" />
            </div>
            <div class="mt-5">
                <div class="d-flex justify-content-center mt-4">
                    <pagination :data="pagination" @pagination-change-page="fetchTeachers"></pagination>
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
import { mapGetters } from "vuex";
import TeacherCard from "../../../../components/teacher/TeacherCard.vue";
import NotFound from "../../../../components/NotFound.vue";
import DeleteModal from "../../../../components/modal/DeleteModal.vue";

export default {
    components: {
        TeacherCard,
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
            teachers: "teacher/teachers",
            pagination: "teacher/pagination"
        }),
        emptyData() {
            return this.teachers.total == 0;
        }
    },
    async mounted() {
        await this.hasPermisssion("teacher-list");
        this.fetchTeachers();
        this.$store.dispatch("department/fetchDepartments");
    },
    methods: {
        deleteConfirmation(id) {
            this.isModalShow = !this.isModalShow;
            this.selectedId = id;
        },
        async deleteUser() {
            let response = await axios.delete(
                `/api/teachers/${this.selectedId}`
            );
            this.isModalShow = false;
            this.$store.commit("teacher/REMOVE_TEACHER", this.selectedId);
            this.toastSuccess(response.data.message);
        },
        fetchTeachers(page = 1) {
            this.$store.dispatch("teacher/fetchTeachers", {
                page: page,
                search: this.search
            });
        },
        searchTeachers() {
            this.fetchTeachers();
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
