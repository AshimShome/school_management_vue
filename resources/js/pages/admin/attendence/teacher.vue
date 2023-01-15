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
                    <div class="col-sm-12 col-md-3 col-lg-2" v-if="searchForm.date">
                        <button :disabled="!searchBtn" @click="getTeachers" class="btn btn-primary btn-outline">
                            {{ $t("get_teacher_list") }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3" v-if="teachers && teachers.length">
                <form @submit.prevent="saveAttendance">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">{{ $t("attendance") }}</div>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th>{{ $t("image") }}</th>
                                        <th>{{ $t("name") }}</th>
                                        <th>{{ $t("attendance") }}</th>
                                        <th>{{ $t("previous_7_days_status") }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(teacher, index) in teachers" :key="teacher.id">
                                        <td>
                                            <img :src="teacher.user.image_url" alt="" class="img-fluid mx-h-50 mx-w-50 rounded" height="50px"
                                                width="50px"/>
                                        </td>
                                        <td>
                                            {{ teacher.user.name }}
                                        </td>
                                        <td>
                                            <label class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" :value="true"
                                                    v-model="attendance_form[index]" checked />
                                                <span class="form-check-label">{{
                        $t("present")
                    }}</span>
                                            </label>
                                            <label class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" :value="false"
                                                    v-model="attendance_form[index]" />
                                                <span class="form-check-label">{{
                        $t("absent")
                    }}</span>
                                            </label>
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
                <NotFound word="teacher" />
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
                date: ""
            }),

            searchBtn: false,
            teachers: [],
            last_days_attendaces: [],
            attendance_form: [],
            attendance_errors: [],
            attendance_load: false,

            url: "/images/default.png"
        };
    },
    watch: {
        "searchForm.date": function(value) {
            this.searchBtn = true;
        }
    },
    methods: {
        setDate(event) {
            const formatTime = dayjs(event).format("YYYY-MM-DD");
            this.searchForm.date = formatTime;
        },
        async getTeachers() {
            try {
                this.teachers = [];
                this.attendance_form = [];
                this.attendance_errors = [];
                this.attendance_load = false;

                const response = await axios.post(
                    `/api/attendance/get-teachers`,
                    {
                        date: this.searchForm.date
                    }
                );

                this.teachers = response.data.teachers;
                this.last_days_attendaces = response.data.lastdays_attendace;
                this.generateAttendance();
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async saveAttendance() {
            try {
                const data = this.teachers.map((teacher, index) => {
                    return {
                        teacher_id: teacher.id,
                        status: this.attendance_form[index],
                        date: this.searchForm.date
                    };
                });

                const response = await axios.post(`/api/attendance/teachers`, {
                    teacher_data: data
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
        generateAttendance() {
            this.teachers.forEach((teacher, index) => {
                this.attendance_form[index] = teacher.attendances.status;
            });
            this.attendance_load = true;
        }
    },
    created() {
        this.hasPermisssion("teacher-attendance-list");
        this.searchForm.date = dayjs().format("YYYY-MM-DD");
        this.getTeachers();
    }
};
</script>
