<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col-12">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t('academic') }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-md-3 col-6">
                        <date-picker :value="`${searchForm.year}-${searchForm.month}`" minimum-view="month"
                            maximum-view="year" format="MMMM, yyyy" @input="setYearMonth($event)"
                            input-class="form-control text-center" :placeholder="$t('select_month')" />
                        <has-error :form="searchForm" field="date" class="d-block"></has-error>
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
                <ul class="list-unstyled d-flex">
                    <li class="me-3">
                        <span class="attendance-status bg-success"></span>
                        {{ $t('present') }}
                    </li>
                    <li class="me-3">
                        <span class="attendance-status bg-danger"></span>
                        {{ $t('absent') }}
                    </li>
                    <li>
                        <span class="attendance-status bg-secondary"></span>
                        {{ $t('not_entry') }}
                    </li>
                </ul>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <template v-if="attendances.length">
                            <div class="row" v-for="attendance in attendances" :key="attendance.id">
                                <div class="col-6 col-md-3 col-lg-2 p-1" v-for="day in daysInMonth" :key="day">
                                    <div class="card card-attendance" :class="attendanceStatus(day, attendance)">
                                        <div class="card-body text-center">
                                            <div class="mb-3 card-attendance__date">
                                                <span
                                                    class="avatar avatar-md avatar-rounded text-white">{{ day }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
import weekOfYear from "dayjs/plugin/weekOfYear";
dayjs.extend(weekOfYear);

export default {
    data() {
        return {
            searchForm: new Form({
                month: "",
                year: ""
            }),
            attendances: []
        };
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
    created() {
        if (this.userRole != "Student") {
            this.redirect("401");
        }

        this.searchForm.year = dayjs().year();
        this.searchForm.month = ("0" + (dayjs().month() + 1)).slice(-2);
        this.getAttendanceReport();
    },
    methods: {
        async setYearMonth(event) {
            try {
                const month = dayjs(event).format("MM");
                const year = dayjs(event).format("YYYY");

                this.searchForm.month = month;
                this.searchForm.year = year;

                await this.getAttendanceReport();
            } catch (error) {
                this.toastError(error.response.data.message);
            }
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
        attendanceStatus(day, attendance) {
            const dayStr = day < 10 ? `0${day}` : day;
            const fullDay = `${this.searchForm.year}-${this.searchForm.month}-${dayStr}`;

            if (attendance.attendances.hasOwnProperty(fullDay)) {
                if (attendance.attendances[fullDay][0]["status"] == 1) {
                    return "card-attendance--present";
                }

                return "card-attendance--absent";
            }

            return "card-attendance--holiday";
        },
        async getAttendanceReport() {
            try {
                this.attendances = [];
                const response = await this.searchForm.post(
                    `/api/student/get-attendance`
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
    .attendance-status {
        width: 10px;
        height: 10px;
        border-radius: 3px;
        display: inline-block;
    }

    td {
        padding: 0;
    }

    .card-attendance {
        cursor: pointer;
        height: 140px;

        &:hover {
            .card-attendance {
                &__date {
                    span {
                        transform: scale(1.1);
                    }
                }
            }
        }

        .card-body {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        &__date {
            margin: 0px !important;

            span {
                width: 68px;
                height: 68px;
                transform: scale(1);
                transition: all 0.3s linear;
            }
        }

        &--present {
            background-color: #bfe3aa;

            .card-attendance {
                &__date {
                    span {
                        background-color: #6fc03e;
                    }
                }
            }
        }

        &--absent {
            background-color: #fcd7d7;

            .card-attendance {
                &__date {
                    span {
                        background-color: #d9534f;
                    }
                }
            }
        }

        &--holiday {
            background-color: #ebecec;

            .card-attendance {
                &__date {
                    span {
                        background-color: #9aa1a1;
                    }
                }
            }
        }
    }
</style>
