<template>
    <div class="card">
        <div class="card-header d-flex justify-content-between py-0">
            <h3 class="card-title">{{ $t("attendance") }}</h3>
            <div>
                <select name="earnings" class="form-select my-2" v-model="selectedChild">
                    <option v-for="child in childs" :key="child.id" :value="child.id"
                        :selected="selectedChild == child.id">
                        {{ child.name }}
                    </option>
                </select>
            </div>
        </div>
        <div class="card-body card-body-scrollable card-body-scrollable-shadow">
            <Loader v-if="loading" />
            <template v-else>
                <apexchart class="d-flex justify-content-center" width="370" type="donut" :options="chartOptions" :series="series" />

                <ul class="list-group list-group-horizontal mt-2">
                    <li class="list-group-item">
                        <icon-book stroke="#3498db" />
                        {{ $t("attendance") }} -
                        <span>{{ attendance.total_attendance }}</span>
                    </li>
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
                selectedChild: "",
                loading: false,
            };
        },
        watch: {
            async selectedChild(student_id) {
                if (student_id) {
                    let response = await axios.get(
                        `/api/parent/student/${student_id}/attendance`
                    );
                    this.attendance = response.data;
                    this.series = [
                        response.data.present_percentage,
                        response.data.absent_percentage,
                    ];
                }
            },
        },
        computed: {
            childs() {
                return this.$store.getters["parent/getChilds"];
            },
        },
        async created() {
            this.loading = true;
            await this.$store.dispatch("parent/fetchChilds");
            if (this.childs.length) {
                this.selectedChild = this.childs[0].id;
            }
            this.loading = false;
        },
    };
</script>
