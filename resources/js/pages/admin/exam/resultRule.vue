<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("exam") }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none" v-if="checkPermission('exam-rule-create')">
                    <div class="d-flex">
                        <a href="#" @click="toggleModalShow" class="btn btn-primary btn-outline">
                            <icon-plus></icon-plus>
                            {{ $t("create") }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cards mt-2">
            <template v-if="!emptyData">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $route.meta.title }}</h3>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-hover table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th width="10%">{{ $t("name") }}</th>
                                        <th width="10%">{{ $t("gpa") }}</th>
                                        <th width="10%">{{ $t("min_mark") }}</th>
                                        <th width="10%">{{ $t("max_mark") }}</th>
                                        <th width="15%" v-if="checkPermission('exam-rule-edit') || checkPermission('exam-rule-delete')">
                                            {{ $t("action") }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="result_rule in result_rules" :key="result_rule.id">
                                        <td>{{ result_rule.name }}</td>
                                        <td>{{ result_rule.gpa }}</td>
                                        <td>{{ result_rule.min_mark }}</td>
                                        <td>{{ result_rule.max_mark }}</td>
                                        <td v-if="checkPermission('exam-rule-edit') || checkPermission('exam-rule-delete')">
                                            <button class="btn btn-primary" href="javascript:void(0)"
                                                @click="editData(result_rule)" v-if="checkPermission('exam-rule-edit')">
                                                {{ $t("edit") }}
                                            </button>
                                            <DeleteButton :id="result_rule.id" @delete-data="deleteData"
                                                v-if="checkPermission('exam-rule-delete')" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </template>
            <div v-else class="d-flex justify-content-center py-3">
                <NotFound word="Marks" />
            </div>
        </div>
        <!-- Modal  -->
        <transition name="fade">
            <div v-if="isModalShow" class="modal modal-blur fade show modal-hidee"
                id="modal-danger" tabindex="-1" role="dialog"
                aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                    <div class="modal-content" v-on-clickaway="reset">
                        <button @click="reset" type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                        <div class="modal-header">
                            <h5 class="modal-title">{{ isEditMode? $t('update_exam_term'): $t('create_exam_term') }}
                            </h5>
                            <button @click="toggleModalShow" type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form @submit.prevent="save" autocomplete="off">
                            <div class="modal-body py-4">
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label">{{ $t("name") }}</label>
                                        <base-input :form="form" field="name" v-model="form.name"></base-input>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">{{ $t("gpa") }}</label>
                                        <base-input :form="form" field="gpa" v-model="form.gpa"></base-input>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">{{ $t("min_mark") }}</label>
                                        <base-input :form="form" field="min_mark" v-model="form.min_mark"></base-input>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">{{ $t("max_mark") }}</label>
                                        <base-input :form="form" field="max_mark" v-model="form.max_mark"></base-input>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <base-button :loading="form.busy">{{ $t("save") }}</base-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    import {
        mixin as clickaway
    } from "vue-clickaway";
    import ButtonLoading from "../../../components/ButtonLoading.vue";
    import CardDropdown from "../../../components/academic/CardDropdown.vue";
    import NotFound from "../../../components/NotFound.vue";
    import {
        mapGetters
    } from "vuex";

    export default {
        mixins: [clickaway],
        components: {
            ButtonLoading,
            CardDropdown,
            NotFound,
            DeleteButton: () => import("../../../components/DeleteConfirmation.vue"),
        },
        data() {
            return {
                isModalShow: false,
                isDeleteModalShow: false,
                selectedId: "",
                isEditMode: false,

                form: new Form({
                    name: "",
                    gpa: "",
                    min_mark: "",
                    max_mark: "",
                }),
            };
        },
        methods: {
            toggleModalShow() {
                this.isModalShow = !this.isModalShow;
                this.form.clear();
            },
            async save() {
                if (!this.isEditMode) {
                    try {
                        const response = await this.form.post("/api/exam-result-rules");
                        this.$store.commit(
                            "examResultRule/ADD_RESULT_RULE",
                            response.data.exam_result_rule
                        );
                        this.reset();
                        this.toastSuccess(response.data.message);
                    } catch (err) {
                        this.toastError();
                    }
                } else {
                    try {
                        const response = await this.form.put(
                            `/api/exam-result-rules/${this.selectedId}`
                        );

                        this.$store.commit(
                            "examResultRule/UPDATE_RESULT_RULE",
                            response.data.exam_result_rule
                        );
                        this.reset();
                        this.toastSuccess(response.data.message);
                    } catch (err) {
                        this.toastError();
                    }
                }
            },
            editData(data) {
                this.isEditMode = true;
                this.toggleModalShow();
                this.selectedId = data.id;
                this.form.fill(data);
            },
            deleteData(id) {
                this.$store.dispatch("examResultRule/removeResultRule", id);
                this.reset();
                this.toastSuccess("Exam rule delete successfully!");
            },
            reset() {
                this.isEditMode = false;
                this.isModalShow = false;
                this.selectedId = "";
                this.form.reset();
                this.form.clear();
            },
        },
        computed: {
            ...mapGetters({
                result_rules: "examResultRule/result_rules",
            }),
            emptyData() {
                return this.result_rules.length == 0;
            },
        },
        async mounted() {
            await this.hasPermisssion("exam-rule-list");
            this.$store.dispatch("examResultRule/fetchResultRules");
        },
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

    .user-card {
        position: relative;
    }

    .dots {
        position: absolute;
        top: 5px;
        right: 10px;
    }
</style>
