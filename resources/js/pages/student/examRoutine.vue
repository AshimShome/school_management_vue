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
                <div class="row justify-content-center mx-auto">

                    <div class="col-md-3 col-sm-4 col-5">
                        <select v-model="searchForm.exam_id" class="form-control text-center"
                            :class="{'is-invalid': searchForm.errors.has('exam_id')}">
                            <option disabled selected value="">{{ $t('select_exam') }}</option>
                            <option v-for="exam in exams" :key="exam.id" :value="exam.id">{{ exam.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="class_id"></has-error>
                    </div>

                    <div class="col-md-3 col-sm-4 col-7">
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
                            {{ $t('exam_routines') }}
                        </div>
                    </div>
                    <div class="card-body card-body-scrollable card-body-scrollable-shadow">
                        <template>
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
export default {
    data() {
        return {
            // search form
            searchForm: new Form({
                exam_id: ""
            }),

            routines: []
        };
    },
    methods: {
        async getExamRoutine() {
            try {
                const response = await this.searchForm.post(
                    `/api/student/exam-routines`
                );
                this.routines = response.data.data;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        }
    },
    computed: {
        exams() {
            return this.$store.getters["exam/examList"];
        }
    },
    async created() {
        if (this.userRole != "Student") {
            this.redirect("401");
        }
        await this.$store.dispatch("exam/fetchExamsList");
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
