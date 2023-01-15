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
            <div class="col-md-4">
                <div class="card" v-if="admin">
                    <div class="card-body p-4 text-center border-bottom py-3">
                        <span class="avatar avatar-xl mb-3 avatar-rounded"
                            :style="{ backgroundImage: `url(${admin.user.image_url})` }"></span>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>{{ $t('name') }}</th>
                                    <td>{{ admin.user.name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ $t('email') }}</th>
                                    <td>{{ admin.user.email }}</td>
                                </tr>
                                <tr>
                                    <th>{{ $t('role') }}</th>
                                    <td>{{ admin.user.original_role }}</td>
                                </tr>
                                <tr>
                                    <th>{{ $t('joined_date') }}</th>
                                    <td>{{ formateDate(admin.created_at) }}</td>
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
            admin: null
        };
    },
    methods: {
        async getAdmin() {
            try {
                const adminId = this.$route.params.id;
                const response = await axios.get(`/api/get-admin/${adminId}`);
                this.admin = response.data;
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
        this.getAdmin();
    }
};
</script>

<style lang="scss" scoped>
    .style-chooser .vs__search::placeholder {
        color: #9a9b9a;
    }
</style>
