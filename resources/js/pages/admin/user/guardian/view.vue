<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col-8">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("parent") }}</h2>
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
            <div class="col-md-8 col-xl-6">
                <div class="card" v-if="guardian">
                    <div class="card-body p-4 text-center py-3 table-responsive">
                        <span class="avatar avatar-xl mb-3 avatar-rounded"
                            :style="{ backgroundImage: `url(${guardian.user.image_url})` }"></span>
                        <table class="table table-vcenter">
                            <tbody>
                                <tr>
                                    <th width="20%">{{ $t("name") }}</th>
                                    <td width="80%">{{ guardian.user.name }}</td>
                                </tr>
                                <tr>
                                    <th width="20%">{{ $t("email") }}</th>
                                    <td width="80%">{{ guardian.user.email }}</td>
                                </tr>
                                <tr>
                                    <th width="20%">{{ $t("phone") }}</th>
                                    <td width="80%">{{ guardian.phone }}</td>
                                </tr>
                                <tr>
                                    <th width="20%">{{ $t("occupation") }}</th>
                                    <td width="80%">{{ guardian.occupation ? guardian.occupation: '-' }}</td>
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
            guardian: null
        };
    },
    computed: {},
    methods: {
        async getGuardian() {
            try {
                const guardianId = this.$route.params.id;
                const response = await axios.get(
                    `/api/guardians/${guardianId}`
                );
                this.guardian = response.data.data;
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
        this.getGuardian();
    }
};
</script>

<style lang="scss" scoped>
    .style-chooser .vs__search::placeholder {
        color: #9a9b9a;
    }
</style>
