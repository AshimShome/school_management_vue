<template>
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between py-0">
                <h3>{{ $t("due_fees") }}</h3>
                <div>
                    <select v-model="class_id" class="form-select my-2" @change="loadClassFees">
                        <option value="" disabled>{{ $t("select_class") }}</option>
                        <option v-for="singleClass in classes" :key="singleClass.id" :value="singleClass.id">
                            {{ $t("class") }}: {{ singleClass.name }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="card-body table-responsive p-0 due-table-size">
                <Loader v-if="loading" />
                <template v-else>
                    <table class="table table-head-fixed text-nowrap" v-if="duefees && duefees.length">
                        <thead class="header sticky-top">
                            <tr>
                                <th>{{ $t("student") }}</th>
                                <th>{{ $t("fee_type") }}</th>
                                <th>{{ $t("amount") }}</th>
                                <th>{{ $t("due_date") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="fee in duefees" :key="fee.id">
                                <td>
                                    <router-link :to="{name: 'user-student-view', params: { id: fee.student_id }}">
                                        {{ fee.student_name }}
                                    </router-link>
                                    <p class="mt-0 pt-0">
                                        <b>{{ $t("class") }}:</b> {{ fee.class_name }} <br />
                                        <b>{{ $t("section") }}:</b> {{ fee.section_name }}
                                    </p>
                                </td>
                                <td>{{ fee.fee_type }}</td>
                                <td>{{ appCurrency(fee.amount) }}</td>
                                <td>{{ formateDate(fee.due_date) }}</td>
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
                class_id: "",
                duefees: [],
                loading: false
            };
        },
        async mounted() {
            this.loading = true
            await this.loadData()
            this.loading = false
        },
        computed: {
            classes() {
                return this.$store.getters["classs/classes"];
            },
        },
        methods: {
            async loadClassFees() {
                this.loading = true
                let response = await axios.get(
                    `/api/dashboard/${this.class_id}/due-fees`
                );
                this.duefees = response.data.data;
                this.loading = false
            },
            async loadData() {
                await this.$store.dispatch("classs/fetchClasses");
                if (this.classes.length) {
                    this.class_id = this.classes[0].id;
                    await this.loadClassFees();
                }
            }
        },
    };
</script>

<style scoped>
    .due-table-size {
        height: 250px
    }
</style>
