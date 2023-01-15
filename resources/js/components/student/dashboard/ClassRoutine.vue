<template>
    <div class="row justify-content-center">
        <Loader v-if="loading"/>
        <template v-else>
            <div class="col-12 my-3" v-if="showRoutine && calendarData && weekDays">
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
        </template>
    </div>
</template>

<script>
import ClassRoutine from "../../academic/ClassRoutine.vue";

export default {
    components: {
        ClassRoutine
    },
    data() {
        return {
            showRoutine: false,
            weekDays: [],
            calendarData: [],
            loading: false
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
    async created() {
        this.loading = true;
        await this.getRoutines();
        this.loading = false;
    }
};
</script>

<style lang="scss" scoped>
    td {
        padding: 0;
    }

    tr td:first-of-type {
        padding: 0.5rem;
        text-transform: capitalize;
    }
</style>
