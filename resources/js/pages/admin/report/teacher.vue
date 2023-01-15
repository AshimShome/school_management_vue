<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("teacher") }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">{{ $t("teachers_report") }}</h2>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-vcenter text-nowrap" v-if="teachers && teachers.length">
                            <thead>
                                <tr>
                                    <th>{{ $t("photo") }}</th>
                                    <th>{{ $t("name") }}</th>
                                    <th>{{ $t("email") }}</th>
                                    <th>{{ $t("department") }}</th>
                                    <th>{{ $t("joining_date") }}</th>
                                    <th>{{ $t("gender") }}</th>
                                    <th>{{ $t("religion") }}</th>
                                    <th>{{ $t("phone") }}</th>
                                    <th>{{ $t("action") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="teacher in teachers" :key="teacher.id">
                                    <td>
                                        <img :src="url" alt="image" class="img-fluid mx-h-50 mx-w-50 rounded" height="80px" width="80px"/>
                                    </td>
                                    <td>{{ teacher.user.name }}</td>
                                    <td>{{ teacher.user.email }}</td>
                                    <td>{{ teacher.department.name }}</td>
                                    <td>{{ formateDate(teacher.joining_date) }}</td>
                                    <td>{{ teacher.gender | capitalize }}</td>
                                    <td>{{ teacher.religion | capitalize }}</td>
                                    <td>{{ teacher.phone }}</td>
                                    <td>
                                        <router-link :to="{ name: 'user-teacher-view', params: { id: teacher.id } }" href="#" class="">{{ $t("view_details") }}</router-link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-else class="d-flex justify-content-center py-3">
                            <NotFound word="teacher" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NotFound from "../../../components/NotFound.vue";

export default {
    components: {
        NotFound
    },
    data() {
        return {
            url: "/images/default.png",
            teachers: []
        };
    },
    async created() {
        await this.hasPermisssion("teacher-report");
        this.loadTeacherReport();
    },
    methods: {
        async loadTeacherReport() {
            try {
                const response = await axios.post(`/api/reports/teachers`);
                this.teachers = response.data.data;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        }
    }
};
</script>
