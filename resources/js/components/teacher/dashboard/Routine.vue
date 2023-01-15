<template>
    <div class=" justify-content-center">
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $t("routine") }}</h3>
                </div>
                <div class="card-body card-body-scrollable p-0">
                    <Loader v-if="loading" />
                    <template v-else>
                        <ClassRoutine
                            :calendarData="calendarData"
                            :weekDays="weekDays"
                            v-if="showRoutine && calendarData && weekDays"
                        />
                        <div v-else class="d-flex justify-content-center py-3">
                            <NotFound word="routine" />
                        </div>
                    </template>
                </div>
            </div>
        </div>
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
    async created() {
        this.loading = true;
        let response = await axios.get("/api/teacher/get-routines");
        this.showRoutine = true;
        this.weekDays = response.data.weekDays;
        this.calendarData = response.data.calendarData;
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
