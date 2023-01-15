<template>
    <div class="row">
        <Loader v-if="loading"/>
        <template v-else>
            <div class="col-sm-6 col-12 col-md-4 col-lg-4 col-xl-3 mb-2">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <span class="text-white avatar hw-50 bg-info">
                                    <icon-users />
                                </span>
                            </div>
                            <div class="col">
                                <div class="fz-20">
                                    {{ $t("students") }}
                                </div>
                                <div class="font-weight-bold fz-20">
                                    {{ overview.total_students }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-12 col-md-4 col-lg-4 col-xl-3 mb-2">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <span class="text-white avatar hw-50 bg-warning">
                                    <icon-event />
                                </span>
                            </div>
                            <div class="col">
                                <div class="fz-20">
                                    {{ $t("events") }}
                                </div>
                                <div class="font-weight-bold fz-20" >
                                    {{ overview.total_events }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-12 col-md-4 col-lg-4 col-xl-3 mb-2">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <span class="bg-danger text-white avatar hw-50">
                                    <icon-wallet />
                                </span>
                            </div>
                            <div class="col">
                                <div class="fz-20">
                                    {{ $t("expense") }}
                                </div>
                                <div class="font-weight-bold fz-20" >
                                    {{ appCurrency(overview.total_expenses) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-12 col-md-4 col-lg-4 col-xl-3 mb-2">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <span class="bg-success text-white avatar hw-50">
                                    <icon-cash />
                                </span>
                            </div>
                            <div class="col">
                                <div class="fz-20">
                                    {{ $t("income") }}
                                </div>
                                <div class="font-weight-bold fz-20">
                                    {{ appCurrency(overview.total_income) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                overview: {
                    total_students: 0,
                    total_events: 0,
                    total_income: 0,
                    total_expenses: 0,
                },
                loading: false
            };
        },
        async created() {
            this.loading = true;
            let response = await axios.get("/api/accountant/dashboard/overview");
            this.overview = response.data;
            this.loading = false;
        },
    };
</script>
