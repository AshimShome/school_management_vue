<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col-8">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("accountant") }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                        <a @click.prevent="goBack" href="#" class="btn btn-primary btn-outline">
                            {{ $t("back") }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 col-xl-6">
                <div class="card" v-if="accountant">
                    <div class="card-body p-4 text-center border-bottom py-3 table-responsive">
                        <span class="avatar avatar-xl mb-3 avatar-rounded"
                            :style="{ backgroundImage: `url(${accountant.user.image_url})` }"></span>
                        <table class="table table-vcenter">
                            <tbody>
                                <tr>
                                    <th width="20%">{{ $t("name") }}</th>
                                    <td width="80%">{{ accountant.user.name }}</td>
                                </tr>
                                <tr>
                                    <th width="20%">{{ $t("email") }}</th>
                                    <td width="80%">{{ accountant.user.email }}</td>
                                </tr>
                                <tr>
                                    <th width="20%">{{ $t("phone") }}</th>
                                    <td width="80%">{{ accountant.phone }}</td>
                                </tr>
                                <tr>
                                    <th width="20%">{{ $t("gender") }}</th>
                                    <td width="80%">{{ accountant.gender | capitalize }}</td>
                                </tr>
                                <tr>
                                    <th width="20%">{{ $t("religion") }}</th>
                                    <td width="80%">{{ accountant.religion | capitalize }}</td>
                                </tr>
                                <tr>
                                    <th width="40%">{{ $t("joined_date") }}</th>
                                    <td width="60%">{{ formateDate(accountant.created_at) }}</td>
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
            accountant: null
        };
    },
    computed: {},
    methods: {
        async getAccountant() {
            try {
                const accountantId = this.$route.params.id;
                const response = await axios.get(
                    `/api/accountants/${accountantId}`
                );
                this.accountant = response.data.data;
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
        this.getAccountant();
    }
};
</script>



<style lang="scss" scoped>
    .style-chooser .vs__search::placeholder {
        color: #9a9b9a;
    }
</style>
