<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col-sm col-4">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                </div>
                <div class="col-sm-auto col-8 ms-auto d-print-none">
                    <div class="d-flex">
                        <input type="search" class="form-control d-inline-block w-9"
                            :placeholder="$t('search_here…')" @keyup="searchTeachers" v-model="search" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cards mt-2" v-if="teachers.length">
            <div class="col-md-6 col-xl-3" v-for="teacher in teachers" :key="teacher.id">
                <div class="card user-card">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <img :src="teacher.user.image_url" alt="image" class="avatar avatar-xl avatar-rounded rounded"
                                />
                        </div>
                        <div class="card-title mb-1">{{ teacher.user.name }}</div>
                        <div class="text-muted">{{ teacher.department.name }}</div>
                    </div>
                    <router-link :to="{ name: 'user-teacher-view', params: { id: teacher.id } }" class="card-btn">
                        {{ $t('view_details') }}</router-link>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-4">
                <pagination :data="pagination" @pagination-change-page="fetchTeachers"></pagination>
            </div>
        </div>
        <div v-else class="d-flex justify-content-center py-3">
            <NotFound word="teachers" route="user-teacher-add" :btnShow="false" />
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            search: "",
            userRole: "",
        };
    },
    computed: {
        ...mapGetters({
            teachers: "teacher/teachers",
            pagination: "teacher/pagination"
        })
    },
    async created() {
        if (
            this.userRole != "Guardian" &&
            this.userRole != "Student"
        ) {
            this.redirect("401");
        }

        await this.fetchTeachers();
    },
    methods: {
        async fetchTeachers(page = 1) {
            await this.$store.dispatch("teacher/fetchTeachers", {
                page: page,
                search: this.search
            });
        },
        async searchTeachers() {
            await this.fetchTeachers();
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
