<template>
    <div class="card">
        <div class="card-header">
            <h3>{{ $t("students") }}</h3>
        </div>
        <div class="card-body card-body-scrollable card-body-scrollable-shadow">
            <apexcharts class="d-flex justify-content-center" width="370" type="donut" :options="chartOptions" :series="series"></apexcharts>

            <ul class="list-group list-group-horizontal mt-2">
                <li class="list-group-item">
                    <icon-male stroke="#3498db" />
                    {{ $t("male") }} - <span>{{ studentsType.male_student }}</span>
                </li>
                <li class="list-group-item">
                    <icon-female stroke="#8e44ad" />
                    {{ $t("female") }} - <span>{{ studentsType.female_student }}</span>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import VueApexCharts from "vue-apexcharts";

    export default {
        components: {
            apexcharts: VueApexCharts,
        },
        props: {
            studentsType: {
                type: Object,
            },
        },
        // watch: {
        //     studentsType: {
        //         handler() {
        //             setTimeout(() => {
        //                 this.series = [
        //                     this.studentsType.male_student_percentage,
        //                     this.studentsType.female_student_percentage,
        //                 ];
        //             }, 500);
        //         },
        //     },
        // },
        created(){
            this.series = [
                this.studentsType.male_student_percentage,
                this.studentsType.female_student_percentage,
            ];
        },
        data() {
            return {
                series: [40, 60],
                chartOptions: {
                    chart: {
                        width: 380,
                        type: "pie",
                    },
                    colors: ["#3498db", "#8e44ad"],
                    labels: ["Male", "Female"],
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
            };
        }
    };
</script>
