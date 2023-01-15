<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t('exam') }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-md-3 mb-3">
                        <select v-model="searchForm.exam_id" class="form-control"
                            :class="{ 'is-invalid': searchForm.errors.has('exam_id') }" @change="loadClasses">
                            <option value="" class="d-none">{{ $t("select_exam") }}</option>
                            <option v-for="exam in exams" :key="exam.id" :value="exam.id">
                                {{ exam.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="class_id"></has-error>
                    </div>
                    <div class="col-md-3 mb-3" v-if="searchForm.exam_id">
                        <select v-model="searchForm.class_id" class="form-control"
                            :class="{ 'is-invalid': searchForm.errors.has('class_id') }" @change="loadSections">
                            <option value="" class="d-none">{{ $t("select_class") }}</option>
                            <option v-for="classs in classes" :key="classs.id" :value="classs.id">
                                {{ classs.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="class_id"></has-error>
                    </div>
                    <div class="col-md-3 mb-3" v-if="searchForm.exam_id && searchForm.class_id">
                        <select :disabled="!sectionInput" v-model="searchForm.section_id" class="form-control"
                            :class="{ 'is-invalid': searchForm.errors.has('section_id') }">
                            <option class="d-none" value="">
                                {{ $t("select_section") }}
                            </option>
                            <option v-for="section in sections" :key="section.id" :value="section.id">
                                {{ section.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="section_id"></has-error>
                    </div>
                    <div class="col-md-3 mb-3" v-if="searchForm.exam_id && searchForm.class_id && searchForm.section_id">
                        <button class="btn btn-primary btn-outline" @click.prevent="getExamResults">
                            {{ $t("get_exam_results") }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3" v-if="students.length">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ $t("results") }}</div>
                    </div>
                    <div class="card-body table-responsive">
                        <template>
                            <table class="table table-hover table-bordered table-striped table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th>{{ $t("name") }}</th>
                                        <th>{{ $t("roll_no") }}</th>
                                        <th v-for="subject in subjects" :key="subject.id">
                                            {{ subject.name }}
                                        </th>
                                        <th>{{ $t("gpa") }}</th>
                                        <th>{{ $t("status") }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="student in students" :key="student.id">
                                        <td>{{ student.user.name }}</td>
                                        <td>{{ student.roll_no }}</td>
                                        <td v-for="subject in subjects" :key="subject.id">
                                            <div class="result" v-html="getResult(subject, student)"></div>
                                        </td>
                                        <td>
                                            {{ student.final_results.gpa }}
                                        </td>
                                        <td>
                                            <span v-if="student.final_results.pass" class="pass">{{ $t("pass") }}</span>
                                            <span v-else class="fail">{{ $t("failed") }}</span>
                                        </td>
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
                term_id: "",
                exam_id: "",
                class_id: "",
                section_id: ""
            }),

            sectionInput: false,
            searchBtn: false,

            classes: [],
            sections: [],
            routines: [],

            subjects: [],
            students: [],
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
        loadTerms() {
            this.$store.dispatch("examterm/fetchTerms");
        },
        async loadExams() {
            try {
                const response = await axios.post(
                    "/api/exams-by-session-and-term",
                    {
                        session_id: this.searchForm.session_id,
                        term_id: this.searchForm.term_id
                    }
                );
                this.exams = response.data.data;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async loadClasses() {
            let response = await axios.get("/api/subjects/allclasses");
            this.classes = response.data.classes;
        },
        async loadSections() {
            this.sections = [];
            const response = await axios.get(
                `/api/classes/${this.searchForm.class_id}/sections`
            );
            this.sections = response.data.sections;
        },
        async getExamResults() {
            try {
                const response = await this.searchForm.post(
                    `/api/reports/exam-results`
                );
                this.students = response.data.students;
                this.subjects = response.data.subjects;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        getResult(subject, student) {
            const subjectResult = student.subjects[subject.id];
            if (subjectResult.entry == false) {
                return subjectResult.results;
            }

            return subjectResult.results["grade"];
        }
    },
    computed: {
        ...mapGetters({
            exams: "exam/examList"
        })
    },
    async created() {
        await this.hasPermisssion("exam-result-list");
        await this.$store.dispatch("exam/fetchExamsList");
    }
};
</script>


<style lang="scss" scoped>
    .text-align-center {
        text-align: center;
    }

    .result {
        span.no-result {
            color: red;
        }
    }

    .pass,
    .fail {
        padding: 5px;
    }

    .pass {
        background-color: green;
        color: white;
    }

    .fail {
        background-color: red;
        color: white;
    }
</style>
