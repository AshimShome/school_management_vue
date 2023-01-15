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
                        <h2 class="card-title">{{ $t("fee_allocation_edit") }}</h2>
                        <Back routeName="fees-list" />
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-xl-6">
                                <form @submit.prevent="save" autocomplete="off">
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
                                                    :key="singleClass.id" :selected="singleClass.id == form.class_id">
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
                                                    :key="section.id" :selected="section.id == form.section_id">
                                                    {{ section.name }}
                                                </option>
                                            </base-select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6 mb-3">
                                            <base-label :title="$t('amount')" :required="true" />
                                            <base-input :form="form" field="amount" v-model="form.amount"></base-input>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <base-label :title="$t('due_date')" :required="true" />
                                            <date-picker format="dd MMMM, yyyy" @input="setDueDate($event)"
                                                input-class="form-control" :placeholder="$t('select_date')"
                                                :value="form.due_date" />
                                            <has-error :form="form" field="due_date" class="d-block"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <base-label :title="$t('description')" />
                                        <base-textarea :form="form" field="description" v-model="form.description"
                                            :rows="6"></base-textarea>
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
                type_id: "",
                class_id: "",
                section_id: "",
                amount: "",
                due_date: "",
                description: ""
            })
        };
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
        setDueDate(event) {
            let date = dayjs(event).format("YYYY-MM-DD");
            this.form.due_date = date;
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
        async save() {
            try {
                const response = await this.form.put(
                    `/api/fees/${this.$route.params.id}`
                );
                this.toastSuccess(response.data.message);
                this.redirect("fees-list");
            } catch (err) {
                this.toastError();
                console.log(err);
            }
        },
        async getData() {
            let response = await axios.get(
                `/api/fees/${this.$route.params.id}`
            );
            this.form.fill(response.data);
            this.loadSections();
        }
    },
    async created() {
        await this.hasPermisssion("fee-edit");
        await this.$store.dispatch("classs/fetchClasses");
        await this.$store.dispatch("fee/fetchFeesType");
        await this.getData();
    }
};
</script>
