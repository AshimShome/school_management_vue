<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t('academic') }}</h2>
                </div>
            </div>
        </div>
        <div class="row row-cards">
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-sm-2 col-6">
                        <select v-model="searchForm.student_id" class="form-control text-center"
                            :class="{'is-invalid': searchForm.errors.has('student_id')}">
                            <option value="" selected class="d-none">{{ $t('select_child') }}</option>
                            <option v-for="child in childs" :key="child.id" :value="child.student_id">
                                {{ child.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="student_id"></has-error>
                    </div>
                    <div class="col-sm-2 col-6">
                        <button :disabled="!searchForm.student_id" @click="getStudentSubjects"
                            class="btn btn-primary btn-outline">
                            {{ $t('get_subjects') }}
                        </button>
                    </div>
                </div>
            </div>
            <template v-if="subjects && subjects.length">
                <div class="col-12 col-xl-3 col-sm-6 col-md-6 col-lg-6" v-for="subject in subjects" :key="subject.id">
                    <div class="card ">
                        <div class="card-img-top img-responsive img-responsive-16by9" :style="{ backgroundImage: 'url('+subject.image_url+')' }"></div>
                        <div class="card-body">
                            <div class=" d-flex justify-content-between">
                                <h2 class="font-weight-bold mb-0 pb-0">{{ subject.name }} <span v-tooltip="'Subject Code'">({{ subject.code }})</span></h2>
                            </div>
                            <dl class="row">
                                <dt class="col-5">{{ $t('type') }}:</dt>
                                <dd class="col-7">{{ subject.type | capitalize }}</dd>
                                <dt class="col-5">{{ $t('pass_marks') }}:</dt>
                                <dd class="col-7">{{ subject.pass_marks }} {{ $t('out_of') }} {{ subject.total_marks }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </template>
            <div v-else class="d-flex justify-content-center py-3">
                <NotFound word="subject" />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            subjects: [],
            searchForm: new Form({
                student_id: ""
            })
        };
    },
    methods: {
        async getStudentSubjects() {
            let response = await axios.get(
                `/api/parent/student/${this.searchForm.student_id}/subjects`
            );
            this.subjects = response.data;
        }
    },
    async created() {
        if (this.userRole != "Guardian") {
            this.redirect("401");
        }
        await this.$store.dispatch("parent/fetchChilds");
    },
    computed: {
        childs() {
            return this.$store.getters["parent/getChilds"];
        }
    },
    mounted() {
        if (this.childs.length) {
            this.searchForm.student_id = this.childs[0].student_id;
            this.getStudentSubjects();
        }
    }
};
</script>
