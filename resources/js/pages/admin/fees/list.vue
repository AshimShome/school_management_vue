<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("fees") }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none" v-if="checkPermission('fee-create')">
                    <div class="d-flex">
                        <router-link :to="{ name: 'fees-allocation' }" class="btn btn-primary btn-outline">
                            <icon-plus />
                            {{ $t("fee_allocation") }}
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-md-4 col-xl-2">
                        <select v-model="searchForm.type_id" class="form-control">
                            <option value="" class="d-none">
                                {{ $t("select_fee_type") }}
                            </option>
                            <option v-for="type in feesTypes" :key="type.id" :value="type.id">
                                {{ type.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4 col-xl-2" v-if="searchForm.type_id">
                        <select v-model="searchForm.class_id" class="form-control" @change="loadSections">
                            <option value="" class="d-none">
                                {{ $t("select_class") }}
                            </option>
                            <option v-for="singleClass in classes" :key="singleClass.id" :value="singleClass.id">
                                {{ singleClass.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4 col-xl-2" v-if="searchForm.type_id && searchForm.class_id">
                        <select v-model="searchForm.section_id" class="form-control">
                            <option value="" class="d-none">
                                {{ $t("select_section") }}
                            </option>
                            <option v-for="section in sections" :key="section.id" :value="section.id">
                                {{ section.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4 col-xl-2" v-if="searchForm.type_id && searchForm.class_id && searchForm.section_id">
                        <select v-model="searchForm.status" class="form-control">
                            <option value="0" selected>{{ $t("unpaid") }}</option>
                            <option value="1">{{ $t("paid") }}</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-xl-2" v-if="searchForm.type_id && searchForm.class_id && searchForm.section_id && searchForm.status ">
                        <button :disabled="searchButtonDisabled" @click="getFeesCollections"
                            class="btn btn-primary btn-outline">
                            {{ $t("get_fees") }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 my-3" v-if="fees && fees.length">
                <div class="card bg-secondary text-white">
                    <div class="card-body">
                        <div class="text-center">
                            <h2>{{ $t("fee_information") }}</h2>
                            <h4>
                                <b>{{ $t("fee_type") }}:</b> {{ getFeeTypeName.name }}
                            </h4>
                            <h4>
                                <b>{{ $t("class") }}:</b> {{ getClassName.name }}
                            </h4>
                            <h5>
                                <b>{{ $t("section") }}:</b> {{ getSectionName.name }}
                            </h5>
                            <h5>
                                <b>{{ $t("status") }}:</b>
                                <span v-if="searchForm.status == 1">{{ $t("paid") }}</span>
                                <span v-else>{{ $t("unpaid") }}</span>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3" v-if="fees && fees.length">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">{{ $t("fees") }}</h2>
                    </div>
                    <div class="card-body table-responsive">

                        <table class="table table-vcenter text-nowrap" v-if="fees && fees.length">
                            <thead>
                                <tr>
                                    <th>{{ $t("user_information") }}</th>
                                    <th>{{ $t("transaction_no") }}</th>
                                    <th>{{ $t("amount") }}</th>
                                    <th>{{ $t("due_date") }}</th>
                                    <th>{{ $t("pay_date") }}</th>
                                    <th width="25%" v-if=" checkPermission('fee-edit') || checkPermission('fee-delete') ">
                                        {{ $t("action") }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="fee in fees" :key="fee.id">
                                    <td>
                                        <!-- Student  -->
                                        <h3 v-if="fee.student">
                                            <b>{{ $t('student') }}:</b>
                                            <small>
                                                <router-link :to="{ name: 'user-student-view', params: { id: fee.student_id } }">
                                                    {{ fee.student.user.name }}
                                                </router-link>
                                            </small>
                                        </h3>

                                        <!-- Parent -->
                                        <h3 v-if="fee.parent">
                                            <b>{{ $t('parent') }}:</b>
                                            <small>
                                                <router-link :to="{ name: 'user-guardian-view', params: { id: fee.parent_id } }">
                                                    {{ fee.parent.user.name }}
                                                </router-link>
                                            </small>
                                        </h3>
                                    </td>
                                    <td>{{ fee.transaction_no }}</td>
                                    <td>{{ fee.amount }}</td>
                                    <td>{{ formateDate(fee.due_date) }}</td>
                                    <td>{{ fee.pay_date ? formateDate(fee.pay_date) : "-" }}</td>
                                    <td v-if=" checkPermission('fee-edit') || checkPermission('fee-delete') ">
                                        <button v-if="!fee.status" class="btn btn-success" @click="markPaid(fee.id)">
                                            {{ $t("mark_as_paid") }}
                                        </button>
                                        <router-link v-if="checkPermission('fee-edit') && !fee.status" :to="{ name: 'fees-allocation-edit', params: { id: fee.id } }" class="btn btn-primary">
                                            {{ $t("edit") }}
                                        </router-link>
                                        <DeleteButton v-if="checkPermission('fee-delete')" :id="fee.id"
                                            @delete-data="deleteData" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-center" v-if="next">
                            <button class="btn btn-primary" @click="loadMoreData">
                                {{ $t("load_more") }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="d-flex justify-content-center py-3">
                <NotFound word="class routine" />
            </div>
        </div>
    </div>
</template>

<script>
import { mixin as clickaway } from "vue-clickaway";
import NotFound from "../../../components/NotFound.vue";
import { mapGetters } from "vuex";
import BaseLabel from "../../../components/global/form/label/BaseLabel.vue";

export default {
    mixins: [clickaway],
    components: {
        NotFound,
        BaseLabel,
        DeleteButton: () => import("../../../components/DeleteConfirmation.vue")
    },
    computed: {
        ...mapGetters({
            classes: "classs/classes",
            feesTypes: "fee/feesType"
        }),
        searchButtonDisabled() {
            return (
                this.searchForm.class_id == "" ||
                this.searchForm.section_id == ""
            );
        },
        getFeeTypeName() {
            return this.feesTypes.find(
                item => item.id == this.searchForm.type_id
            );
        },
        getClassName() {
            return this.classes.find(
                item => item.id == this.searchForm.class_id
            );
        },
        getSectionName() {
            return this.sections.find(
                item => item.id == this.searchForm.section_id
            );
        }
    },
    data() {
        return {
            searchForm: new Form({
                type_id: "",
                class_id: "",
                section_id: "",
                status: "0"
            }),

            isDeleteModalShow: false,
            sections: [],
            fees: [],
            next: ""
        };
    },
    methods: {
        async loadSections() {
            try {
                const response = await axios.get(
                    `/api/classes/${this.searchForm.class_id}/sections`
                );
                this.sections = response.data.sections;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async deleteData(id) {
            try {
                const response = await axios.delete(`/api/fees/${id}`);
                this.fees = this.fees.filter(item => item.id !== id);
                this.toastSuccess(response.data.message);
            } catch (err) {
                this.toastError();
            }
        },
        toggleDeleteModal() {
            this.isDeleteModalShow = !this.isDeleteModalShow;
            this.selectedId = "";
        },
        async getFeesCollections() {
            let response = await axios.get("/api/fees", {
                params: {
                    type_id: this.searchForm.type_id,
                    class_id: this.searchForm.class_id,
                    section_id: this.searchForm.section_id,
                    status: this.searchForm.status
                }
            });
            this.fees = response.data.data;
            this.next = response.data.next_page_url;
        },
        async loadMoreData() {
            let response = await axios.get(this.next);
            this.next = response.data.next_page_url;
            this.fees = [...this.fees, ...response.data.data];
        },
        async markPaid(feeId) {
            if (confirm("Are you sure you want to mark this fee as paid?")) {
                let response = await axios.put(`/api/fees/${feeId}/mark-paid`);
                this.fees = this.fees.filter(item => item.id !== feeId);
                this.toastSuccess(response.data.message);
            }
        },
        async markUnpaid(feeId) {
            if (confirm("Are you sure you want to mark this fee as unpaid?")) {
                let response = await axios.put(
                    `/api/fees/${feeId}/mark-unpaid`
                );
                this.fees = this.fees.filter(item => item.id !== feeId);
                this.toastSuccess(response.data.message);
            }
        }
    },
    async created() {
        await this.hasPermisssion("fee-list");
        await this.$store.dispatch("fee/fetchFeesType");
        await this.$store.dispatch("classs/fetchClasses");
    }
};
</script>
