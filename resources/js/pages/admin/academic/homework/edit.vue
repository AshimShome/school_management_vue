<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("homework") }}</h2>
                </div>
            </div>
        </div>
        <div class="row row-deck row-cards justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ $t("edit_homework") }}</h4>
                        <router-link :to="{ name: 'academic-homework' }" class="btn btn-primary">{{ $t("back") }}
                        </router-link>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <form @submit.prevent="save" autocomplete="off">
                                    <div class="form-group mb-3">
                                        <base-label :title="$t('title')" :required="true" />
                                        <base-input :form="form" field="title" v-model="form.title"></base-input>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <base-label :title="$t('teacher')" :required="true" />
                                            <base-select :form="form" field="teacher_id" v-model="form.teacher_id">
                                                <option value="" class="d-none">
                                                    {{ $t("select_teacher") }}
                                                </option>
                                                <option :value="teacher.id" v-for="teacher in teachers"
                                                    :key="teacher.id" :selected="teacher.id == form.teacher_id">
                                                    {{ teacher.user.name }}
                                                </option>
                                            </base-select>
                                        </div>
                                        <div class="col-md-6">
                                            <base-label :title="$t('class')" :required="true" />
                                            <base-select :form="form" field="class_id" v-model="form.class_id"
                                                @change="loadSubjectSection">
                                                <option value="" class="d-none">
                                                    {{ $t("select_class") }}
                                                </option>
                                                <option :value="singleClass.id" v-for="singleClass in classes"
                                                    :key="singleClass.id" :selected="singleClass.id == form.class_id">
                                                    {{ singleClass.name }}
                                                </option>
                                            </base-select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <base-label :title="$t('section')" :required="true" />
                                            <base-select :form="form" field="section_id" v-model="form.section_id">
                                                <option value="" class="d-none">
                                                    {{ $t("select_section") }}
                                                </option>
                                                <option :value="section.id" v-for="section in sections"
                                                    :key="section.id" :selected="section.id == form.section_id">
                                                    {{ section.name }}
                                                </option>
                                            </base-select>
                                        </div>
                                        <div class="col-md-6">
                                            <base-label :title="$t('subject')" :required="true" />
                                            <base-select :form="form" field="subject_id" v-model="form.subject_id">
                                                <option value="" class="d-none">
                                                    {{ $t("select_subject") }}
                                                </option>
                                                <option :value="subject.id" v-for="subject in subjects"
                                                    :key="subject.id" :selected="subject.id == form.subject_id">
                                                    {{ subject.name }}
                                                </option>
                                            </base-select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6 mb-3">
                                            <base-label :title="$t('start_date')" :required="true" />
                                            <div>
                                                <date-picker format="dd MMMM, yyyy" @input="setStartDate($event)"
                                                    input-class="form-control" :placeholder="$t('select_date')"
                                                    :value="form.start_date" />
                                                <has-error :form="form" field="start_date"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <base-label :title="$t('end_date')" :required="true" />
                                            <div>
                                                <date-picker format="dd MMMM, yyyy" @input="setEndDate($event)"
                                                    input-class="form-control" :placeholder="$t('select_date')"
                                                    :value="form.end_date" />
                                                <has-error :form="form" field="end_date"></has-error>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <base-label :title="$t('description')" />
                                        <base-textarea :rows="5" :form="form" field="description"
                                            v-model="form.description"></base-textarea>
                                    </div>
                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-primary">
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
import dayjs from "dayjs";

export default {
    data() {
        return {
            // Form Data
            form: new Form({
                title: "",
                teacher_id: "",
                class_id: "",
                section_id: "",
                subject_id: "",
                start_date: "",
                end_date: "",
                description: ""
            }),

            // set data for inputs
            teachers: [],
            subjects: [],
            sections: []
        };
    },
    computed: {
        ...mapGetters({
            classes: "classs/classes"
        }),
        submitButtonDisabled() {
            return (
                this.form.title == "" ||
                this.form.teacher_id == "" ||
                this.form.class_id == "" ||
                this.form.section_id == "" ||
                this.form.subject_id == "" ||
                this.form.start_date == "" ||
                this.form.end_date == "" ||
                this.form.description == ""
            );
        }
    },
    methods: {
        setStartDate(event) {
            let date = dayjs(event).format("YYYY-MM-DD");
            this.form.start_date = date;
        },
        setEndDate(event) {
            let date = dayjs(event).format("YYYY-MM-DD");
            this.form.end_date = date;
        },
        async loadSubjectSection() {
            this.loadSections();
            this.loadSubjects();
        },
        async loadTeachers() {
            try {
                let response = await axios.get(`/api/homeworks/teachers`);
                this.teachers = response.data.teachers;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
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
                    `/api/homeworks/${this.$route.params.id}`
                );
                this.redirect("academic-homework");
                this.toastSuccess(response.data.message);
            } catch (err) {
                this.toastError();
                console.log(err);
            }
        },
        async loadEditData() {
            let response = await axios.get(
                `/api/homeworks/${this.$route.params.id}`
            );
            this.form.fill(response.data.data);
            this.loadSubjectSection();
        }
    },

    created() {
        this.hasPermisssion("homework-edit");
        this.loadTeachers();
        this.$store.dispatch("classs/fetchClasses");
        this.loadEditData();
    }
};
</script>
