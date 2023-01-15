<template>
    <div class="row">
        <div class="col-sm-6 col-12 col-md-4 col-lg-4 col-xl-3 mb-2">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-auto">
                            <span class="text-white avatar bg-info hw-50">
                                <icon-divide />
                            </span>
                        </div>
                        <div class="col">
                            <div class="fz-20">{{ $t("attendance") }}</div>
                            <div class="font-weight-bold fz-20">
                                {{ overview.total_attendance }}
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
                            <span class="text-white avatar bg-success hw-50">
                                <icon-users />
                            </span>
                        </div>
                        <div class="col">
                            <div class="fz-20">{{ $t("students") }}</div>
                            <div class="font-weight-bold fz-20" >
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
                            <span class="text-white avatar bg-warning hw-50">
                                <icon-pen-paper />
                            </span>
                        </div>
                        <div class="col">
                            <div class="fz-20">{{ $t("exams") }}</div>
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
                            <span class="bg-success text-white avatar hw-50">
                                <icon-event />
                            </span>
                        </div>
                        <div class="col">
                            <div class="fz-20">{{ $t("events") }}</div>
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
        },
    };
</script>
