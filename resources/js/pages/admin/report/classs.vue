<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t('class') }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-3">
                        <select v-model="searchForm.class_id" class="form-control"
                            :class="{'is-invalid': searchForm.errors.has('class_id')}">
                            <option value="">{{ $t('select_session') }}</option>
                            <option v-for="singleClass in classs" :key="singleClass.id" :value="singleClass.id">
                                {{ singleClass.name }}
                            </option>
                        </select>
                        <has-error :form="searchForm" field="class_id"></has-error>
                    </div>
                    <div class="col-3">
                        <button :disabled="!searchBtn" class="btn btn-primary btn-outline"
                            @click.prevent="getClasReport">
                            {{ $t('get_class_report') }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3" v-if="sections.length">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">{{ $t('class_sections') }}</h2>
                    </div>
                    <div class="card-body">
                        <div class="row row-cards">
                            <template v-if="sections.length">
                                <div v-for="section in sections" :key="section.id" class="col-md-6 col-xl-3">
                                    <div class="card user-card">
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                <span class="avatar avatar-md">{{ section.name }}</span>
                                            </div>
                                            <div class="card-title mb-1">{{ $t('capacity') }}: <b>{{ section.capacity }}</b></div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <div v-else class="d-flex justify-content-center py-3">
                                <NotFound word="sections" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-3" v-if="subjects.length">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">{{ $t('class_subjects') }}</h2>
                    </div>
                    <div class="card-body">
                        <div class="row row-cards">
                            <template v-if="subjects.length">
                                <div v-for="subject in subjects" :key="subject.id" class="col-md-6 col-xl-3">
                                    <div class="card user-card">
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                <span class="avatar avatar-md">{{ subject.code }}</span>
                                            </div>
                                            <div class="card-title mb-1">{{ $t('name') }} : <b>{{ subject.name }}</b></div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <div v-else class="d-flex justify-content-center py-3">
                                <NotFound word="subjects" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NotFound from "../../../components/NotFound.vue";
import { mapGetters } from "vuex";

export default {
    components: {
        NotFound
    },
    data() {
        return {
            searchForm: new Form({
                class_id: ""
            }),
            sectionInput: false,
            searchBtn: false,
            url: "/images/default.png",
            classReport: {}
        };
    },
    watch: {
        "searchForm.class_id": function(value) {
            this.sectionInput = true;
        }
    },
    methods: {
        async getClasReport() {
            let response = await this.searchForm.post(`/api/reports/class`);
            this.classReport = response.data;
        }
    },
    computed: {
        ...mapGetters({
            classs: "classs/classes"
        }),
        sections() {
            if (this.classReport.sections) {
                return this.classReport.sections;
            }
            return [];
        },
        subjects() {
            if (this.classReport.subjects) {
                return this.classReport.subjects;
            }
            return [];
        }
    },
    async created() {
        await this.hasPermisssion("class-report");
        this.$store.dispatch("classs/fetchClasses");
        this.searchBtn = true;
    }
};
</script>
