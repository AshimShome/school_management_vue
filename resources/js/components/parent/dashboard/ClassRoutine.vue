<template>
    <div class="row my-3 mx-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between py-0">
                <h3>{{ $t("class_routine") }}</h3>
                <div>
                    <select name="earnings" class="form-select my-2" v-model="selectedChild">
                        <option v-for="child in childs" :key="child.id" :value="child.student_id"
                            :selected="selectedChild == child.student_id">
                            {{ child.name }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="card-body table-responsive">
                <Loader v-if="loading" />
                <template v-else>
                    <ClassRoutine :calendarData="calendarData" :weekDays="weekDays" v-if="showRoutine && calendarData && weekDays"/>
                    <div v-else class="d-flex justify-content-center py-3">
                        <NotFound word="class routine" />
                    </div>
                </template>
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
                selectedChild: "",
                loading: false,
            };
        },
        watch: {
            async selectedChild(student_id) {
                if (student_id) {
                    let response = await axios.get(
                        `/api/parent/student/${student_id}/routine`
                    );

                    this.showRoutine = true;
                    this.weekDays = response.data.weekDays;
                    this.calendarData = response.data.calendarData;
                }
            }
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
                this.selectedChild = this.childs[0].student_id;
            }
            this.loading = false;
        },
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
