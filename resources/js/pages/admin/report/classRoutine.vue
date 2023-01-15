<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("report") }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex"></div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-md-3 col-xl-2">
                        <select v-model="searchForm.session_id" class="form-control">
                            <option value="" class="d-none">
                                {{ $t("select_session") }}
                            </option>
                            <option v-for="session in sessions" :key="session.id" :value="session.id">
                                {{ session.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3 col-xl-2" v-if="searchForm.session_id">
                        <select v-model="searchForm.class_id" class="form-control" @change="loadSerachFormSections">
                            <option value="" class="d-none">{{ $t("select_class") }}</option>
                            <option v-for="singleClass in classes" :key="singleClass.id" :value="singleClass.id">
                                {{ singleClass.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3 col-xl-2" v-if="searchForm.session_id && searchForm.class_id">
                        <select v-model="searchForm.section_id" class="form-control">
                            <option value="" disabled>
                                {{ $t("select_section") }}
                            </option>
                            <option v-for="section in sections" :key="section.id" :value="section.id">
                                {{ section.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3 col-xl-2" v-if="searchForm.session_id && searchForm.class_id && searchForm.section_id">
                        <button :disabled="searchButtonDisabled" @click="getRoutines"
                            class="btn btn-primary btn-outline">
                            {{ $t("get_class_routine") }}
                        </button>
                    </div>
                </div>
            </div>
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
import ClassRoutine from "../../../components/academic/ClassRoutine.vue";
import NotFound from "../../../components/NotFound.vue";
import ButtonLoading from "../../../components/ButtonLoading.vue";
import { mapGetters } from "vuex";
export default {
    components: {
        ClassRoutine,
        NotFound,
        ButtonLoading
    },
    computed: {
        ...mapGetters({
            sessions: "session/sessions",
            classes: "classs/classes"
        }),
        searchButtonDisabled() {
            return (
                this.searchForm.session_id == "" ||
                this.searchForm.class_id == "" ||
                this.searchForm.section_id == ""
            );
        }
    },
    watch: {
        "form.class_id"(to, from) {
            this.loadSections();
        }
    },
    data() {
        return {
            showRoutine: false,
            weekDays: [],
            calendarData: [],

            searchForm: new Form({
                session_id: "",
                class_id: "",
                section_id: ""
            }),
            sections: []
        };
    },
    methods: {
        async getRoutines() {
            try {
                const response = await axios.post(
                    `/api/reports/get-class-routines`,
                    this.searchForm
                );

                this.showRoutine = true;
                this.weekDays = response.data.weekDays;
                this.calendarData = response.data.calendarData;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error.response);
            }
        },
        async loadSerachFormSections() {
            try {
                const response = await axios.get(
                    `/api/classes/${this.searchForm.class_id}/sections`
                );
                this.sections = response.data.sections;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        }
    },
    async created() {
        await this.hasPermisssion("class-routine-report");
        this.$store.dispatch("session/fetchSessions");
        this.$store.dispatch("classs/fetchClasses");
        let current_session = await axios.get("/api/get-current-session");
        let session = this.sessions.find(
            session => session.id == current_session.data.id
        );
        this.searchForm.session_id = session.id;
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
