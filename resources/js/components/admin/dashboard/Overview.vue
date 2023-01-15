<template>
    <div class="row">
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
                                {{ overview.total_student }}
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
                            <span class="bg-indigo text-white avatar hw-50 bg-primary">
                                <icon-users />
                            </span>
                        </div>
                        <div class="col">
                            <div class="fz-20">
                                {{ $t("teachers") }}
                            </div>
                            <div class="font-weight-bold fz-20">
                                {{ overview.total_teacher }}
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
                            <span class="bg-cyan text-white avatar hw-50 bg-info">
                                <icon-users />
                            </span>
                        </div>
                        <div class="col">
                            <div class="fz-20">
                                {{ $t("staff") }}
                            </div>
                            <div class="font-weight-bold fz-20">
                                {{ overview.total_staff }}
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
                            <span class="bg-secondary text-white avatar hw-50">
                                <icon-users />
                            </span>
                        </div>
                        <div class="col">
                            <div class="fz-20">
                                {{ $t("parents") }}
                            </div>
                            <div class="font-weight-bold fz-20">
                                {{ overview.total_parent }}
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
                            <div class="font-weight-bold fz-20">
                                {{ appCurrency(overview.total_expense) }}
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
                            <span class="bg-yellow text-white avatar hw-50 bg-warning">
                                <icon-pen-paper />
                            </span>
                        </div>
                        <div class="col">
                            <div class="fz-20">
                                {{ $t("exams") }}
                            </div>
                            <div class="font-weight-bold fz-20">
                                {{ overview.total_exam }}
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
                            <span class="bg-primary text-white avatar hw-50">
                                <icon-event />
                            </span>
                        </div>
                        <div class="col">
                            <div class="fz-20">
                                {{ $t("events") }}
                            </div>
                            <div class="font-weight-bold fz-20">
                                {{ overview.total_event }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            overview: {
                type: Object,
                required: true,
            },
        }
    };
</script>
