<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("student") }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-md-3 col-xl-2">
                        <select v-model="searchForm.class_id" @change="getSections" class="form-control"
                            :class="{ 'is-invalid': searchForm.errors.has('class_id') }">
                            <option value="" class="d-none">{{ $t("select_class") }}</option>
                            <option v-for="classs in classes" :key="classs.id" :value="classs.id">
                                {{ classs.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="class_id"></has-error>
                    </div>
                    <div class="col-md-3 col-xl-2" v-if="searchForm.class_id">
                        <select v-model="searchForm.section_id" class="form-control"
                            :class="{ 'is-invalid': searchForm.errors.has('section_id') }">
                            <option v-if="sections && sections.length" class="d-none" selected value="">
                                {{ $t("select_section") }}
                            </option>
                            <option v-else class="d-none" selected value="">
                                {{ $t("no_section_found") }}
                            </option>
                            <template v-if="sections && sections.length">
                                <option v-for="section in sections" :key="section.id" :value="section.id">
                                    {{ section.name }}
                                </option>
                            </template>
                        </select>
                        <has-error :form="searchForm" field="section_id"></has-error>
                    </div>
                    <div class="col-md-3 col-xl-2" v-if="searchForm.class_id && searchForm.section_id">
                        <button :disabled="searchButtonDisabled" @click="getStudents"
                            class="btn btn-primary btn-outline">
                            {{ $t("get_student_list") }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3" v-if="students && students.length">
                <form @submit.prevent="saveAttendance">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">{{ $t("students") }}</div>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th>{{ $t("image") }}</th>
                                        <th>{{ $t("name") }}</th>
                                        <th>{{ $t("roll_number") }}</th>
                                        <th>{{ $t("gender") }}</th>
                                        <th>{{ $t("date_of_birth") }}</th>
                                        <th>{{ $t("blood_group") }}</th>
                                        <th>{{ $t("admission_date") }}</th>
                                        <th>{{ $t("parent_name") }}</th>
                                        <th>{{ $t("parent_phone") }}</th>
                                        <th>{{ $t("action") }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="student in students" :key="student.id">
                                        <td>
                                            <img :src="url" alt="image" class="img-fluid mx-h-50 mx-w-50 rounded" height="80px" width="80px"
                                                />
                                        </td>
                                        <td>
                                            <router-link :to="{ name: 'user-student-view', params: { id: student.id } }">
                                                {{ student.user.name }}
                                            </router-link>
                                        </td>
                                        <td>
                                            {{ student.roll_no }}
                                        </td>
                                        <td>
                                            {{ student.gender | capitalize }}
                                        </td>
                                        <td>
                                            {{ student.date_of_birth }}
                                        </td>
                                        <td>
                                            {{ student.blood_group }}
                                        </td>
                                        <td>
                                            {{ student.admission_date }}
                                        </td>
                                        <td>
                                            {{ student.guardian.user.name }}
                                        </td>
                                        <td>
                                            {{ student.guardian.phone }}
                                        </td>
                                        <td>
                                            <router-link :to="{ name: 'user-student-view', params: { id: student.id } }" href="#" class="">{{ $t("view_details") }}</router-link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div v-else class="d-flex justify-content-center py-3">
                <NotFound word="student" />
            </div>
        </div>
    </div>
</template>

<script>
    import NotFound from "../../../components/NotFound.vue";

    import {
        mapGetters
    } from "vuex";

    export default {
        components: {
            NotFound,
        },
        data() {
            return {
                disabledDates: {
                    from: new Date(Date.now() + 8640000),
                },
                // search form
                searchForm: new Form({
                    class_id: "",
                    section_id: "",
                }),

                sections: [],
                students: [],
                url: "/images/default.png",
            };
        },
        methods: {
            async getStudents() {
                let response = await this.searchForm.post(`/api/reports/students`);
                this.students = response.data.data;
            },
            async getSections() {
                const response = await axios.get(
                    `/api/classes/${this.searchForm.class_id}/sections`
                );
                this.sections = response.data.sections;
            },
        },
        computed: {
            ...mapGetters({
                sessions: "session/sessions",
                classes: "classs/classes",
            }),
            emptyData() {
                return this.students.length;
            },
            searchButtonDisabled() {
                return this.searchForm.class_id == "" || this.searchForm.section_id == "";
            },
        },
        async created() {
            await this.hasPermisssion("student-report");
            this.$store.dispatch("session/fetchSessions");
            this.$store.dispatch("classs/fetchClasses");
        },
    };
</script>
