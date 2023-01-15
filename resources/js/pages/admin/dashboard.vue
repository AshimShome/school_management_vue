<template>
    <div>
        <!-- Overview -->
        <Loader v-if="loading"/>
        <Overview v-else :overview="overview" />

        <div class="row mt-3">
            <!-- Income vs Fees vs Expense Barchart -->
            <div class="col-xl-6 mb-3">
                <IncomeFeesExpenseChart />
            </div>

            <div class="col-xl-6 mb-3">
                <IncomeExpenseChart />
            </div>

            <!-- Students Piechart -->
            <div class="col-xl-6 mb-3">
                <Loader v-if="loading"/>
                <StudentsPieChart v-else :studentsType="studentsTypeChart" />
            </div>

            <!-- Due Table  -->
            <div class="col-xl-6 mb-3">
                <DueTable />
            </div>
        </div>

        <div class="row">
            <!-- Income Expence table  -->
            <IncomeExpenseTable />

            <!-- Calendar Event -->
            <CalendarEvent />
        </div>
    </div>
</template>

<script>
import IncomeFeesExpenseChart from "../../components/admin/dashboard/IncomeFeesExpenseChart.vue";
import StudentsPieChart from "../../components/admin/dashboard/StudentsPieChart.vue";
import AttendenceChart from "../../components/admin/dashboard/AttendenceChart.vue";
import CalendarEvent from "../../components/event/CalendarEvent.vue";
import Overview from "../../components/admin/dashboard/Overview.vue";
import UpcomingExam from "../../components/exam/UpcomingExam.vue";
import IncomeExpenseTable from "../../components/accountant/dashboard/IncomeExpenceTable.vue";
import DueTable from "../../components/accountant/dashboard/DueTable.vue";
import IncomeExpenseChart from "../../components/accountant/dashboard/IncomeExpenseChart.vue";

export default {
    components: {
        IncomeFeesExpenseChart,
        StudentsPieChart,
        AttendenceChart,
        CalendarEvent,
        Overview,
        UpcomingExam,
        DueTable,
        IncomeExpenseTable,
        IncomeExpenseChart
    },
    data() {
        return {
            overview: {},
            studentsTypeChart: {},
            loading: false
        };
    },
    methods: {
        async loadData() {
            let response = await axios.get("/api/dashboard/overview");
            this.studentsTypeChart = response.data.students_type;
            this.overview = response.data.overview;
        }
    },
    async mounted() {
        this.loading = true;
        await this.loadData();
        this.loading = false;
    }
};
</script>

<style scoped>

</style>
