<template>
    <div class="modal modal-blur fade show modal-hidee" id="modal-danger"
        tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content" v-on-clickaway="reset">
                <button @click="reset" type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{
              isEditMode
                ? $t("update_exam_schedule")
                : $t("create_exam_schedule")
            }}
                    </h5>
                    <button @click="toggleModalShow" type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form @submit.prevent="save" autocomplete="off">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group row">
                                <label class="form-label col-md-4" for="name">{{
                  $t("name")
                }}</label>
                                <div class="col-md-8">
                                    <base-input :form="form" field="name" v-model="form.name"></base-input>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-md-4" for="exam_id">{{
                  $t("exam")
                }}</label>
                                <div class="col-md-8">
                                    <base-select :form="form" field="exam_id" v-model.number="form.exam_id"
                                        @change="loadClassRooms">
                                        <option disabled selected>{{ $t("select_exam") }}</option>
                                        <option v-for="exam in exams" :key="exam.id" :value="exam.id"
                                            :selected="form.exam_id == exam.id">
                                            {{ exam.name }}
                                        </option>
                                    </base-select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="form-label col-md-4" for="room_id">{{
                  $t("room")
                }}</label>
                                <div class="col-md-8">
                                    <base-select :form="form" field="room_id" v-model.number="form.room_id"
                                        @change="loadClasses">
                                        <option disabled selected>{{ $t("select_room") }}</option>
                                        <option v-for="room in classrooms" :key="room.id" :value="room.id"
                                            :selected="form.room_id == room.id">
                                            {{ room.room_no }}
                                        </option>
                                    </base-select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-md-4" for="class_id">{{
                  $t("class")
                }}</label>
                                <div class="col-md-8">
                                    <base-select :form="form" field="class_id" v-model.number="form.class_id"
                                        @change="loadSections">
                                        <option disabled selected>{{ $t("select_class") }}</option>
                                        <option v-for="singleClass in classs" :key="singleClass.id"
                                            :value="singleClass.id" :selected="form.class_id == singleClass.id">
                                            {{ singleClass.name }}
                                        </option>
                                    </base-select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="form-label col-md-4" for="section_id">{{
                  $t("section")
                }}</label>
                                <div class="col-md-8">
                                    <base-select :form="form" field="section_id" v-model.number="form.section_id"
                                        @change="loadSubjects">
                                        <option disabled selected>
                                            {{ $t("select_section") }}
                                        </option>
                                        <option v-for="section in class_sections" :key="section.id" :value="section.id"
                                            :selected="form.section_id == section.id">
                                            {{ section.name }}
                                        </option>
                                    </base-select>
                                    <has-error :form="form" field="section_id"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-md-4" for="subject_id">{{
                  $t("subject")
                }}</label>
                                <div class="col-md-8">
                                    <base-select :form="form" field="subject_id" v-model.number="form.subject_id">
                                        <option disabled selected>
                                            {{ $t("select_subject") }}
                                        </option>
                                        <option v-for="subject in class_subjects" :key="subject.id" :value="subject.id"
                                            :selected="form.subject_id == subject.id">
                                            {{ subject.name }}
                                        </option>
                                    </base-select>
                                    <has-error :form="form" field="subject_id"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-md-4" for="start_time">{{
                  $t("start_time")
                }}</label>
                                <div class="col-md-8">
                                    <base-input :form="form" field="start_time" v-model="form.start_time"
                                        inputType="text"></base-input>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-md-4" for="end_time">{{
                  $t("end_time")
                }}</label>
                                <div class="col-md-8">
                                    <base-input :form="form" field="end_time" v-model="form.end_time" inputType="text">
                                    </base-input>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <base-button :loading="form.busy" :disabled="disableSaveButton">{{
              $t("save")
            }}</base-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { mixin as clickaway } from "vue-clickaway";
import { mapGetters } from "vuex";
export default {
    mixins: [clickaway],
    props: {
        isEditMode: {
            type: Boolean,
            default: false
        },
        schedule: {
            type: Object,
            required: false
        }
    },
    data() {
        return {
            form: new Form({
                name: "",
                session_id: "",
                exam_id: "",
                room_id: "",
                class_id: "",
                subject_id: "",
                section_id: "",
                exam_date: "",
                start_time: "",
                end_time: "",
                note: ""
            }),

            exams: [],
            classrooms: [],
            classs: [],
            class_subjects: [],
            class_sections: []
        };
    },
    computed: {
        ...mapGetters({
            sessions: "session/sessions"
        }),
        disableSaveButton() {
            return (
                this.form.name == "" ||
                this.form.exam_id == "" ||
                this.form.room_id == "" ||
                this.form.class_id == "" ||
                this.form.subjects == "" ||
                this.form.section_id == "" ||
                this.form.exam_date == "" ||
                this.form.start_time == "" ||
                this.form.end_time == ""
            );
        }
    },
    created() {
        if (this.isEditMode) {
            Object.keys(this.form).forEach(k => {
                if (this.schedule.hasOwnProperty(k)) {
                    this.form[k] = this.schedule[k];
                }
            });
        }
    },
    methods: {
        reset() {
            this.$emit("close-modal");
        },
        toggleModalShow() {
            this.$emit("close-modal");
        },
        async loadExamBySession() {
            try {
                const response = await axios.post("/api/exams-by-session", {
                    session_id: this.form.session_id
                });
                this.exams = response.data.data;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async loadClassRooms() {
            try {
                const response = await axios.get("/api/classrooms");
                this.classrooms = response.data.classrooms;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(err);
            }
        },
        async loadClasses() {
            try {
                const response = await axios.get("/api/classes");
                this.classs = response.data.classes;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(err);
            }
        },
        async loadSections() {
            try {
                const response = await axios.get(
                    `/api/classes/${this.form.class_id}/sections`
                );
                this.class_sections = response.data.sections;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(err);
            }
        },
        async loadSubjects() {
            console.log("subjects loading");
            try {
                const response = await axios.get(
                    `/api/classes/${this.form.class_id}/subjects`
                );
                this.class_subjects = response.data.subjects;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(err);
            }
        },
        save() {
            if (this.isEditMode) {
                this.updateSchedule();
            } else {
                this.createSchedule();
            }
        },
        async updateSchedule() {
            try {
                const response = await this.form.put(
                    `/api/exams/${this.form.exam_id}/schedules/${this.schedule.id}`
                );
                this.reset();
                this.toastSuccess(response.data.message);
                this.$emit("complete");
            } catch (err) {
                this.toastError();
            }
        },
        async createSchedule() {
            try {
                const response = await this.form.post(
                    `/api/exams/${this.form.exam_id}/schedules`
                );
                this.reset();
                this.toastSuccess(response.data.message);
                this.$emit("complete");
            } catch (err) {
                this.toastError();
            }
        }
    }
};
</script>

<style lang="scss" scoped>
</style>
