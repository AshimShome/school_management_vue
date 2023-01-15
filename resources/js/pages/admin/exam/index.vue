<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("exam") }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                        <input type="search" class="form-control d-inline-block w-9 me-3"
                            :placeholder="$t('search_here…')" @keyup="searchExam" v-model="form.search" />
                        <a href="#" @click="toggleModalShow" class="btn btn-primary btn-outline"
                            v-if="checkPermission('exam-list')">
                            <icon-plus></icon-plus>
                            {{ $t("create") }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cards mt-2">
            <template v-if="exams && exams.length">
                <div v-for="exam in exams" :key="exam.id" class="col-md-6 col-xl-3">
                    <div class="card user-card">
                        <div class="card-body text-center">
                            <div class="card-title">
                                <h2>{{ exam.name }}</h2>
                            </div>
                            <p><b>
                                    {{ formateDate(exam.start_date, "D MMM, YY") }} -
                                    {{ formateDate(exam.end_date, "D MMM, YY") }}
                                </b></p>
                            <p>
                                {{ exam.note }}
                            </p>
                        </div>
                        <CardDropdown :data="exam" @edit-data="editData" @delete-data="deleteConfirmation" v-if="
                checkPermission('exam-delete') || checkPermission('exam-edit')
              " :canEdit="checkPermission('exam-edit')" :canDelete="checkPermission('exam-delete')" />
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <pagination :data="pagination" @pagination-change-page="fetchExam"></pagination>
                </div>
            </template>
            <div v-else class="d-flex justify-content-center py-3">
                <NotFound word="exam" />
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
                            <h5 class="modal-title">
                                {{ isEditMode ? "Update Exam" : "Create Exam" }}
                            </h5>
                            <button @click="toggleModalShow" type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form @submit.prevent="save" autocomplete="off">
                            <div class="modal-body py-4">
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label" for="name">{{
                      $t("name")
                    }}</label>
                                        <base-input :form="form" field="name" v-model="form.name"></base-input>
                                    </div>
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label" for="name">{{
                          $t("start_date")
                        }}</label>
                                                <date-picker :value="form.start_date" format="dd MMMM, yyyy"
                                                    @input="setStartDate($event)" input-class="form-control"
                                                    :placeholder="$t('select_date')" />
                                                <has-error :form="form" field="start_date" class="d-block"></has-error>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="name">{{
                          $t("end_date")
                        }}</label>
                                                <date-picker :value="form.end_date" format="dd MMMM, yyyy"
                                                    @input="setEndDate($event)" input-class="form-control"
                                                    :placeholder="$t('select_date')" />
                                                <has-error :form="form" field="end_date" class="d-block"></has-error>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="note">{{
                      $t("note")
                    }}</label>
                                        <base-textarea :form="form" field="note" v-model="form.note"></base-textarea>
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

        <!-- delete modal  -->
        <DeleteModal :isShow="isDeleteModalShow" @close-modal="toggleDeleteModal" @delete-data="deleteData" />
    </div>
</template>

<script>
    import dayjs from "dayjs";
    import {
        mixin as clickaway
    } from "vue-clickaway";
    import ButtonLoading from "../../../components/ButtonLoading.vue";
    import CardDropdown from "../../../components/academic/CardDropdown.vue";
    import DeleteModal from "../../../components/modal/DeleteModal.vue";
    import NotFound from "../../../components/NotFound.vue";
    import {
        mapGetters
    } from "vuex";

    export default {
        mixins: [clickaway],
        components: {
            ButtonLoading,
            CardDropdown,
            DeleteModal,
            NotFound,
        },
        data() {
            return {
                isModalShow: false,
                isDeleteModalShow: false,
                selectedId: "",
                isEditMode: false,

                form: new Form({
                    name: "",
                    note: "",
                    start_date: "",
                    end_date: "",
                    search: "",
                }),
            };
        },
        methods: {
            toggleModalShow() {
                this.isModalShow = !this.isModalShow;
                this.form.clear();
            },
            fetchExam(page = 1) {
                this.$store.dispatch("exam/fetchExams", {
                    page: page,
                    search: this.form.search,
                });
            },
            searchExam() {
                this.fetchExam();
            },
            async save() {
                if (!this.isEditMode) {
                    try {
                        const response = await this.form.post("/api/exams");
                        this.$store.commit("exam/ADD_EXAM", response.data.exam);
                        this.reset();
                        this.toastSuccess(response.data.message);
                    } catch (err) {
                        this.toastError();
                    }
                } else {
                    try {
                        const response = await this.form.put(`/api/exams/${this.selectedId}`);
                        this.$store.commit("exam/UPDATE_EXAM", response.data.exam);
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
            deleteConfirmation(id) {
                this.selectedId = id;
                this.isDeleteModalShow = true;
            },
            async deleteData() {
                try {
                    const response = await axios.delete(`/api/exams/${this.selectedId}`);
                    this.$store.commit("exam/REMOVE_EXAM", this.selectedId);

                    this.reset();
                    this.toggleDeleteModal();
                    this.toastSuccess("Exam delete successfully!");
                } catch (error) {
                    this.toastError();
                }
            },
            toggleDeleteModal() {
                this.isDeleteModalShow = !this.isDeleteModalShow;
                this.selectedId = "";
            },
            reset() {
                this.isEditMode = false;
                this.isModalShow = false;
                this.selectedId = "";
                this.form.reset();
                this.form.clear();
            },
            setStartDate(event) {
                const formatTime = dayjs(event).format("YYYY-MM-DD");
                this.form.start_date = formatTime;
            },
            setEndDate(event) {
                const formatTime = dayjs(event).format("YYYY-MM-DD");
                this.form.end_date = formatTime;
            },
        },
        computed: {
            ...mapGetters({
                exams: "exam/exams",
                pagination: "exam/pagination",
            }),
            emptyData() {
                return this.exams.total == 0;
            },
        },
        async mounted() {
            await this.hasPermisssion("exam-list");
            this.fetchExam();
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
