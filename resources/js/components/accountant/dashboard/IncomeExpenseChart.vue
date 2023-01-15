<template>
    <div class="card">
        <div class="card-header d-flex justify-content-between py-0">
            <h3>{{ $t("comparison_chart") }}</h3>
            <div>
                <select name="earnings" class="form-select my-2" v-model="filter">
                    <option value="today">
                        {{ $t("today") }}
                    </option>
                    <option value="yesterday">
                        {{ $t("yesterday") }}
                    </option>
                    <option value="this_week">
                        {{ $t("this_week") }}
                    </option>
                    <option value="last_week">
                        {{ $t("last_week") }}
                    </option>
                    <option value="this_month">
                        {{ $t("this_month") }}
                    </option>
                    <option value="last_month">
                        {{ $t("last_month") }}
                    </option>
                    <option value="last_6_month">
                        {{ $t("last_6_month") }}
                    </option>
                    <option value="this_year">
                        {{ $t("this_year") }}
                    </option>
                    <option value="last_year">
                        {{ $t("last_year") }}
                    </option>
                </select>
            </div>
        </div>
        <div class="card-body card-body-scrollable card-body-scrollable-shadow m-auto">
            <Loader v-if="loading"/>
            <template v-else>
                <apexcharts class="d-flex justify-content-center" type="pie" width="380" :options="income_expense_chart_options" :series="income_expence_series"/>

                <ul class="list-group list-group-horizontal mt-2">
                    <li class="list-group-item">
                        <icon-book stroke="#3498db" />
                        {{ $t("income") }} - <span>{{ appCurrency(total_income) }}</span>
                    </li>
                    <li class="list-group-item">
                        <icon-check stroke="#d63939" />
                        {{ $t("expense") }} - <span>{{ appCurrency(total_expense) }}</span>
                    </li>
                </ul>
            </template>
        </div>
    </div>
</template>


<script>
    import VueApexCharts from "vue-apexcharts";

    export default {
        components: {
            apexcharts: VueApexCharts,
        },
        data: function () {
            return {
                loading: false,
                income_expence_series: [50, 50],
                income_expense_chart_options: {
                    chart: {
                        width: 380,
                        type: "pie",
                    },
                    colors: ["#3498db", "#d63939"],
                    labels: ["Income", "Expense"],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200,
                            },
                            legend: {
                                position: "bottom",
                            },
                        },
                    }, ],
                },

                total_income: 0,
                total_expense: 0,
                filter: "today",
                loading: false
            };
        },
        watch: {
            filter() {
                this.loadData();
            },
        },
        methods: {
            async loadData() {
                let response = await axios.get(
                    "/api/accountant/dashboard/accounting-overview", {
                        params: {
                            filter: this.filter,
                        },
                    }
                );

                this.income_expence_series = [
                    response.data.income_percentage,
                    response.data.expense_percentage,
                ];
                this.total_income = response.data.total_income;
                this.total_expense = response.data.total_expense;
            },
        },
        async created() {
            this.loading = true
            await this.loadData()
            this.loading = false
        },
    };
</script>

<style scoped>
    @media (max-width: 375px) {
        .card-header select{
            font-size: 10px;
            padding: 0px 10px;
        }
        .card-header h3 {
            font-size: 14px;
        }
    }
</style>
