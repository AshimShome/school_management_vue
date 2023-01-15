<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("teacher") }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-md-3 col-xl-2">
                        <select v-model="searchForm.type" class="form-control"
                            :class="{ 'is-invalid': searchForm.errors.has('type') }">
                            <option value="" class="d-none">
                                {{ $t("select_type") }}
                            </option>
                            <option value="date">{{ $t("date") }}</option>
                            <option value="month">{{ $t("monthly") }}</option>
                        </select>
                        <has-error :form="searchForm" field="type"></has-error>
                    </div>
                    <div class="col-md-3 col-xl-2 mb-3" v-if="searchForm.type == 'date'">
                        <date-picker format="dd MMMM, yyyy" @input="setDate($event)" input-class="form-control"
                            :placeholder="$t('select_date')" />
                        <has-error :form="searchForm" field="date" class="d-block"></has-error>
                    </div>
                    <div class="col-md-3 col-xl-2 mb-3" v-if="searchForm.type == 'month'">
                        <date-picker format="MMMM, yyyy" @input="setMonth($event)" input-class="form-control"
                            :placeholder="$t('select_month')" minimum-view="month" />
                        <has-error :form="searchForm" field="date" class="d-block"></has-error>
                    </div>
                    <div class="col-md-3 col-xl-2 mb-3" v-if="searchForm.type">
                        <button :disabled="searchForm.type == ''" class="btn btn-primary btn-outline"
                            @click.prevent="getAttendanceReport">
                            {{ $t("get_attendacne_report") }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <form @submit.prevent="saveAttendance">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">{{ $t("attendance") }}</div>
                        </div>
                        <div class="card-body table-responsive">
                            <template v-if="attendances.length && attendence_type == 'date'">
                                <h3>{{ $t("day_wise_attendance") }}</h3>
                                <table class="table table-vcenter text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>{{ $t("photo") }}</th>
                                            <th>{{ $t("name") }}</th>
                                            <th>{{ $t("phone") }}</th>
                                            <th>{{ $t("department") }}</th>
                                            <th>{{ $t("status") }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="attendance in attendances" :key="attendance.id">
                                            <td>
                                                <img :src="attendance.teacher.user.image_url" alt="image"
                                                    class="img-fluid mx-h-50 mx-w-50 rounded" height="80px" width="80px"/>
                                            </td>
                                            <td>{{ attendance.teacher.user.name }}</td>
                                            <td>{{ attendance.teacher.phone }}</td>
                                            <td>{{ attendance.teacher.department.name }}</td>
                                            <td>
                                                <div class="text-align-center text-white bg-green"
                                                    v-if="attendance.status">
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
                                <table class="table table-hover table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ $t("photo") }}</th>
                                            <th>{{ $t("name") }}</th>

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
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import dayjs from "dayjs";
import NotFound from "../../../components/NotFound.vue";

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
                type: "",
                date: "",
                month: "",
                year: ""
            }),

            sectionInput: false,
            searchBtn: false,
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
        async getAttendanceReport() {
            this.attendences = [];
            try {
                const response = await this.searchForm.post(
                    `/api/reports/teachers-attendance`
                );
                this.attendence_type = this.searchForm.type;
                this.attendances = response.data.attendences;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        }
    },
    computed: {
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
        await this.hasPermisssion("teacher-attendance-report");
    }
};
</script>


<style lang="scss" scoped>
    .text-align-center {
        text-align: center;
    }
</style>
