<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">{{ $route.meta.title }}</div>
                    <h2 class="page-title">{{ $t("accounting") }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <!-- Create Form -->
            <div class="col-xl-8 mb-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ $t("expense_list") }}</h4>
                    </div>
                    <div class="card-body py-3 table-responsive">
                        <template v-if="expenses && expenses.length">
                            <table class="table table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th>{{ $t("sl") }}</th>
                                        <th>{{ $t("expense_type") }}</th>
                                        <th>{{ $t("amount") }}</th>
                                        <th width="30%">{{ $t("action") }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(expense, index) in expenses" :key="expense.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ expense.expense_type.name }}</td>
                                        <td>{{ expense.amount }}</td>
                                        <td v-if="checkPermission('expense-type-edit') || checkPermission('expense-type-delete')">
                                            <button @click="editData(expense)" class="btn btn-primary"
                                                v-if="checkPermission('expense-type-edit')">
                                                {{ $t("edit") }}
                                            </button>
                                            <DeleteButton v-if="checkPermission('expense-type-delete')" :id="expense.id"
                                                @delete-data="deleteData" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-center mt-3" v-if="next">
                                <button class="btn btn-primary" @click="loadMoreExpense">
                                    {{ $t("load_more") }}
                                </button>
                            </div>
                        </template>
                        <div v-else class="d-flex justify-content-center py-3">
                            <NotFound word="expense" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4" v-if="checkPermission('expense-type-create')">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">
                            <span v-if="!isEditMode">{{ $t("create_expense") }}</span>
                            <span v-else>{{ $t("edit_expense") }}</span>
                        </h4>
                    </div>
                    <div class="card-body border-bottom py-3">
                        <form @submit.prevent="save" autocomplete="off">
                            <div class="form-group">
                                <label class="form-label">{{ $t("expense_type") }}
                                    <span class="text-danger">*</span></label>
                                <base-select :form="form" field="type_id" v-model="form.type_id">
                                    <option value="" class="d-none">
                                        {{ $t("select_type") }}
                                    </option>
                                    <option :value="type.id" v-for="type in expenseTypes" :key="type.id"
                                        :selected="type.id == form.type_id">
                                        {{ type.name }}
                                    </option>
                                </base-select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">{{ $t("amount") }} <span class="text-danger">*</span></label>
                                <base-input :form="form" field="amount" v-model="form.amount"></base-input>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">{{ $t("description") }}</label>
                                <base-textarea :form="form" field="description" v-model="form.description">
                                </base-textarea>
                            </div>
                            <div class="form-footer">
                                <base-button :loading="form.busy">{{ $t("save") }}</base-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    components: {
        DeleteButton: () => import("../../../components/DeleteConfirmation.vue")
    },
    data() {
        return {
            form: new Form({
                type_id: "",
                amount: "",
                description: ""
            }),

            isEditMode: false,
            selectedId: null
        };
    },
    methods: {
        reset() {
            this.form.reset();
            this.selectedId = null;
            this.isEditMode = false;
        },
        async save() {
            try {
                if (!this.isEditMode) {
                    let { data } = await this.form.post("/api/expenses");
                    this.$store.dispatch("expense/fetchExpenses");
                    // await this.$store.commit('expense/ADD_EXPENSE', data.expense);
                    this.toastSuccess(data.message);
                    this.reset();
                } else {
                    let { data } = await this.form.put(
                        `/api/expenses/${this.selectedId}`
                    );
                    this.$store.dispatch("expense/fetchExpenses");
                    this.toastSuccess(data.message);
                    this.reset();
                }
            } catch (err) {
                this.toastError();
            }
        },
        async deleteData(expenseId) {
            try {
                let { data } = await axios.delete(`/api/expenses/${expenseId}`);
                await this.$store.commit("expense/REMOVE_EXPENSE", expenseId);
                this.toastSuccess(data.message);
            } catch (err) {
                this.toastError();
            }
        },
        async loadMoreExpense() {
            let response = await axios.get(this.next);
            this.$store.commit("expense/ADD_MORE_EXPENSES", response.data);
        },
        editData(expense) {
            this.form.fill(expense);
            this.selectedId = expense.id;
            this.isEditMode = true;
        },
        async dataExistsChecking() {
            if (!this.expenseTypes.length) {
                this.toastWarning("Please create expense type first");
                this.redirect("expense-type");
            }

            let response = await axios.get(`/api/sessions/year`);

            if (
                response.data.sessions.length == null ||
                !response.data.selectedSession.default_session_id
            ) {
                this.redirect("academic-session");
                this.toastWarning(
                    "Please create and set default session first"
                );
            }
        }
    },
    computed: {
        ...mapGetters({
            expenses: "expense/expenses",
            next: "expense/next",
            expenseTypes: "expense/expenseType"
        })
    },
    async created() {
        await this.hasPermisssion("expense-list");
        await this.$store.dispatch("expense/fetchExpenses");
        await this.$store.dispatch("expense/fetchExpenseType");
        await this.dataExistsChecking();
    }
};
</script>


<style>
    .fade-enter-active,
    .fade-leave-active {
        transition: opacity 0.3s;
    }

    .fade-enter,
    .fade-leave-active {
        opacity: 0;
    }
</style>
