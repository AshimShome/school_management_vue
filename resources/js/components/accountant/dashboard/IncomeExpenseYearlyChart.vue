<template>
    <div class="card">
        <div class="card-header">
            <h3>{{ $t("yearly_income_expense_chart") }}</h3>
        </div>
        <div class="card-body">
            <Loader v-if="loading"/>
            <apexcharts height="350" type="bar" :options="chartOptions" :series="series" v-else/>
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
        data: function () {
            return {
                loading: false,
                chartOptions: {
                    dataLabels: {
                        enabled: false,
                    },
                    colors: ["#32a852", "#f7d216"],
                    xaxis: {
                        categories: [
                            "January",
                            "February",
                            "March",
                            "April",
                            "May",
                            "June",
                            "July",
                            "August",
                            "September",
                            "October",
                            "November",
                            "December",
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
        async created() {
            this.loading = true;
            await this.loadData()
            this.loading = false;
        },
        async created() {
            this.loading = true;
            await this.loadData()
            this.loading = false;
        }
    };
</script>
