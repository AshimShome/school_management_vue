<template>
    <div class="row">
        <Loader v-if="loading"/>
       <template v-else>
            <div class="col-sm-6 col-12 col-md-4 col-lg-4 col-xl-3 mb-2">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <span class="bg-danger text-white avatar hw-50">
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
                                <span class="bg-info text-white avatar hw-50">
                                    <icon-edit-circle />
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
                                <span class="text-white avatar hw-50 bg-primary">
                                    <icon-bell />
                                </span>
                            </div>
                            <div class="col">
                                <div class="fz-20">{{ $t("subjects") }}</div>
                                <div class="font-weight-bold fz-20">
                                    {{ overview.total_subject }}
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
                                <span class="bg-warning text-white avatar hw-50">
                                    <icon-event />
                                </span>
                            </div>
                            <div class="col">
                                <div class="fz-20">{{ $t("events") }}</div>
                                <div class="font-weight-bold fz-20" >
                                    {{ overview.total_event }}
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
                    total_attendance: 0,
                    total_exam: 0,
                    total_event: 0,
                },
                loading: false,
            };
        },
        async created() {
            this.loading = true;
            let response = await axios.get("/api/student/dashboard/overview");
            this.overview = response.data;
            this.loading = false;
        },
    };
</script>
