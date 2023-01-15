<template>
    <div class="col-md-6 mt-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $t("my_attendance") }}</h3>
            </div>
            <div class="card-body card-body-scrollable card-body-scrollable-shadow">
                <Loader v-if="loading"/>
                <template v-else>
                    <apexchart class="d-flex justify-content-center" width="370" type="donut" :options="chartOptions" :series="series"/>

                    <ul class="list-group list-group-horizontal mt-2">
                        <li class="list-group-item">
                            <icon-check stroke="#2A8737" />
                            {{ $t("present") }} - <span>{{ attendance.total_present }}</span>
                        </li>
                        <li class="list-group-item">
                            <icon-cross stroke="#F23D4E" />
                            {{ $t("absent") }} - <span>{{ attendance.total_absent }}</span>
                        </li>
                    </ul>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    import VueApexCharts from "vue-apexcharts";

    export default {
        components: {
            apexchart: VueApexCharts,
        },
        data() {
            return {
                series: [80, 20],
                chartOptions: {
                    chart: {
                        width: 380,
                        type: "pie",
                    },
                    colors: ["#2A8737", "#F23D4E"],
                    labels: ["Present", "Absent"],
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
                attendance: "",
                loading: false,
            };
        },
        methods:{
            async loadData(){
                let response = await axios.get("/api/teacher/attendance-chart");
                this.attendance = response.data;
                this.series = [
                    response.data.present_percentage,
                    response.data.absent_percentage,
                ];
            }
        },
        async mounted() {
            this.loading = true;
            await this.loadData()
            this.loading = false;
        },
    };
</script>
