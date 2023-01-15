<template>
    <div class="card mb-2">


        <div class="card-header d-flex justify-content-between py-0">
            <h3 class="card-title">{{ $t("due_fees") }}</h3>
            <div>
                <select name="earnings" class="form-select my-2" v-model="selectedChild" @change="getStudentDuefees">
                    <option v-for="child in childs" :key="child.id" :value="child.id"
                        :selected="selectedChild == child.student_id">
                        {{ child.name }}
                    </option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="card-body table-responsive p-0 h-300">
                <Loader v-if="loading" />
                <template v-else>
                    <table class="table table-head-fixed text-nowrap" v-if="duefees && duefees.length">
                        <thead class="header">
                            <tr class="text-center">
                                <th>{{ $t("fee_type") }}</th>
                                <th>{{ $t("amount") }}</th>
                                <th>{{ $t("due_date") }}</th>
                                <th>{{ $t("actions") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="fee in duefees" :key="fee.id">
                                <td class="text-center">{{ fee.fee_type }}</td>
                                <td class="text-center">{{ appCurrency(fee.amount) }}</td>
                                <td class="text-center">{{ formateDate(fee.due_date) }}</td>
                                <td class="text-center">
                                    <a :href="`/payment/${fee.id}/fee`"
                                        class="btn btn-primary btn-sm">{{ $t("pay_now") }}</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center my-5" v-else>
                        <h3>{{ $t("nothing_found") }}</h3>
                    </div>
                </template>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                duefees: [],
                selectedChild: "",
                loading: false,
            };
        },
        methods: {
            async getStudentDuefees() {
                this.loading = true;
                let response = await axios.get(`/api/parent/dashboard/${this.selectedChild}/due-fees`);
                this.duefees = response.data.data;
                this.loading = false;
            },
            async loadData() {
                await this.$store.dispatch("parent/fetchChilds");
                if (this.childs.length) {
                    this.selectedChild = this.childs[0].id;
                }
                await this.getStudentDuefees();
            }
        },
        computed: {
            childs() {
                return this.$store.getters["parent/getChilds"];
            },
        },
        async created() {
            this.loading = true;
            await this.loadData()
            this.loading = false;
        },
    };
</script>
