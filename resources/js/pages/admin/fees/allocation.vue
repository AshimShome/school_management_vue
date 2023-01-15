<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("fees") }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-body d-flex justify-content-between">
                        <h2 class="card-title">{{ $t("fee_allocation") }}</h2>
                        <Back routeName="fees-list" />
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-xl-6">
                                <form @submit.prevent="save" autocomplete="off">
                                    <div class="form-group mb-3">
                                        <base-label :title="$t('invoice_type')" :required="true" />
                                        <base-select :form="form" field="invoice_type" v-model="form.invoice_type">
                                            <option value="bulk" selected>{{ $t("bulk") }}</option>
                                            <option value="individual">{{ $t("individual") }}</option>
                                        </base-select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <base-label :title="$t('fee_type')" :required="true" />
                                        <base-select :form="form" field="type_id" v-model="form.type_id">
                                            <option value="" class="d-none">
                                                {{ $t("select_type") }}
                                            </option>
                                            <option :value="type.id" v-for="type in feesTypes" :key="type.id"
                                                :selected="type.id == form.type_id">
                                                {{ type.name }}
                                            </option>
                                        </base-select>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6 mb-3">
                                            <base-label :title="$t('class')" :required="true" />
                                            <base-select :form="form" field="class_id" v-model="form.class_id"
                                                @change="loadSections">
                                                <option value="" class="d-none">
                                                    {{ $t("select_class") }}
                                                </option>
                                                <option :value="singleClass.id" v-for="singleClass in classes"
                                                    :key="singleClass.id">
                                                    {{ singleClass.name }}
                                                </option>
                                            </base-select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <base-label :title="$t('section')" :required="true" />
                                            <base-select :form="form" field="section_id" v-model="form.section_id">
                                                <option value="" class="d-none">
                                                    {{ $t("select_section") }}
                                                </option>
                                                <option :value="section.id" v-for="section in sections"
                                                    :key="section.id">
                                                    {{ section.name }}
                                                </option>
                                            </base-select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3" v-if="form.invoice_type != 'bulk'">
                                        <base-label :title="$t('student')" :required="true" />
                                        <base-select :form="form" field="student_id" v-model="form.student_id">
                                            <option value="" class="d-none">
                                                {{ $t("select_student") }}
                                            </option>
                                            <option :value="student.id" v-for="student in students" :key="student.id">
                                                {{ student.name }}
                                            </option>
                                        </base-select>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6 mb-3">
                                            <base-label :title="$t('amount')" :required="true" />
                                            <base-input :form="form" field="amount" v-model="form.amount"></base-input>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <base-label :title="$t('due_date')" :required="true" />
                                            <date-picker format="dd MMMM, yyyy" @input="setDueDate($event)"
                                                input-class="form-control" :placeholder="$t('select_date')" />
                                            <has-error :form="form" field="due_date" class="d-block"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <base-label :title="$t('status')" :required="true" />
                                        <div>
                                            <label class="form-check form-check-inline">
                                                <input v-model="form.status" class="form-check-input" type="radio"
                                                    value="1" />
                                                <span class="form-check-label">{{ $t("paid") }}</span>
                                            </label>
                                            <label class="form-check form-check-inline">
                                                <input v-model="form.status" class="form-check-input" type="radio"
                                                    value="0" />
                                                <span class="form-check-label">{{ $t("unpaid") }}</span>
                                            </label>
                                        </div>
                                        <has-error :form="form" field="name" class="d-block"></has-error>
                                    </div>
                                    <div class="form-group mb-3">
                                        <base-label :title="$t('description')" />
                                        <base-textarea :form="form" field="description" v-model="form.description"
                                            :rows="6"></base-textarea>
                                    </div>
                                    <div class="form-group mb-3">
                                        <div>
                                            <label class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox"
                                                    v-model="form.send_notification" :value="false" @change="check" />
                                                <span class="form-check-label">{{ $t("send_email_notification") }}</span>
                                            </label>
                                        </div>
                                        <has-error :form="form" field="name" class="d-block"></has-error>
                                    </div>
                                    <div v-if="form.send_notification">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="title">{{ $t("title") }}</label>
                                            <input id="title" class="form-control"
                                                :class="{ 'is-invalid': form.errors.has('title') }"
                                                v-model="form.title" />
                                            <has-error :form="form" field="title"></has-error>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="message">{{ $t("message") }}</label>
                                            <textarea id="message" :rows="8" class="form-control"
                                                :class="{ 'is-invalid': form.errors.has('message') }"
                                                v-model="form.message"></textarea>
                                            <has-error :form="form" field="message"></has-error>
                                        </div>
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
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import dayjs from "dayjs";

export default {
    data() {
        return {
            sections: [],
            students: [],

            form: new Form({
                invoice_type: "bulk",
                type_id: "",
                class_id: "",
                section_id: "",
                student_id: "",
                amount: "",
                due_date: "",
                description: "",
                status: 0,
                send_notification: false,
                title: "",
                message: ""
            })
        };
    },
    watch: {
        "form.invoice_type": function(val) {
            if (
                val == "individual" &&
                this.form.class_id != "" &&
                this.form.section_id != ""
            ) {
                this.loadStudents();
            } else {
                this.form.student_id = "";
            }
        },
        "form.class_id": function(val) {
            if (
                this.form.invoice_type == "individual" &&
                val != "" &&
                this.form.section_id != ""
            ) {
                this.loadStudents();
            } else {
                this.form.student_id = "";
            }
        },
        "form.section_id": function(val) {
            if (
                this.form.invoice_type == "individual" &&
                this.form.class_id != "" &&
                val != ""
            ) {
                this.loadStudents();
            } else {
                this.form.student_id = "";
            }
        }
    },
    computed: {
        ...mapGetters({
            classes: "classs/classes",
            feesTypes: "fee/feesType"
        }),
        searchButtonDisabled() {
            return this.form.class_id == "" || this.form.section_id == "";
        }
    },
    methods: {
        check(e) {
            this.$nextTick(() => {
                console.log(this.form.send_notification, e);
            });
        },
        setDueDate(event) {
            let date = dayjs(event).format("YYYY-MM-DD");
            this.form.due_date = date;
        },
        async loadSerachFormSections() {
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
        async loadSections() {
            try {
                const response = await axios.get(
                    `/api/classes/${this.form.class_id}/sections`
                );
                this.sections = response.data.sections;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async loadStudents() {
            try {
                const response = await axios.get(
                    `/api/classes/${this.form.class_id}/section/${this.form.section_id}/students`
                );
                this.students = response.data.data;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async save() {
            try {
                const response = await this.form.post(`/api/fees`);
                this.toastSuccess(response.data.message);
                this.redirect("fees-list");
            } catch (err) {
                this.toastError();
                console.log(err);
            }
        },
        async dataExistsChecking() {
            if (!this.feesTypes.length) {
                this.toastWarning("Please create fee type first");
                this.redirect("fees-type");
            }
            if (!this.classes.length) {
                this.toastWarning("Please create class first");
                this.redirect("academic-class");
            }
        }
    },
    async created() {
        await this.hasPermisssion("fee-create");
        await this.$store.dispatch("classs/fetchClasses");
        await this.$store.dispatch("fee/fetchFeesType");
        await this.dataExistsChecking();
    }
};
</script>
