<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("class_syllabus") }}</h2>
                </div>
            </div>
        </div>
        <div class="row row-deck row-cards justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ $t("syllabus_create") }}</h4>
                        <router-link :to="{ name: 'academic-syllabus-index' }" class="btn btn-primary">{{ $t("back") }}
                        </router-link>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <form @submit.prevent="save" autocomplete="off">
                                    <div class="form-group mb-3">
                                        <label for="term_id" class="form-label">{{ $t("exam_term") }}</label>
                                        <div>
                                            <select id="term_id" v-model="form.exam_id" class="form-control"
                                                :class="{ 'is-invalid': form.errors.has('class_id') }">
                                                <option value="" disabled>
                                                    {{ $t("select_exam_term") }}
                                                </option>
                                                <option v-for="exam in exams" :key="exam.id" :value="exam.id">
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
                                                :class="{ 'is-invalid': form.errors.has('class_id') }"
                                                @change="loadSubjects">
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
                                                    :value="subject.id">
                                                    {{ subject.name }}
                                                </option>
                                            </select>
                                            <has-error :form="form" field="subject_id"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="term_id" class="form-label">{{ $t("attachment_file") }}</label>
                                        <div>
                                            <input id="attachment_id" @change="onAttachmentChange" type="file"
                                                class="form-control"
                                                :class="{ 'is-invalid': form.errors.has('attachment') }" />
                                            <has-error :form="form" field="subject_id"></has-error>
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
import { serialize } from "object-to-formdata";

export default {
    computed: {
        ...mapGetters({
            classes: "classs/classes",
            exams: "exam/examList"
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
            // Search Form
            searchForm: new Form({
                class_id: ""
            }),

            subjects: [],
            routines: [],
            classes_exam_terms: [],

            // Form Data
            form: new Form({
                exam_id: "",
                class_id: "",
                subject_id: "",
                attachment: ""
            })
        };
    },
    methods: {
        async getTerms() {
            try {
                const response = await axios.get(
                    `/api/syllabuses/${this.searchForm.class_id}/get-class-exams`
                );
                this.classes_exam_terms = response.data.terms;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error.response.data.errors);
            }
        },
        onAttachmentChange(e) {
            var file = e.target.files[0];
            this.form.attachment = file;
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
        async save() {
            if (!this.isEditMode) {
                try {
                    const response = await this.form.post(`/api/syllabuses`, {
                        transformRequest: [
                            function(data, headers) {
                                return serialize(data);
                            }
                        ]
                    });
                    this.reset();
                    this.toastSuccess(response.data.message);
                } catch (err) {
                    this.toastError();
                    console.log(err);
                }
            } else {
                try {
                    const response = await this.form.put(
                        `/api/update-class-routines/${this.selectedId}`
                    );

                    this.reset();
                    this.toastSuccess(response.data.message);
                } catch (err) {
                    console.log(err);
                    this.toastError();
                }
            }
        },
        reset() {
            this.form.reset();
            this.form.clear();
        },
        async dataExistsChecking() {
            if (!this.classes.length) {
                this.toastWarning("Please create class first");
                this.redirect("academic-class");
            }

            if (!this.exams.length) {
                this.toastWarning("Please create exam first");
                this.redirect("exam");
            }
        }
    },
    async created() {
        await this.$store.dispatch("classs/fetchClasses");
        await this.$store.dispatch("exam/fetchExamsList");
        await this.dataExistsChecking();
    }
};
</script>
