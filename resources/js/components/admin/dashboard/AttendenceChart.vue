<template>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3>{{ $t("todays_attendance") }}</h3>
            <ul class="navbar-nav mt--5">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ $t("student") }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">{{ $t("student") }}</a>
                        <a class="dropdown-item" href="#">{{ $t("teacher") }}</a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="card-body card-body-scrollable card-body-scrollable-shadow mx-auto">
            <apexcharts width="370" type="donut" :options="chartOptions" :series="series"></apexcharts>
        </div>
    </div>
</template>

<style scoped>
.mt--5 {
    margin-top: -0.5rem
}
</style>

<script>
    import VueApexCharts from "vue-apexcharts";

    export default {
        components: {
            apexcharts: VueApexCharts,
        },
        data() {
            return {
                series: [40, 60],
                chartOptions: {
                    chart: {
                        width: 380,
                        type: "pie",
                    },
                    colors: ["#00c230", "#f71616"],
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
            };
        },
    };
</script>
