<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col-8">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("setting") }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                        <a @click.prevent="goBack" href="#" class="btn btn-primary">
                            {{ $t("back") }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4 mb-3">
                <div class="card" v-if="student">
                    <div class="card-header">
                        <div class="card-title">
                            {{ $t("my_information") }}
                        </div>
                    </div>
                    <div class="card-body p-4 text-center border-bottom py-3">
                        <span class="avatar avatar-xl mb-3 avatar-rounded"
                            :style="{ backgroundImage: `url(${student.user.image_url})` }"></span>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>{{ $t("name") }}</th>
                                    <td>{{ student.user.name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ $t("email") }}</th>
                                    <td>{{ student.user.email }}</td>
                                </tr>
                                <tr>
                                    <th>{{ $t("class") }}</th>
                                    <td>{{ student.classs.name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ $t("section") }}</th>
                                    <td>{{ student.section.name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ $t("roll_no") }}</th>
                                    <td>{{ student.roll_no }}</td>
                                </tr>
                                <tr>
                                    <th>{{ $t("admission_date") }}</th>
                                    <td>{{ formateDate(student.admission_date) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" v-if="student && student.guardian">
                    <div class="card-header">
                        <div class="card-title">
                            {{ $t("parent_information") }}
                        </div>
                    </div>
                    <div class="card-body p-4 text-center py-3 table-responsive">
                        <span class="avatar avatar-xl mb-3 avatar-rounded"
                            :style="{ backgroundImage: `url(${student.guardian.user.image_url})` }"></span>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>{{ $t("name") }}</th>
                                    <td>{{ student.guardian.user.name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ $t("email") }}</th>
                                    <td>{{ student.guardian.user.email }}</td>
                                </tr>
                                <tr>
                                    <th>{{ $t("phone") }}</th>
                                    <td>{{ student.guardian.phone }}</td>
                                </tr>
                                <tr>
                                    <th>{{ $t("gender") }}</th>
                                    <td>{{ student.guardian.gender }}</td>
                                </tr>
                                <tr>
                                    <th>{{ $t("occupation") }}</th>
                                    <td>{{ student.guardian.occupation ? student.guardian.occupation:'-' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ $t("joined_date") }}</th>
                                    <td>{{ formateDate(student.guardian.created_at) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            student: null
        };
    },
    computed: {},
    methods: {
        async getStudent() {
            try {
                const studentId = this.$route.params.id;
                const response = await axios.get(`/api/students/${studentId}`);
                this.student = response.data;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        goBack() {
            this.$router.back(-1);
        }
    },
    created() {
        if (!this.$route.params.id) {
            this.redirect("404");
        }
        this.getStudent();
    }
};
</script>



<style lang="scss" scoped>
    .style-chooser .vs__search::placeholder {
        color: #9a9b9a;
    }
</style>
