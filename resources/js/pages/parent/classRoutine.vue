<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t('academic') }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-sm-2 col-4">
                        <select v-model="searchForm.student_id" class="form-control"
                            :class="{'is-invalid': searchForm.errors.has('student_id')}">
                            <option value="" selected class="d-none">{{ $t('select_child') }}</option>
                            <option v-for="child in childs" :key="child.id" :value="child.student_id">
                                {{ child.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="student_id"></has-error>
                    </div>
                    <div class="col-8 col-sm-2">
                        <button :disabled="!searchForm.student_id" @click="getStudentRoutines"
                            class="btn btn-primary btn-outline">
                            {{ $t('get_class_routine') }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3" v-if="showRoutine && calendarData && weekDays">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">{{ $t('routines') }}</h2>
                    </div>
                    <div class="card-body table-responsive">
                        <ClassRoutine :calendarData="calendarData" :weekDays="weekDays"/>
                    </div>
                </div>
            </div>
            <div v-else class="d-flex justify-content-center py-3">
                <NotFound word="class routine" />
            </div>
        </div>
    </div>
</template>

<script>
import dayjs from "dayjs";
import ClassRoutine from "../../components/academic/ClassRoutine.vue";
import NotFound from "../../components/NotFound.vue";
import ButtonLoading from "../../components/ButtonLoading.vue";
import { mapGetters } from "vuex";
export default {
    components: {
        ClassRoutine,
        NotFound,
        ButtonLoading
    },
    computed: {
        ...mapGetters({
            user: "auth/user",
            childs: "parent/getChilds"
        })
    },
    data() {
        return {
            showRoutine: false,
            weekDays: [],
            calendarData: [],
            searchForm: new Form({
                student_id: ""
            })
        };
    },
    methods: {
        async getStudentRoutines() {
            try {
                let response = await axios.get(
                    `/api/parent/student/${this.searchForm.student_id}/routine`
                );

                this.showRoutine = true;
                this.weekDays = response.data.weekDays;
                this.calendarData = response.data.calendarData;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        }
    },
    created() {
        if (this.userRole != "Guardian") {
            this.redirect("401");
        }
        this.$store.dispatch("parent/fetchChilds");
        this.searchForm.student_id = this.childs[0].student_id;
        this.getStudentRoutines();
    }
};
</script>

<style lang="scss" scoped>
    td {
        padding: 0;
    }

    tr td:first-of-type {
        padding: .5rem;
        text-transform: capitalize;
    }
</style>
