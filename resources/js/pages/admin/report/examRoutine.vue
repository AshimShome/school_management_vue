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
                        <select v-model="searchForm.session_id" class="form-control"
                            :class="{ 'is-invalid': searchForm.errors.has('session_id') }"
                            @change="getAllExamBySession">
                            <option disabled selected value="">
                                {{ $t("select_session") }}
                            </option>
                            <option v-for="session in sessions" :key="session.id" :value="session.id">
                                {{ session.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="class_id"></has-error>
                    </div>
                    <div class="col-md-3 col-xl-2" v-if="searchForm.session_id">
                        <select v-model="searchForm.exam_id" class="form-control"
                            :class="{ 'is-invalid': searchForm.errors.has('exam_id') }">
                            <option disabled selected value="">
                                {{ $t("select_exam") }}
                            </option>
                            <option v-for="exam in exams" :key="exam.id" :value="exam.id">
                                {{ exam.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="class_id"></has-error>
                    </div>
                    <div class="col-md-3 col-xl-2" v-if="searchForm.session_id && searchForm.exam_id">
                        <select v-model="searchForm.class_id" class="form-control"
                            :class="{ 'is-invalid': searchForm.errors.has('class_id') }" @change="loadSections">
                            <option disabled selected value="">
                                {{ $t("select_class") }}
                            </option>
                            <option v-for="classs in classes" :key="classs.id" :value="classs.id">
                                {{ classs.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="class_id"></has-error>
                    </div>
                    <div class="col-md-3 col-xl-2" v-if="searchForm.session_id && searchForm.exam_id && searchForm.class_id">
                        <select :disabled="!sectionInput" v-model="searchForm.section_id" class="form-control"
                            :class="{ 'is-invalid': searchForm.errors.has('section_id') }">
                            <option disabled selected value="">
                                {{ $t("no_section_found") }}
                            </option>
                            <option v-for="section in sections" :key="section.id" :value="section.id">
                                {{ section.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="section_id"></has-error>
                    </div>
                    <div class="col-md-3 col-xl-2" v-if="searchForm.session_id && searchForm.exam_id && searchForm.class_id && searchForm.section_id">
                        <button class="btn btn-primary btn-outline" @click.prevent="getExamRoutine">
                            {{ $t("get_exam_routine") }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3" v-if="routines.length">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ $t("routines") }}</div>
                    </div>
                    <div class="card-body table-responsive">
                        <template>
                            <table class="table table-hover table-bordered table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th>
                                            {{ $t("date") }} ({{ $t("day") }}/{{ $t("month") }}/{{ $t("year") }})
                                        </th>
                                        <th>{{ $t("subject") }}</th>
                                        <th>{{ $t("start_time") }}</th>
                                        <th>{{ $t("end_time") }}</th>
                                        <th>{{ $t("room_no") }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="routine in routines" :key="routine.id">
                                        <td>{{ formateDate(routine.exam_date, "D/MM/YY") }}</td>
                                        <td>{{ routine.subject.name }}</td>
                                        <td>{{ routine.start_time }}</td>
                                        <td>{{ routine.end_time }}</td>
                                        <td>{{ routine.room.room_no }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </template>
                    </div>
                </div>
            </div>
            <template v-else>
                <NotFound word="routines" />
            </template>
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
            disabledDates: {
                from: new Date(Date.now() + 8640000)
            },
            // search form
            searchForm: new Form({
                session_id: "",
                exam_id: "",
                class_id: "",
                section_id: ""
            }),

            sectionInput: false,
            searchBtn: false,
            exams: [],
            sections: [],
            routines: [],
            url: "/images/default.png"
        };
    },
    watch: {
        "searchForm.class_id": function(value) {
            this.sectionInput = true;
        },
        "searchForm.section_id": function(value) {
            this.searchBtn = true;
        }
    },
    methods: {
        async loadSections() {
            this.sections = [];
            const response = await axios.get(
                `/api/classes/${this.searchForm.class_id}/sections`
            );
            this.sections = response.data.sections;
        },
        async getExamRoutine() {
            try {
                const response = await this.searchForm.post(
                    `/api/reports/exam-routines`
                );
                this.routines = response.data.data;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async getAllExamBySession() {
            try {
                const response = await axios.post(`/api/exams-by-session`, {
                    session_id: this.searchForm.session_id
                });
                this.exams = response.data.data;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        }
    },
    computed: {
        ...mapGetters({
            sessions: "session/sessions",
            classes: "classs/classes"
        })
    },
    async created() {
        await this.hasPermisssion("exam-schedule-report");
        await this.$store.dispatch("session/fetchSessions");
        await this.$store.dispatch("classs/fetchClasses");
        let current_session = await axios.get("/api/get-current-session");
        let session = this.sessions.find(
            session => session.id == current_session.data.id
        );
        this.searchForm.session_id = session.id;
        this.getAllExamBySession();
    }
};
</script>


<style lang="scss" scoped>
    .text-align-center {
        text-align: center;
    }
</style>
