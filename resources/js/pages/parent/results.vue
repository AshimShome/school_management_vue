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
                    <div class="col-6 col-sm-2">
                        <select v-model="searchForm.student_id" class="form-control text-center"
                            :class="{'is-invalid': searchForm.errors.has('student_id')}">
                            <option value="" selected class="d-none">{{ $t('select_child') }}</option>
                            <option v-for="child in childs" :key="child.id" :value="child.student_id">
                                {{ child.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="student_id"></has-error>
                    </div>
                    <div class="col-6 col-sm-3" v-if="searchForm.student_id">
                        <select v-model="searchForm.exam_id" class="form-control text-center"
                            :class="{ 'is-invalid': searchForm.errors.has('exam_id') }">
                            <option value="" disabled>{{ $t('select_exam') }}</option>
                            <option v-for="exam in exams" :key="exam.id" :value="exam.id">
                                {{ exam.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="class_id"></has-error>
                    </div>
                    <div class="col-5 col-sm-2" v-if="searchForm.student_id && searchForm.exam_id">
                        <button class="btn btn-primary btn-outline" @click.prevent="getExamResults">
                            {{ $t('get_exam_results') }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12" v-if="students.length">
                <div class="card mt-3">
                    <div class="card-header">
                        <div class="card-title">{{ $t('results') }}</div>
                    </div>
                    <div class="card-body">
                        <template>
                            <table class="table table-hover ">
                                <thead>
                                    <tr>
                                        <th>{{ $t('subject') }}</th>
                                        <th>{{ $t('marks') }}</th>
                                        <th>{{ $t('point') }} / {{ $t('grade') }}</th>
                                        <th>{{ $t('status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(subject,index) in subjects" :key="index">
                                        <td>{{ subject.name }}</td>
                                        <td>
                                            <span v-html="setMarks(subject.id)"></span>
                                            <span v-if="subjectmarks && subjectmarks.length">
                                                {{ $t('out_of') }} {{ subject.total_marks }}
                                            </span>
                                        </td>
                                        <td v-if="students[0]"
                                            v-html="setPointGrade(students[0].subjects[subject.id].results)" />
                                        <td v-if="students[0]">
                                            <span class="pass" v-if="students[0].subjects[subject.id].pass">
                                                {{ $t('passed') }}
                                            </span>
                                            <span class="fail" v-else>
                                                {{ $t('failed') }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right">
                                            <h2 class="font-weight-bold">{{ $t('gpa') }}:</h2>
                                        </td>
                                        <td>
                                            <h3>{{ finalResult.gpa }}</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-right">
                                            <h2 class="font-weight-bold">{{ $t('result') }}:</h2>
                                        </td>
                                        <td>
                                            <h3>
                                                <span v-if="finalResult.pass"
                                                    class="text-success">{{ $t('passed') }}</span>
                                                <span v-else class="text-danger">{{ $t('failed') }}</span>
                                            </h3>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </template>
                    </div>
                </div>
            </div>
            <template v-else>
                <NotFound word="results" />
            </template>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            disabledDates: {
                from: new Date(Date.now() + 8640000)
            },
            // search form
            searchForm: new Form({
                exam_id: "",
                student_id: ""
            }),

            subjects: [],
            students: [],
            subjectmarks: [],
            finalResult: {},
            url: "/images/default.png"
        };
    },
    methods: {
        async getExamResults() {
            try {
                const response = await this.searchForm.post(
                    `/api/parent/exam-results`
                );
                this.students = response.data.students;
                this.subjects = response.data.subjects;
                this.subjectmarks = response.data.students[0].marks;
                this.finalResult = response.data.students[0].final_results;
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
        },
        setPointGrade(result) {
            if (result.point) {
                if (result.point == 0) {
                    return `<span>
                    <b class="text-danger">${
                        result.point
                    }</b>${" / "}<b class="text-danger">${result.grade}</b>
                </span>`;
                } else {
                    return `<span>
                    <b>${result.point}</b>${" / "}<b>${result.grade}</b>
                </span>`;
                }
            } else if (result.point == 0) {
                return `<span>
                            <b>${result.point}</b>${" / "}<b>${result.grade}</b>
                        </span>`;
            }

            return `<span class="text-danger">(Marks did'nt entry)</span>`;
        },
        setMarks(subject_id) {
            if (this.subjectmarks && this.subjectmarks.length) {
                const subjectMark = this.subjectmarks.find(
                    subject => subject.subject_id == subject_id
                );
                return subjectMark.mark;
            } else {
                return `<span class="text-danger">(Marks did'nt entry)</span>`;
            }
        }
    },
    computed: {
        ...mapGetters({
            exams: "exam/examList",
            childs: "parent/getChilds"
        })
    },
    async created() {
        if (this.userRole != "Guardian") {
            this.redirect("401");
        }
        await this.$store.dispatch("exam/fetchExamsList");
        await this.$store.dispatch("parent/fetchChilds");
    },
    mounted() {
        if (this.exams.length) {
            this.searchForm.exam_id = this.exams[0].id;
            this.searchForm.student_id = this.childs[0].student_id;
            this.getExamResults();
        }
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

    .text-right {
        text-align: right;
    }
</style>
