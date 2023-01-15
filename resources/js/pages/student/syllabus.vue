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
            <div class="col-12 mt-3" v-if="classes_exam_terms.length">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">{{ $t('exam_terms') }}</h2>
                    </div>
                    <div class="card-body  card-body-scrollable card-body-scrollable-shadow">
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
                                        <a href="#" @click="downloadAttachment(syllabus.id)" class="btn btn-primary"
                                            v-if="syllabus.attachment">
                                            <icon-download />
                                            {{ $t('download') }}
                                        </a>
                                        <a href="#" class="btn btn-secondary" v-else disabled>
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
export default {
    components: {
        NotFound: () => import("../../components/NotFound.vue")
    },
    created() {
        if (this.authenticateUser.role != "student") {
            this.redirect("401");
        }
        this.getSyllabus();
    },
    data() {
        return {
            classes_exam_terms: [],
            class_id: "",
            showSyllabusDetails: false,
            syllabuses: [],
            term_name: ""
        };
    },
    methods: {
        async getSyllabus() {
            try {
                let response = await axios.get("/api/student/syllabuses-terms");
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
                console.log(error.response);
            }
        }
    }
};
</script>
