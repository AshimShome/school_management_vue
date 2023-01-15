<template>
    <div>
        <!-- Overview -->
        <Overview/>

        <!-- Income vs Expense chart -->
        <div class="row mt-3">
            <div class="col-xl-8 mb-3">
                <IncomeExpenseYearlyChart/>
            </div>
            <div class="col-xl-4">
                <IncomeExpenseChart/>
            </div>
        </div>

        <div class="row mt-3">
            <!-- Due Table  -->
            <DueTable />

            <!-- Income Expence table  -->
            <IncomeExpenseTable />
        </div>

        <!-- Calendar Event -->
        <CalendarEvent />
    </div>
</template>

<style scoped>
    .header {
        position: sticky;
        top: 0;
    }
</style>

<script>
    import CalendarEvent from "../../components/event/CalendarEvent.vue";
    import VueApexCharts from "vue-apexcharts";
    import IncomeExpenseTable from '../../components/accountant/dashboard/IncomeExpenceTable.vue';
    import DueTable from '../../components/accountant/dashboard/DueTable.vue';
    import IncomeExpenseYearlyChart from "../../components/accountant/dashboard/IncomeExpenseYearlyChart.vue";
    import IncomeExpenseChart from "../../components/accountant/dashboard/IncomeExpenseChart.vue";
    import Overview from "../../components/accountant/dashboard/Overview.vue";

    export default {
        components: {
            CalendarEvent,
            apexcharts: VueApexCharts,
            DueTable,
            IncomeExpenseTable,
            IncomeExpenseYearlyChart,
            IncomeExpenseChart,
            Overview
        }
    };
</script>
