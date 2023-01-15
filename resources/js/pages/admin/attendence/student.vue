<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("attendance") }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-sm-12 col-md-3 col-lg-2 mb-3">
                        <date-picker :disabledDates="disabledDates" format="dd MMMM, yyyy" @input="setDate($event)"
                            input-class="form-control" :placeholder="$t('select_date')" :value="searchForm.date" />
                        <has-error :form="searchForm" field="date" class="d-block"></has-error>
                    </div>

                    <div class="col-sm-12 col-md-3 col-lg-2 mb-3" v-if="searchForm.date">
                        <select v-model="searchForm.class_id" @change="getSections" class="form-control"
                            :class="{ 'is-invalid': searchForm.errors.has('class_id') }">
                            <option value="" class="d-none">{{ $t("select_class") }}</option>
                            <option v-for="classs in classes" :key="classs.id" :value="classs.id">
                                {{ classs.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="class_id"></has-error>
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-2 mb-3" v-if="searchForm.date && searchForm.class_id">
                        <select v-model="searchForm.section_id" class="form-control"
                            :class="{ 'is-invalid': searchForm.errors.has('section_id') }">
                            <option v-if="sections && sections.length" class="d-none" selected value="" disabled>
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
                    <div class="col-sm-12 col-md-3 col-lg-2 mb-3" v-if="
              searchForm.date && searchForm.class_id && searchForm.section_id
            ">
                        <button :disabled="disableSearchButton" @click="getStudents"
                            class="btn btn-primary btn-outline">
                            {{ $t("get_student_list") }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3" v-if="students.length && attendences_load">
                <form @submit.prevent="saveAttendance">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">{{ $t("attendance") }}</div>
                        </div>
                        <div class="card-body p-0 table-responsive">
                            <table class="table table-vcenter">
                                <thead>
                                    <tr>
                                        <th>{{ $t("image") }}</th>
                                        <th>{{ $t("name") }}</th>
                                        <th>{{ $t("roll_number") }}</th>
                                        <th>{{ $t("status") }}</th>
                                        <th>{{ $t("previous_7_days_status") }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(student, index) in students" :key="student.id">
                                        <td>
                                            <img :src="student.user.image_url" alt="" class="img-fluid mx-h-50 mx-w-50 rounded" height="50px"
                                                width="50px"/>
                                        </td>
                                        <td>
                                            {{ student.user.name }}
                                        </td>
                                        <td>
                                            {{ student.roll_no }}
                                        </td>
                                        <td>
                                            <div class="mb-3">
                                                <div>
                                                    <label class="form-check form-check-inline">
                                                        <input v-model="attendance_form[index]" class="form-check-input"
                                                            type="radio" :value="true" />
                                                        <span class="form-check-label">{{
                              $t("present")
                            }}</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input v-model="attendance_form[index]" class="form-check-input"
                                                            type="radio" :value="false" />
                                                        <span class="form-check-label">{{
                              $t("absent")
                            }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex items-center">
                                                <div class="
                            d-flex
                            flex-column
                            align-items-center
                            justify-content-center
                            mx-2
                          " v-for="(attendance, index) in last_days_attendaces[0]" :key="index">
                                                    <span>{{ formateDate(attendance.date, "DD") }}</span>
                                                    <span class="d-inline-block">
                                                        <icon-check v-if="attendance.status" stroke="#2A8737" />
                                                        <icon-cross v-else stroke="#F23D4E" />
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary text-center">
                                {{ $t("save_all") }}
                            </button>
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
import dayjs from "dayjs";
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
                date: "",
                class_id: "",
                section_id: ""
            }),

            sections: [],
            students: [],
            attendance_form: [],
            last_days_attendaces: [],

            attendance_errors: [],
            attendences_load: false,
            url: "/images/default.png"
        };
    },
    methods: {
        async getStudents() {
            this.students = [];
            this.attendance_form = [];
            this.attendance_errors = [];
            this.attendences_load = false;

            try {
                const response = await this.searchForm.post(
                    `/api/attendance/get-students`
                );
                this.students = response.data.students;
                this.last_days_attendaces = response.data.lastdays_attendace;
                this.generateAttendance();
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        setDate(event) {
            const formatTime = dayjs(event).format("YYYY-MM-DD");
            this.searchForm.date = formatTime;
        },
        async saveAttendance() {
            try {
                const data = this.students.map((student, index) => {
                    return {
                        student_id: student.id,
                        status: this.attendance_form[index],
                        class_id: this.searchForm.class_id,
                        section_id: this.searchForm.section_id,
                        date: this.searchForm.date
                    };
                });

                const response = await axios.put(`/api/attendance/student`, {
                    student_data: data
                });
                this.toastSuccess(response.data.message);
            } catch (error) {
                this.toastError(error.response.data.message);
                if (error.response.status == 422) {
                    this.attendance_errors = error.response.data.errors;
                }

                console.log(error);
            }
        },
        async getClass() {
            this.$store.dispatch("classs/fetchClasses");
        },
        async getSections() {
            const response = await axios.get(
                `/api/classes/${this.searchForm.class_id}/sections`
            );
            this.sections = response.data.sections;
        },
        generateAttendance() {
            this.students.forEach((student, index) => {
                this.attendance_form[index] = student.attendances.status;
            });
            this.attendences_load = true;
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
        }
    },
    async mounted() {
        this.hasPermisssion("student-attendance-list");
        this.$store.dispatch("classs/fetchClasses");
        this.searchForm.date = dayjs().format("YYYY-MM-DD");
    }
};
</script>
