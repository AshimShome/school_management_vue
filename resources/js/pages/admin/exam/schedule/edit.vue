<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("exam_schedule") }}</h2>
                </div>
            </div>
        </div>
        <div class="row row-deck row-cards justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ $t("exam_schedule_edit") }}</h4>
                        <router-link :to="{ name: 'exam-schedule' }" class="btn btn-primary">{{ $t("back") }}
                        </router-link>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-xl-6">
                                <form @submit.prevent="save" autocomplete="off">
                                    <div class="form-group mb-3">
                                        <label for="term_id" class="form-label">{{ $t("exam") }}</label>
                                        <div>
                                            <select id="term_id" v-model="form.exam_id" class="form-control"
                                                :class="{ 'is-invalid': form.errors.has('class_id') }">
                                                <option value="" disabled>
                                                    {{ $t("select_exam") }}
                                                </option>
                                                <option v-for="exam in exams" :key="exam.id" :value="exam.id"
                                                    :selected="exam.id == form.exam_id">
                                                    {{ exam.name }}
                                                </option>
                                            </select>
                                            <has-error :form="form" field="exam_id"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="term_id" class="form-label">{{ $t("class") }}</label>
                                        <div>
                                            <select id="class_id" v-model="form.class_id" class="form-control"
                                                :class="{ 'is-invalid': form.errors.has('class_id') }">
                                                <option value="" disabled>
                                                    {{ $t("select_class") }}
                                                </option>
                                                <option v-for="singleClass in classes" :key="singleClass.id"
                                                    :value="singleClass.id" :selected="singleClass.id == form.class_id">
                                                    {{ singleClass.name }}
                                                </option>
                                            </select>
                                            <has-error :form="form" field="class_id"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="term_id" class="form-label">{{ $t("section") }}</label>
                                        <div>
                                            <select id="class_id" v-model="form.section_id" class="form-control"
                                                :class="{ 'is-invalid': form.errors.has('class_id') }">
                                                <option value="" disabled>
                                                    {{ $t("select_section") }}
                                                </option>
                                                <option v-for="section in sections" :key="section.id"
                                                    :value="section.id" :selected="section.id == form.section_id">
                                                    {{ section.name }}
                                                </option>
                                            </select>
                                            <has-error :form="form" field="class_id"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="term_id" class="form-label">{{ $t("room") }}</label>
                                        <div>
                                            <select id="term_id" v-model="form.room_id" class="form-control"
                                                :class="{ 'is-invalid': form.errors.has('class_id') }">
                                                <option value="" disabled>
                                                    {{ $t("select_room") }}
                                                </option>
                                                <option v-for="room in rooms" :key="room.id" :value="room.id"
                                                    :selected="room.id == form.room_id">
                                                    {{ room.room_no }}
                                                </option>
                                            </select>
                                            <has-error :form="form" field="exam_id"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="term_id" class="form-label">{{ $t("subject") }}</label>
                                        <div>
                                            <select id="subject_id" v-model="form.subject_id" class="form-control"
                                                :class="{ 'is-invalid': form.errors.has('subject_id') }">
                                                <option value="" disabled>
                                                    {{ $t("select_subject") }}
                                                </option>
                                                <option v-for="subject in subjects" :key="subject.id"
                                                    :value="subject.id" :selected="subject.id == form.subject_id">
                                                    {{ subject.name }}
                                                </option>
                                            </select>
                                            <has-error :form="form" field="subject_id"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="term_id" class="form-label">{{ $t("exam_date") }}</label>
                                                <date-picker format="dd MMMM, yyyy" @input="setDate($event)"
                                                    input-class="form-control" :placeholder="$t('select_date')"
                                                    :value="form.exam_date" />
                                                <has-error :form="form" field="exam_date" class="d-block"></has-error>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="term_id" class="form-label">{{ $t("start_time") }}</label>
                                                <vue-timepicker v-model="form.start_time" placeholder="Hour:Minute">
                                                </vue-timepicker>
                                                <has-error :form="form" field="start_time" class="d-block"></has-error>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="term_id" class="form-label">{{ $t("end_time") }}</label>
                                                <vue-timepicker v-model="form.end_time" placeholder="Hour:Minute">
                                                </vue-timepicker>
                                                <has-error :form="form" field="end_time" class="d-block"></has-error>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-footer">
                                        <button :disabled="submitButtonDisabled || form.busy" type="submit"
                                            class="btn btn-primary">
                                            {{ $t("save") }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import dayjs from "dayjs";
import VueTimepicker from "vue2-timepicker";
import { mapGetters } from "vuex";

export default {
    components: {
        VueTimepicker
    },
    watch: {
        "form.class_id"(to, from) {
            this.loadSubjects();
            this.loadSections();
        }
    },
    data() {
        return {
            subjects: [],
            sections: [],

            // Form Data
            form: new Form({
                exam_id: "",
                class_id: "",
                section_id: "",
                room_id: "",
                subject_id: "",
                start_time: "",
                end_time: "",
                exam_date: ""
            })
        };
    },
    methods: {
        setDate(event) {
            const date = dayjs(event).format("YYYY-MM-DD");
            this.form.exam_date = date;
        },
        async loadSubjects() {
            try {
                let response = await axios.get(
                    `/api/classes/${this.form.class_id}/subjects`
                );
                this.subjects = response.data.subjects;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async loadSections() {
            try {
                let response = await axios.get(
                    `/api/classes/${this.form.class_id}/section`
                );
                this.sections = response.data.data;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async save() {
            try {
                const response = await this.form.put(
                    `/api/exam-schedules/${this.$route.params.id}`
                );
                this.redirect("exam-schedule");
                this.toastSuccess(response.data.message);
            } catch (err) {
                this.toastError();
                console.log(err);
            }
        },
        async loadData() {
            let response = await axios.get(
                `/api/exam-schedule/${this.$route.params.id}`
            );
            this.form.fill(response.data.data);
        }
    },
    computed: {
        ...mapGetters({
            exams: "exam/examList",
            classes: "classs/classes",
            rooms: "classs/classrooms"
        }),
        submitButtonDisabled() {
            return (
                this.form.exam_id == "" ||
                this.form.class_id == "" ||
                this.form.section_id == "" ||
                this.form.room_id == "" ||
                this.form.subject_id == "" ||
                this.form.exam_date == "" ||
                this.form.start_time == "" ||
                this.form.end_time == ""
            );
        }
    },
    async created() {
        await this.hasPermisssion("exam-schedule-create");
        await this.$store.dispatch("exam/fetchExamsList");
        await this.$store.dispatch("classs/fetchClasses");
        await this.$store.dispatch("classs/fetchClassrooms");
        this.loadData();
    }
};
</script>

<style scoped>
    @import "vue2-timepicker/dist/VueTimepicker.css";
</style>
