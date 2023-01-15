<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("class_routine") }}</h2>
                </div>
            </div>
        </div>
        <div class="row row-deck row-cards justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ $t("class_routine_edit") }}</h4>
                        <router-link :to="{ name: 'academic-routine' }" class="btn btn-primary">
                            {{ $t("back") }}
                        </router-link>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <form @submit.prevent="save" autocomplete="off">
                                    <div class="form-group mb-3">
                                        <label for="term_id" class="form-label">{{ $t("class") }}</label>
                                        <select id="class_id" v-model="form.class_id" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('class_id') }"
                                            @change="loadSectionSubject">
                                            <option value="" disabled>
                                                {{ $t("select_class") }}
                                            </option>
                                            <option v-for="singleClass in classes" :key="singleClass.id"
                                                :value="singleClass.id">
                                                {{ singleClass.name }}
                                            </option>
                                        </select>
                                        <has-error :form="form" field="class_id"></has-error>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="term_id" class="form-label">{{ $t("section") }}</label>
                                        <select v-model="form.section_id" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('section_id') }">
                                            <option v-if="sections && sections.length" class="d-none" selected value=""
                                                disabled>
                                                {{ $t("select_section") }}
                                            </option>
                                            <option v-else class="d-none" selected value="">
                                                {{ $t("no_section_found") }}
                                            </option>
                                            <template v-if="sections && sections.length">
                                                <option v-for="section in sections" :key="section.id"
                                                    :value="section.id">
                                                    {{ section.name }}
                                                </option>
                                            </template>
                                        </select>
                                        <has-error :form="form" field="section_id"></has-error>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="term_id" class="form-label">{{ $t("subject") }}
                                        </label>
                                        <div>
                                            <select id="subject_id" v-model="form.subject_id" class="form-control"
                                                :class="{ 'is-invalid': form.errors.has('subject_id') }">
                                                <option v-if="subjects && subjects.length" class="d-none" selected
                                                    value="" disabled>
                                                    {{ $t("select_subject") }}
                                                </option>
                                                <option v-else class="d-none" selected value="">
                                                    {{ $t("no_subject_found") }}
                                                </option>
                                                <option v-for="subject in subjects" :key="subject.id"
                                                    :value="subject.id">
                                                    {{ subject.name }}
                                                </option>
                                            </select>
                                            <has-error :form="form" field="subject_id"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="term_id" class="form-label">{{ $t("class_room") }}</label>
                                        <select id="class_room_id" v-model="form.class_room_id" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('class_room_id') }">
                                            <option value="" disabled>
                                                {{ $t("select_class_room") }}
                                            </option>
                                            <option v-for="classroom in classrooms" :key="classroom.id"
                                                :value="classroom.id">
                                                {{ classroom.room_no }}
                                            </option>
                                        </select>
                                        <has-error :form="form" field="class_id"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="teacher_id">{{ $t("teacher") }}</label>
                                        <select id="teacher_id" v-model="form.teacher_id" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('teacher_id') }">
                                            <option value="" disabled>
                                                {{ $t("select_teacher") }}
                                            </option>
                                            <option v-for="teacher in teachers" :key="teacher.id" :value="teacher.id">
                                                {{ teacher.user.name }}
                                            </option>
                                        </select>
                                        <has-error :form="form" field="teacher_id"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="day">{{ $t("day") }}</label>
                                        <select id="day" v-model="form.weekday" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('weekday') }">
                                            <option value="" class="d-none">{{ $t("please_select_day") }}</option>
                                            <option value="1">{{ $t("monday") }}</option>
                                            <option value="2">{{ $t("tuesday") }}</option>
                                            <option value="3">{{ $t("wednesday") }}</option>
                                            <option value="4">{{ $t("thursday") }}</option>
                                            <option value="5">{{ $t("friday") }}</option>
                                            <option value="6">{{ $t("saturday") }}</option>
                                            <option value="7">{{ $t("sunday") }}</option>
                                        </select>
                                        <has-error :form="form" field="weekday"></has-error>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 mb-3">
                                            <label for="term_id" class="form-label">{{ $t("start_time") }}</label>
                                            <vue-timepicker v-model="form.start_time" placeholder="Hour:Minute">
                                            </vue-timepicker>
                                            <has-error :form="form" field="start_time" class="d-block"></has-error>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="term_id" class="form-label">{{ $t("end_time") }}</label>
                                            <vue-timepicker v-model="form.end_time" placeholder="Hour:Minute">
                                            </vue-timepicker>
                                            <has-error :form="form" field="end_time" class="d-block"></has-error>
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
import { mapGetters } from "vuex";
import VueTimepicker from "vue2-timepicker";

export default {
    components: {
        VueTimepicker
    },
    computed: {
        ...mapGetters({
            classes: "classs/classes",
            exams: "exam/examList",
            classrooms: "classs/classrooms"
        }),
        submitButtonDisabled() {
            return (
                this.form.class_id == "" ||
                this.form.exam_id == "" ||
                this.form.subject_id == "" ||
                this.form.attachment == ""
            );
        }
    },
    data() {
        return {
            sections: [],
            subjects: [],
            routines: [],
            teachers: [],

            // Form Data
            form: new Form({
                class_id: "",
                section_id: "",
                class_room_id: "",
                subject_id: "",
                teacher_id: "",
                weekday: "",
                start_time: "",
                end_time: ""
            })
        };
    },
    methods: {
        async loadSectionSubject() {
            await this.loadSections();
            await this.loadSubjects();
        },
        async loadSections() {
            try {
                const response = await axios.get(
                    `/api/classes/${this.form.class_id}/sections`
                );
                this.sections = response.data.sections;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async loadSubjects() {
            try {
                const response = await axios.get(
                    `/api/classes/${this.form.class_id}/subjects`
                );
                this.subjects = response.data.subjects;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async save() {
            try {
                const response = await this.form.put(
                    `/api/update-class-routines/${this.$route.params.id}`
                );
                this.redirect("academic-routine");
                this.toastSuccess(response.data.message);
            } catch (err) {
                console.log(err);
                this.toastError();
            }
        },
        async loadTeachers() {
            let teachers = await axios.get("/api/get-all-teachers");
            this.teachers = teachers.data;
        },
        reset() {
            this.form.reset();
            this.form.clear();
        },
        async loadEditData() {
            let editData = await axios.get(
                `/api/class-routines/${this.$route.params.id}`
            );
            this.form.fill(editData.data);
            await this.loadSectionSubject();
        }
    },
    async created() {
        this.hasPermisssion("routine-edit");
        this.$store.dispatch("classs/fetchClasses");
        await this.$store.dispatch("classs/fetchClassrooms");
        await this.loadTeachers();
        await this.loadEditData();
    }
};
</script>

<style scoped>
    @import "vue2-timepicker/dist/VueTimepicker.css";
</style>
