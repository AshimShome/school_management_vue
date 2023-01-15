<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t('exam_routine') }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-6 col-sm-2">
                        <select v-model="searchForm.student_id" class="form-control text-center"
                            :class="{'is-invalid': searchForm.errors.has('student_id')}">
                            <option value="" disabled>{{ $t('select_child') }}</option>
                            <option v-for="child in childs" :key="child.id" :value="child.student_id">
                                {{ child.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="student_id"></has-error>
                    </div>
                    <div class="col-6 col-sm-3 col-md-2" v-if="searchForm.student_id">
                        <select v-model="searchForm.exam_id" class="form-control text-center"
                            :class="{ 'is-invalid': searchForm.errors.has('exam_id') }">
                            <option value="" disabled>{{ $t('select_exam') }}</option>
                            <option v-for="exam in exams" :key="exam.id" :value="exam.id">
                                {{ exam.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="class_id"></has-error>
                    </div>
                    <div class="col-6 col-sm-4" v-if="searchForm.student_id && searchForm.exam_id">
                        <button class="btn btn-primary btn-outline" @click.prevent="getExamRoutine">
                            {{ $t('get_exam_routine') }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3" v-if="routines.length">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            {{ $t('routines') }}
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ $t('date') }} ({{ $t('day') }}/{{ $t('month') }}/{{ $t('year') }})</th>
                                    <th>{{ $t('subject') }}</th>
                                    <th>{{ $t('start_time') }}</th>
                                    <th>{{ $t('end_time') }}</th>
                                    <th>{{ $t('room_no') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="routine in routines" :key="routine.id">
                                    <td>{{ formateDate(routine.exam_date,'D/MM/YY') }}</td>
                                    <td>{{ routine.subject.name }}</td>
                                    <td>{{ routine.start_time }}</td>
                                    <td>{{ routine.end_time }}</td>
                                    <td>{{ routine.room.room_no }}</td>
                                </tr>
                            </tbody>
                        </table>
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
import NotFound from "../../components/NotFound.vue";
import { mapGetters } from "vuex";
export default {
    components: {
        NotFound
    },
    data() {
        return {
            searchForm: new Form({
                exam_id: "",
                student_id: ""
            }),

            routines: []
        };
    },
    methods: {
        async getExamRoutine() {
            try {
                const response = await axios.get(
                    `/api/parent/student/exam-routines`,
                    {
                        params: {
                            exam_id: this.searchForm.exam_id,
                            student_id: this.searchForm.student_id
                        }
                    }
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
        this.searchForm.student_id = this.childs[0].student_id;
        this.searchForm.exam_id = this.exams[0].id;
        this.getExamRoutine();
    }
};
</script>


<style lang="scss" scoped>
    .text-align-center {
        text-align: center;
    }
</style>
