<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("class_syllabus") }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none" v-if="checkPermission('syllabus-create')">
                    <div class="d-flex">
                        <router-link :to="{ name: 'academic-syllabus-create' }" class="btn btn-primary btn-outline">
                            <icon-plus></icon-plus>
                            {{ $t("create") }}
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-md-3">
                        <select v-model="searchForm.class_id" class="form-control">
                            <option value="" class="d-none">{{ $t("select_class") }}</option>
                            <option v-for="singleClass in classes" :key="singleClass.id" :value="singleClass.id">
                                {{ singleClass.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3" v-if="searchForm.class_id">
                        <button :disabled="searchButtonDisabled" @click="getTerms" class="btn btn-primary btn-outline">
                            {{ $t("get_exam") }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3" v-if="classes_exam_terms.length">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">{{ $t("exam_terms") }}</h2>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ $t("exam_term") }}</th>
                                    <th>{{ $t("note") }}</th>
                                    <th>{{ $t("action") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(term, index) in classes_exam_terms" :key="index">
                                    <td class="col-3">{{ term.exam.name }}</td>
                                    <td class="col-6">{{ term.exam.note }}</td>
                                    <td class="col-3">
                                        <a href="#" @click="showDetails(term.exam_id, term.exam.name)"
                                            class="btn btn-primary btn-outline">
                                            <icon-eye />
                                            {{ $t("show_details") }}
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card mt-3" v-if="showSyllabusDetails && syllabuses && syllabuses.length"
                    ref="syllabusDetails">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">{{ exam_name }} {{ $t("syllabus") }}</h3>
                        <a @click="showSyllabusDetails = false" href="#" class="btn btn-danger">{{ $t("close") }}</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive" v-if="syllabuses && syllabuses.length">
                            <thead>
                                <tr>
                                    <th>{{ $t("subject") }}</th>
                                    <th>{{ $t("attachment") }}</th>
                                    <th>{{ $t("Action") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="syllabus in syllabuses" :key="syllabus.id">
                                    <td width="20%">{{ syllabus.subject_name }}</td>
                                    <td width="20%">
                                        <button type="button" @click="downloadAttachment(syllabus.id)"
                                            v-if="syllabus.attachment" class="btn btn-primary btn-outline">
                                            <icon-download />
                                            {{ $t("download") }}
                                        </button>
                                        <button type="button" class="btn btn-secondary" v-else disabled>
                                            {{ $t("file_not_found") }}
                                        </button>
                                    </td>
                                    <td width="20%">
                                        <DeleteButton :id="syllabus.id" @delete-data="deleteSyllabus" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-else class="d-flex justify-content-center py-3">
                            <NotFound word="syllabus" />
                        </div>
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
import { mixin as clickaway } from "vue-clickaway";
import { mapGetters } from "vuex";

export default {
    mixins: [clickaway],
    components: {
        NotFound: () => import("../../../../components/NotFound.vue"),
        DeleteButton: () =>
            import("../../../../components/DeleteConfirmation.vue")
    },
    computed: {
        ...mapGetters({
            classes: "classs/classes"
        }),
        searchButtonDisabled() {
            return this.searchForm.class_id == "";
        },
        submitButtonDisabled() {
            return (
                this.form.class_id == "" ||
                this.form.term_id == "" ||
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
            syllabus_details: [],
            classes_exam_terms: [],
            exam_name: "",
            showSyllabusDetails: false,
            syllabuses: []
        };
    },
    methods: {
        async getTerms() {
            try {
                const response = await axios.get(
                    `/api/syllabuses/${this.searchForm.class_id}/get-class-exams`
                );
                this.classes_exam_terms = response.data.exams;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error.response.data.errors);
            }
        },
        async deleteSyllabus(syllabus_id) {
            try {
                const response = await axios.delete(
                    `/api/syllabuses/${syllabus_id}`
                );
                this.syllabuses.splice(
                    this.syllabuses.findIndex(
                        syllabus => syllabus.id == syllabus_id
                    ),
                    1
                );
                this.toastSuccess(response.data.message);
            } catch (err) {
                this.toastError();
                console.log(err);
            }
        },
        async showDetails(exam_id, exam_name) {
            this.showSyllabusDetails = true;
            this.exam_name = exam_name;
            try {
                const response = await axios.get(
                    `/api/syllabuses/classes/${this.searchForm.class_id}/terms/${exam_id}/get-syllabus-details`
                );
                this.syllabuses = response.data.syllabus_details;
                this.$refs.syllabusDetails.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
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
        downloadAttachment(syllabus_id) {
            axios({
                url: `/api/syllabuses/download`,
                method: "POST",
                responseType: "blob",
                data: {
                    syllabus_id: syllabus_id
                }
            })
                .then(response => {
                    const fileExt = response.data.type.split("/")[1];
                    const fileName = Math.floor(Math.random() * 9999999999);
                    const url = window.URL.createObjectURL(
                        new Blob([response.data])
                    );
                    const link = document.createElement("a");
                    link.href = url;
                    link.setAttribute("download", `${fileName}.${fileExt}`);
                    document.body.appendChild(link);
                    link.click();
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    created() {
        this.hasPermisssion("syllabus-list");
        this.$store.dispatch("classs/fetchClasses");
    }
};
</script>
