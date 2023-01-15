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
            <template v-if="subjects && subjects.length">
                <div class="col-md-4 col-sm-6 col-12" v-for="subject in subjects" :key="subject.id">
                    <div class="card ">
                        <div class="card-img-top img-responsive img-responsive-16by9"
                            :style="{ backgroundImage: 'url('+subject.image_url+')' }"></div>
                        <div class="card-body">
                            <div class=" d-flex justify-content-between">
                                <h2 class="font-weight-bold mb-0 pb-0">{{ subject.name }} <span
                                        v-tooltip="'Subject Code'">({{ subject.code }})</span></h2>
                            </div>
                            <dl class="row">
                                <dt class="col-5">{{ $t('type') }}:</dt>
                                <dd class="col-7">{{ subject.type | capitalize }}</dd>
                                <dt class="col-5">{{ $t('pass_marks') }}:</dt>
                                <dd class="col-7">{{ subject.pass_marks }} {{ $t('out_of') }} {{ subject.total_marks }}
                                </dd>
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
            subjects: []
        };
    },
    methods: {
        async getClassSubjects() {
            let response = await axios.get(`/api/student/subjects`);
            this.subjects = response.data;
        }
    },
    async created() {
        if (this.userRole != "Student") {
            this.redirect("401");
        }
        await this.getClassSubjects();
    }
};
</script>
