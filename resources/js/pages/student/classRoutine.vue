<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t('academic') }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 mt-3" v-if="showRoutine && calendarData && weekDays">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3>{{ $t("class_routine") }}</h3>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <ClassRoutine :calendarData="calendarData" :weekDays="weekDays"/>
                    </div>
                </div>
            </div>
            <div v-else class="d-flex justify-content-center py-3">
                <NotFound word="class routine" />
            </div>
        </div>
    </div>
</template>

<script>
import ClassRoutine from "../../components/academic/ClassRoutine.vue";

export default {
    components: {
        ClassRoutine
    },
    data() {
        return {
            showRoutine: false,
            weekDays: [],
            calendarData: []
        };
    },
    methods: {
        async getRoutines() {
            try {
                const response = await axios.get(
                    `/api/student/get-class-routines`
                );

                this.showRoutine = true;
                this.weekDays = response.data.weekDays;
                this.calendarData = response.data.calendarData;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        }
    },
    created() {
        if (this.userRole != "Student") {
            this.redirect("401");
        }
        this.getRoutines();
    }
};
</script>

<style lang="scss" scoped>
    td {
        padding: 0;
    }

    tr td:first-of-type {
        padding: .5rem;
        text-transform: capitalize;
    }
</style>
