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
                            :class="{ 'is-invalid': searchForm.errors.has('session_id') }">
                            <option value="" disabled>{{ $t("select_session") }}</option>
                            <option v-for="session in sessions" :key="session.id" :value="session.id">
                                {{ session.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="session_id"></has-error>
                    </div>
                    <div class="col-md-3 col-xl-2" v-if="searchForm.session_id">
                        <select v-model="searchForm.class_id" class="form-control"
                            :class="{ 'is-invalid': searchForm.errors.has('class_id') }" @change="getSections">
                            <option value="" disabled>{{ $t("select_class") }}</option>
                            <option v-for="classs in classes" :key="classs.id" :value="classs.id">
                                {{ classs.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="class_id"></has-error>
                    </div>
                    <div class="col-md-3 col-xl-2" v-if="searchForm.session_id && searchForm.class_id">
                        <select :disabled="!sectionInput" v-model="searchForm.section_id" class="form-control"
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
                    <div class="col-md-3 col-xl-2" v-if="searchForm.session_id && searchForm.class_id && searchForm.section_id">
                        <select v-model="searchForm.type" class="form-control"
                            :class="{ 'is-invalid': searchForm.errors.has('type') }">
                            <option value="" disabled>{{ $t("select_type") }}</option>
                            <option value="date">{{ $t("date") }}</option>
                            <option value="month">{{ $t("monthly") }}</option>
                        </select>
                        <has-error :form="searchForm" field="type"></has-error>
                    </div>
                    <div class="col-md-3 col-xl-2" v-if="searchForm.type == 'date'">
                        <date-picker format="dd MMMM, yyyy" @input="setDate($event)" input-class="form-control mb-3"
                            :placeholder="$t('select_date')" />
                        <has-error :form="searchForm" field="date" class="d-block"></has-error>
                    </div>
                    <div class="col-md-3 col-xl-2 mb-3" v-if="searchForm.type == 'month'">
                        <date-picker format="MMMM, yyyy" @input="setMonth($event)" minimum-view="month"
                            input-class="form-control" :placeholder="$t('select_month')" />
                        <has-error :form="searchForm" field="date" class="d-block"></has-error>
                    </div>
                    <div class="col-md-3 col-xl-2 mb-3" v-if="searchForm.session_id && searchForm.class_id && searchForm.section_id && searchForm.type">
                        <button :disabled="searchForm.type == ''" class="btn btn-primary btn-outline"
                            @click.prevent="getAttendanceReport">
                            {{ $t("get_attendance_report") }}
                        </button>
                    </div>
                </div>
            </div>
            <div v-if="!attendances.length" class="d-flex justify-content-center py-3">
                <NotFound word="student" />
            </div>
            <div class="col-12" v-else>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ $t("attendance_report") }}</div>
                    </div>
                    <div class="card-body table-responsive">
                        <template v-if="attendances.length && attendence_type == 'date'">
                            <h3>{{ $t("day_wise_attendance") }}</h3>
                            <table class="table table-bordered table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th>{{ $t("photo") }}</th>
                                        <th>{{ $t("name") }}</th>
                                        <th>{{ $t("roll") }}</th>
                                        <th>{{ $t("status") }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="attendance in attendances" :key="attendance.id">
                                        <td>
                                            <img :src="attendance.student.user.image_url" alt="image" class="img-fluid mx-h-50 mx-w-50 rounded"
                                                height="80px" width="80px"/>
                                        </td>
                                        <td>{{ attendance.student.user.name }}</td>
                                        <td>{{ attendance.student.roll_no }}</td>
                                        <td>
                                            <div class="text-align-center text-white bg-green" v-if="attendance.status">
                                                P
                                            </div>
                                            <div class="text-align-center text-white bg-red" v-else>
                                                A
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </template>
                        <template v-else-if="attendances.length && attendence_type == 'month'">
                            <h3>{{ $t("month_wise_attendance") }}</h3>
                            <table class="table table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th>{{ $t("photo") }}</th>
                                        <th>{{ $t("name") }}</th>
                                        <th>{{ $t("roll") }}</th>
                                        <th class="text-align-center" v-for="day in daysInMonth" :key="day">
                                            {{ day }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="attendance in attendances" :key="attendance.id">
                                        <td>
                                            <img :src="attendance.user.image_url" alt="image" class="img-fluid mx-h-50 mx-w-50 rounded"
                                                height="80px" width="80px"/>
                                        </td>
                                        <td>{{ attendance.user.name }}</td>
                                        <td>{{ attendance.roll_no }}</td>
                                        <td v-for="day in daysInMonth" :key="day">
                                            <div class="text-align-center text-white bg-green"
                                                v-if="isPresent(day, attendance)">
                                                P
                                            </div>
                                            <div class="text-align-center text-white bg-red" v-else>
                                                A
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </template>
                        <div v-else class="d-flex justify-content-center py-3">
                            <NotFound word="Attendance" />
                        </div>
                    </div>
                </div>
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
                session_id: "",
                class_id: "",
                section_id: "",
                type: "",
                date: "",
                month: "",
                year: ""
            }),

            sectionInput: false,
            searchBtn: false,

            sections: [],
            attendances: [],
            attendence_type: "date",
            url: "/images/default.png"
        };
    },
    watch: {
        "searchForm.class_id": function(value) {
            this.sectionInput = true;
        },
        "searchForm.section_id": function(value) {
            this.searchBtn = true;
        },
        "searchForm.type": function(value) {
            this.searchForm.date = "";
            this.searchForm.month = "";
            this.searchForm.year = "";
        }
    },
    methods: {
        setDate(event) {
            const date = dayjs(event).format("YYYY-MM-DD");
            this.searchForm.date = date;
        },
        setMonth(event) {
            const month = dayjs(event).format("MM");
            const year = dayjs(event).format("YYYY");
            this.searchForm.month = month;
            this.searchForm.year = year;
        },
        isPresent(day, attendance) {
            const dayStr = day < 10 ? `0${day}` : day;
            const fullDay = `${this.searchForm.year}-${this.searchForm.month}-${dayStr}`;

            if (attendance.attendances.hasOwnProperty(fullDay)) {
                return attendance.attendances[fullDay][0]["status"] == 1
                    ? true
                    : false;
            }

            return false;
        },
        async getSections() {
            this.sections = [];
            const response = await axios.get(
                `/api/classes/${this.searchForm.class_id}/sections`
            );
            this.sections = response.data.sections;
        },
        async getAttendanceReport() {
            this.attendences = [];
            try {
                const response = await this.searchForm.post(
                    `/api/reports/students-attendance`
                );

                this.attendence_type = this.searchForm.type;
                this.attendances = response.data.attendences;
                console.log(response);
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
        }),
        daysInMonth() {
            if (this.searchForm.year == "" || this.searchForm.month == "") {
                return false;
            }

            return dayjs(
                `${this.searchForm.year}-${this.searchForm.month}`
            ).daysInMonth();
        }
    },
    async created() {
        await this.hasPermisssion("student-attendance-report");
        this.$store.dispatch("session/fetchSessions");
        this.$store.dispatch("classs/fetchClasses");
        let current_session = await axios.get("/api/get-current-session");
        let session = this.sessions.find(
            session => session.id == current_session.data.id
        );
        this.searchForm.session_id = session.id;
    }
};
</script>


<style lang="scss" scoped>
    .text-align-center {
        text-align: center;
    }
</style>
