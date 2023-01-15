<template>
    <div class="card">
        <div class="card-header">
            <h3>{{ $t("income_vs_expense_chart") }}</h3>
        </div>
        <div class="card-body">
            <Loader v-if="loading"/>
            <apexcharts v-else height="350" type="bar" :options="chartOptions" :series="series"/>
        </div>
    </div>
</template>

<script>
    import VueApexCharts from "vue-apexcharts";
    import Loader from "../../Loader.vue";

    export default {
        components: {
            apexcharts: VueApexCharts,Loader
        },
        data() {
            return {
                loading: false,
                chartOptions: {
                    colors: ["#32a852", "#f7d216"],
                    labels: ["Income", "Expense"],
                    dataLabels: {
                        enabled: false,
                    },
                    xaxis: {
                        categories: [
                            "Jan",
                            "Feb",
                            "Mar",
                            "Apr",
                            "May",
                            "Jun",
                            "Jul",
                            "Aug",
                            "Sep",
                            "Oct",
                            "Nov",
                            "Dec",
                        ],
                    },
                },
                series: [{
                        name: "Income",
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    },
                    {
                        name: "Expense",
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    },
                ],
            };
        },
        methods:{
            async loadData(){
                let response = await axios.get("/api/dashboard/income-expense-chart");
                this.series[0].data = response.data.income;
                this.series[1].data = response.data.expense;
            }
        },
        async mounted() {
            this.loading = true;
            await this.loadData()
            this.loading = false;
        }
    }
</script>
