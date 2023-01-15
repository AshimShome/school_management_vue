<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t('class_syllabus') }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
             <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-4 col-sm-2">
                        <select v-model="searchForm.student_id" class="form-control text-center"
                            :class="{'is-invalid': searchForm.errors.has('student_id')}">
                            <option value="" selected class="d-none">{{ $t('select_child') }}</option>
                            <option v-for="child in childs" :key="child.id" :value="child.student_id">
                                {{ child.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="student_id"></has-error>
                    </div>
                    <div class="col-4 col-sm-2">
                        <button :disabled="!searchForm.student_id" @click="getStudentSyllabus"
                            class="btn btn-primary">
                            {{ $t('get_syllabus') }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3" v-if="classes_exam_terms.length">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">{{ $t('exam_terms') }}</h2>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ $t('exam_term') }}</th>
                                    <th>{{ $t('note') }}</th>
                                    <th>{{ $t('action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(term,index) in classes_exam_terms" :key="index">
                                    <td>{{ term.exam.name }}</td>
                                    <td>{{ term.exam.note }}</td>
                                    <td>
                                        <a href="#" @click="showDetails(term.exam_id,term.exam.name)"
                                            class="btn btn-primary btn-outline">
                                            <icon-eye />
                                            {{ $t('show_details') }}
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card mt-3" v-if="showSyllabusDetails" ref="syllabusDetails">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">{{ term_name }} {{ $t('syllabus') }}</h3>
                        <a @click="showSyllabusDetails = false" href="#" class="btn btn-danger">{{ $t('close') }}</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive" v-if="syllabuses && syllabuses.length">
                            <thead>
                                <tr>
                                    <th>{{ $t('subject') }}</th>
                                    <th>{{ $t('attachment') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="syllabus in syllabuses" :key="syllabus.id">
                                    <td width="20%">{{ syllabus.subject_name }}</td>
                                    <td width="20%">
                                        <a href="#" @click="downloadAttachment(syllabus.id)"
                                            class="btn btn-primary" v-if="syllabus.attachment">
                                            <icon-download />
                                            {{ $t('download') }}
                                        </a>
                                        <a href="#"
                                            class="btn btn-secondary" v-else disabled>
                                            {{ $t('file_not_found') }}
                                        </a>
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
import { mapGetters } from "vuex";
export default {
    components: {
        NotFound: () => import("../../components/NotFound.vue")
    },
    data() {
        return {
            searchForm: new Form({
                student_id: ""
            }),
            classes_exam_terms: [],
            class_id: "",
            showSyllabusDetails: false,
            syllabuses: [],
            term_name: ""
        };
    },
    methods: {
        async getStudentSyllabus() {
            try {
                let response = await axios.get(
                    "/api/parent/student/syllabuses-terms",
                    {
                        params: {
                            student_id: this.searchForm.student_id
                        }
                    }
                );
                this.classes_exam_terms = response.data.terms;
                this.class_id = response.data.class_id;
                this.showSyllabusDetails = false;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error.response.data.errors);
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
        },
        async showDetails(term_id, term_name) {
            this.showSyllabusDetails = true;
            this.term_name = term_name;
            try {
                const response = await axios.get(
                    `/api/syllabuses/classes/${this.class_id}/terms/${term_id}/get-syllabus-details`
                );
                this.syllabuses = response.data.syllabus_details;
                this.$refs.syllabusDetails.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error.response.data.errors);
            }
        }
    },
    created() {
        if (this.userRole != "Guardian") {
            this.redirect("401");
        }
        this.$store.dispatch("parent/fetchChilds");
    },
    computed: {
        ...mapGetters({
            user: "auth/user",
            childs: "parent/getChilds"
        })
    },
    mounted() {
        if (this.childs.length) {
            this.searchForm.student_id = this.childs[0].student_id;
            this.getStudentSyllabus();
        }
    }
};
</script>
