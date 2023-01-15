<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t('academic') }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-sm-2 col-6">
                        <select v-model="searchForm.student_id" class="form-control"
                            :class="{ 'is-invalid': searchForm.errors.has('student_id') }">
                            <option value="" selected class="d-none">{{ $t('select_child') }}</option>
                            <option v-for="child in childs" :key="child.id" :value="child.student_id">
                                {{ child.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="student_id"></has-error>
                    </div>
                    <div class="col-sm-3 col-6">
                        <date-picker minimum-view="month" maximum-view="year" format="MMMM, yyyy"
                            @input="setMonth($event)" input-class="form-control" :placeholder="$t('select_month')"
                            :value="getMonth(searchForm.month, searchForm.year)" />
                        <has-error :form="searchForm" field="date" class="d-block"></has-error>
                    </div>
                    <div class="col-sm-2 mt-3 mt-sm-0">
                        <button :disabled="disableSearchButton" class="btn btn-primary btn-outline"
                            @click.prevent="getAttendanceReport">
                            {{ $t('get_attendance_report') }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 my-3">
                <div class="card bg-secondary text-white">
                    <div class="card-body">
                        <div class="text-center">
                            <h2>{{ $t('attendance_report') }}</h2>
                            <h4>{{ $t('month') }} : {{ getMonthName(searchForm.month) }}</h4>
                            <h5>{{ $t('year') }} : {{ searchForm.year }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ $t('attendance_report') }}</div>
                    </div>
                    <div class="card-body table-responsive">
                        <template v-if="attendances.length">
                            <table class="table table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ $t('photo') }}</th>
                                        <th>{{ $t('name') }}</th>
                                        <th>{{ $t('roll') }}</th>
                                        <th class="text-align-center" v-for="day in daysInMonth" :key="day">
                                            {{ day }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="attendance in attendances" :key="attendance.id">
                                        <td>
                                            <img :src="attendance.user.image_url" alt="image" class="img-fluid attendance-img"
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
import { mapGetters } from "vuex";
export default {
    components: {
        NotFound: () => import("../../components/NotFound.vue")
    },
    data() {
        return {
            searchForm: new Form({
                student_id: "",
                year: "",
                month: ""
            }),
            attendances: []
        };
    },
    computed: {
        ...mapGetters({
            user: "auth/user",
            childs: "parent/getChilds"
        }),
        daysInMonth() {
            return dayjs(
                `${this.searchForm.year}-${this.searchForm.month}`
            ).daysInMonth();
        },
        disableSearchButton() {
            return (
                this.searchForm.student_id == "" ||
                this.searchForm.month == "" ||
                this.searchForm.year == ""
            );
        }
    },
    created() {
        if (this.userRole != "Guardian") {
            this.redirect("401");
        }

        this.$store.dispatch("parent/fetchChilds");
        this.searchForm.year = dayjs().year();
        this.searchForm.student_id = this.childs[0].student_id;
        this.searchForm.month = ("0" + (dayjs().month() + 1)).slice(-2);
        this.getAttendanceReport();
    },
    methods: {
        getMonth(month, year) {
            return dayjs(`${year}-${month}`).format("YYYY-MM");
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
            try {
                this.attendances = [];
                const response = await this.searchForm.post(
                    `/api/parent/student/attendance`
                );
                this.attendances = response.data.attendences;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        getMonthName(month) {
            return dayjs(`${this.searchForm.year}-${month}`).format("MMMM");
        }
    }
};
</script>

<style lang="scss" scoped>
    .text-align-center {
        text-align: center;
    }

    .attendance-img {
        border-radius: 10px;
        max-height: 50px;
        max-width: 50px;
    }
</style>
