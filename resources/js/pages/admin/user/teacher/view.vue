<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col-8">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("teacher") }}</h2>
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
            <div class="col-md-6">
                <div class="card" v-if="teacher">
                    <div class="card-body p-4 text-center border-bottom py-3">
                        <span class="avatar avatar-xl mb-3 avatar-rounded"
                            :style="{ backgroundImage: `url(${teacher.user.image_url})` }"></span>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th width="20%">{{ $t("name") }}</th>
                                    <td width="80%">{{ teacher.user.name }}</td>
                                </tr>
                                <tr>
                                    <th width="20%">{{ $t("email") }}</th>
                                    <td width="80%">{{ teacher.user.email }}</td>
                                </tr>
                                <tr>
                                    <th width="20%">{{ $t("phone") }}</th>
                                    <td width="80%">{{ teacher.phone }}</td>
                                </tr>
                                <tr>
                                    <th width="20%">{{ $t("gender") }}</th>
                                    <td width="80%">{{ teacher.gender | capitalize }}</td>
                                </tr>
                                <tr>
                                    <th width="20%">{{ $t("religion") }}</th>
                                    <td width="80%">{{ teacher.religion | capitalize }}</td>
                                </tr>
                                <tr>
                                    <th width="20%">{{ $t("present_address") }}</th>
                                    <td width="80%">{{ teacher.present_address ? teacher.present_address: '-' }}</td>
                                </tr>
                                <tr>
                                    <th width="20%">{{ $t("permanent_address") }}</th>
                                    <td width="80%">{{ teacher.permanent_address ? teacher.permanent_address: '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th width="40%">{{ $t("joined_date") }}</th>
                                    <td width="60%">{{ formateDate(teacher.created_at) }}</td>
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
            teacher: null
        };
    },
    computed: {},
    methods: {
        async getTeacher() {
            try {
                const teacherId = this.$route.params.id;
                const response = await axios.get(`/api/teachers/${teacherId}`);
                this.teacher = response.data.data;
            } catch (error) {
                this.toastError(error.response.data.message);
                if (error.response.status === 404) {
                    this.redirect("404");
                }
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
        this.getTeacher();
    }
};
</script>



<style lang="scss" scoped>
    .style-chooser .vs__search::placeholder {
        color: #9a9b9a;
    }
</style>
