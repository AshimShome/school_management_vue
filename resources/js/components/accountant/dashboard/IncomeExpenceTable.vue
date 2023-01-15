<template>
    <div class="col-sm-12 mt-3">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ $t("recent_income") }}</h3>
                    </div>
                    <div class="card-body table-responsive p-0 income-expense-table">
                        <Loader v-if="loading"/>
                        <template v-else>
                            <table class="table text-nowrap" v-if="incomes">
                                <thead class="header sticky-top">
                                    <tr>
                                        <th>{{ $t("income") }}</th>
                                        <th>{{ $t("method") }}</th>
                                        <th>{{ $t("amount") }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(income, index) in incomes" :key="index">
                                        <td>{{ income.income_type }}</td>
                                        <td>{{ income.payment_type }}</td>
                                        <td>{{ appCurrency(income.amount) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-center my-5" v-else>
                                <h3>{{ $t("nothing_found") }}</h3>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ $t("recent_expense") }}</h3>
                    </div>
                    <div class="card-body table-responsive p-0 income-expense-table">
                        <Loader v-if="loading"/>
                        <template v-else>
                            <table class="table text-nowrap" v-if="expenses">
                                <thead class="header sticky-top">
                                    <tr>
                                        <th>{{ $t("expense") }}</th>
                                        <th>{{ $t("amount") }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(expense, index) in expenses" :key="index">
                                        <td>{{ expense.expense_type }}</td>
                                        <td>{{ appCurrency(expense.amount) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-center my-5" v-else>
                                <h3>{{ $t("nothing_found") }}</h3>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                overview: {},
                incomes: [],
                expenses: [],
                loading: false
            };
        },
        methods:{
            async loadData(){
                let overview = await axios.get("/api/accountant/dashboard/overview");
                let income_expense = await axios.get("/api/accountant/dashboard/income-expense");
                this.overview = overview.data;
                this.incomes = income_expense.data.incomes;
                this.expenses = income_expense.data.expenses;
            }
        },
        async created() {
            this.loading = true;
            await this.loadData()
            this.loading = false;
        },
    };
</script>

<style scoped>
.income-expense-table{
    height: 250px
}
</style>
