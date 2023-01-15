<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("exam") }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-md-3 col-xl-2 mb-3">
                        <select class="form-select" v-model="searchForm.session_from">
                            <option value="" class="d-none">
                                {{ $t("select_session_from") }}
                            </option>
                            <option v-for="session in sessionYears" :key="session.id"
                                :selected="session.id == current_session" :value="session.id">
                                {{ session.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="session_from"></has-error>
                    </div>
                    <div class="col-md-3 col-xl-2 mb-3" v-if="searchForm.session_from">
                        <select class="form-select" v-model="searchForm.session_to">
                            <option value="" class="d-none">
                                {{ $t("select_session_to") }}
                            </option>
                            <option v-for="session in sessionYears" :key="session.id"
                                :selected="session.id == current_session" :value="session.id"
                                :class="{ 'd-none': session.id == searchForm.session_from }">
                                {{ session.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="session_to"></has-error>
                    </div>
                    <div class="col-md-3 col-xl-2 mb-3" v-if="searchForm.session_from && searchForm.session_to">
                        <select v-model="searchForm.class_from" class="form-control"
                            :class="{ 'is-invalid': searchForm.errors.has('class_id') }">
                            <option value="" disabled>
                                {{ $t("select_class_from") }}
                            </option>
                            <option v-for="classs in classes" :key="classs.id" :value="classs.id">
                                {{ classs.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="class_id"></has-error>
                    </div>
                    <div class="col-md-3 col-xl-2 mb-b" v-if="searchForm.session_from && searchForm.session_to && searchForm.class_from">
                        <select v-model="searchForm.class_to" class="form-control"
                            :class="{ 'is-invalid': searchForm.errors.has('class_id') }">
                            <option value="" disabled>
                                {{ $t("select_class_to") }}
                            </option>
                            <option v-for="classs in classes" :key="classs.id" :value="classs.id"
                                :class="{ 'd-none': classs.id == searchForm.class_from }">
                                {{ classs.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="class_id"></has-error>
                    </div>
                    <div class="col-md-3 col-xl-2 mb-3"
                        v-if="searchForm.session_from && searchForm.session_to && searchForm.class_from && searchForm.class_to">
                        <button :disabled="disableSearchButton" @click="getStudents"
                            class="btn btn-primary btn-outline">
                            {{ $t("get_student_list") }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3" v-if="studentsSessions">
                <div class="card mb-3" v-for="(studentsSession, index) in studentsSessions" :key="index">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ $t("section") }}: {{ studentsSession[0].section.name }}
                        </h3>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-vcenter text-nowrap">
                            <thead>
                                <tr>
                                    <th>{{ $t("student_name") }}</th>
                                    <th>{{ $t("roll_no") }}</th>
                                    <th v-if="checkPermission('promotion-student')">
                                        {{ $t("action") }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(student, index) in studentsSession" :key="index">
                                    <td>{{ student.user.name }}</td>
                                    <td>{{ student.roll_no }}</td>
                                    <td v-if="checkPermission('promotion-student')">
                                        <button @click="promoteClass(student.id)" class="btn btn-primary">
                                            {{ $t("promote_to_class") }} {{ getClassName.name }}
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div v-else class="d-flex justify-content-center py-3">
                <NotFound word="student" />
            </div>
        </div>
    </div>
</template>

<script>
import NotFound from "../../../components/NotFound.vue";
import { mapGetters } from "vuex";

export default {
    components: {
        NotFound
    },
    data() {
        return {
            sessionYears: [],
            current_session: "",

            // search form
            searchForm: new Form({
                session_from: "",
                session_to: "",
                class_from: "",
                class_to: ""
            }),

            studentsSessions: []
        };
    },
    methods: {
        async getStudents() {
            try {
                const response = await this.searchForm.post(
                    `/api/promotions/student-list`
                );
                this.studentsSessions = response.data;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },

        async promoteClass(studentId) {
            if (confirm("Do you really want to promote this student?")) {
                const response = await this.searchForm.put(
                    `/api/promotions/${studentId}`
                );
                this.toastSuccess(response.data.message);
            }
        }
    },
    computed: {
        ...mapGetters({
            classes: "classs/classes"
        }),
        disableSearchButton() {
            return (
                this.searchForm.date == "" ||
                this.searchForm.class_id == "" ||
                this.searchForm.section_id == ""
            );
        },
        getClassName() {
            return this.classes.find(
                item => item.id == this.searchForm.class_to
            );
        }
    },
    async created() {
        await this.hasPermisssion("promotion-list");
        let response = await axios.get(`/api/sessions/year`);
        this.sessionYears = response.data.sessions;
        this.current_session = response.data.selectedSession.default_session_id;
        this.$store.dispatch("classs/fetchClasses");
    }
};
</script>
