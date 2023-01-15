<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("report") }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">{{ $t("staff_report") }}</h2>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-vcenter text-nowrap" v-if="staffs && staffs.length">
                            <thead>
                                <tr>
                                    <th>{{ $t("photo") }}</th>
                                    <th>{{ $t("name") }}</th>
                                    <th>{{ $t("email") }}</th>
                                    <th>{{ $t("joining_date") }}</th>
                                    <th>{{ $t("gender") }}</th>
                                    <th>{{ $t("religion") }}</th>
                                    <th>{{ $t("phone") }}</th>
                                    <th>{{ $t("action") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="teacher in staffs" :key="teacher.id">
                                    <td>
                                        <img :src="url" alt="image" class="img-fluid mx-h-50 mx-w-50 rounded" height="80px" width="80px"/>
                                    </td>
                                    <td>{{ teacher.user.name }}</td>
                                    <td>{{ teacher.user.email }}</td>
                                    <td>{{ teacher.joining_date }}</td>
                                    <td>{{ teacher.gender | capitalize }}</td>
                                    <td>{{ teacher.religion }}</td>
                                    <td>{{ teacher.phone }}</td>
                                    <td>
                                        <router-link :to="{ name: 'user-teacher-view', params: { id: teacher.id } }" href="#" class="">{{ $t("view_details") }}</router-link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-else class="d-flex justify-content-center py-3">
                            <NotFound word="staff" />
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
            staffs: []
        };
    },
    async created() {
        await this.hasPermisssion("staff-report");
        this.loadTeacherReport();
    },
    methods: {
        async loadTeacherReport() {
            try {
                const response = await axios.post(`/api/reports/staffs`);
                this.staffs = response.data.data;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        }
    }
};
</script>
