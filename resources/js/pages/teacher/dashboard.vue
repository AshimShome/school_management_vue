<template>
    <div>
        <!-- Overview -->
        <Loader v-if="loading" />
        <Overview :overview="overview" v-else />

        <div class="row mt-3">
            <!-- Routine -->
            <Routine />

            <!-- Attendance Chart -->
            <AttendanceChart />

            <!-- Students Piechart -->
            <div class="col-md-6 mt-3">
                <Loader v-if="loading" />
                <StudentsPieChart :studentsType="studentsTypeChart" v-else />
            </div>

            <!-- Upcoming Exams -->
            <div class="col-xl-6 col-lg-12 mt-3">
                <UpcomingExam />
            </div>
        </div>

        <!-- Calendar Event -->
        <CalendatEvent />
    </div>
</template>

<style scoped>
.header {
    position: sticky;
    top: 0;
}
</style>

<script>
import VueApexCharts from "vue-apexcharts";
import CalendatEvent from "../../components/event/CalendarEvent.vue";
import Overview from "../../components/teacher/dashboard/Overview.vue";
import Routine from "../../components/teacher/dashboard/Routine.vue";
import AttendanceChart from "../../components/teacher/dashboard/AttendanceChart.vue";
import StudentsPieChart from "../../components/admin/dashboard/StudentsPieChart.vue";
import UpcomingExam from "../../components/exam/UpcomingExam.vue";

export default {
    components: {
        apexchart: VueApexCharts,
        CalendatEvent,
        Overview,
        Routine,
        AttendanceChart,
        StudentsPieChart,
        UpcomingExam
    },
    data() {
        return {
            loading: false,
            studentsTypeChart: {},
            overview: {},

            series: [40, 60],
            chartOptions: {
                chart: {
                    width: 380,
                    type: "pie"
                },
                colors: ["#2A8737", "#F23D4E"],
                labels: ["Male", "Female"],
                responsive: [
                    {
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: "bottom"
                            }
                        }
                    }
                ]
            }
        };
    },
    methods: {
        async loadData() {
            let response = await axios.get("/api/teacher/dashboard/overview");
            this.studentsTypeChart = response.data.students_type;
            this.overview = response.data.overview;
        }
    },
    async created() {
        this.loading = true;
        await this.loadData();
        this.loading = false;
    }
};
</script>
