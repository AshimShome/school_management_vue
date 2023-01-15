<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("academic") }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none" v-if="checkPermission('section-create')">
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
                <div v-for="section in sections" :key="section.id" class="col-md-6 col-xl-3">
                    <div class="card user-card">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <span class="avatar avatar-md">{{ section.name }}</span>
                            </div>
                            <div class="card-title mb-1">
                                {{ $t("capacity") }}: <b>{{ section.capacity }}</b>
                            </div>
                        </div>
                        <CardDropdown v-if="
                checkPermission('section-delete') ||
                checkPermission('section-edit')
              " :canEdit="checkPermission('section-edit')" :canDelete="checkPermission('section-delete')"
                            :data="section" @edit-data="editData" @delete-data="deleteConfirmation" />
                    </div>
                </div>
            </template>
            <div v-else class="d-flex justify-content-center py-3">
                <NotFound word="section" />
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
                            <h5 v-if="!isEditMode" class="modal-title">
                                {{ $t("create_section") }}
                            </h5>
                            <h5 v-else class="modal-title">{{ $t("update_section") }}</h5>
                            <button @click="toggleModalShow" type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form @submit.prevent="save" autocomplete="off">
                            <div class="modal-body py-4">
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label">{{ $t("name") }}</label>
                                        <input v-model="form.name" type="text" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('name') }"
                                            :placeholder="$t('enter_name')" />
                                        <has-error :form="form" field="name"></has-error>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">{{ $t("capacity") }}</label>
                                        <input v-model="form.capacity" type="text" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('capacity') }"
                                            :placeholder="$t('enter_capacity')" />
                                        <has-error :form="form" field="capacity"></has-error>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button @click="reset" type="button" class="btn me-auto" data-bs-dismiss="modal">
                                    {{ $t("cancel") }}
                                </button>
                                <button-loading v-if="form.busy" />
                                <button v-else type="submit" class="btn btn-primary" data-bs-dismiss="modal">
                                    {{ $t("save") }}
                                </button>
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
    import {
        mixin as clickaway
    } from "vue-clickaway";
    import ButtonLoading from "../../../components/ButtonLoading.vue";
    import CardDropdown from "../../../components/academic/CardDropdown.vue";
    import DeleteModal from "../../../components/modal/DeleteModal.vue";
    import NotFound from "../../../components/NotFound.vue";

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
                    capacity: "",
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
                        let {
                            data
                        } = await this.form.post("/api/sections");
                        this.$store.commit("section/ADD_SECTION", data.section);
                        this.reset();
                        this.toastSuccess(data.message);
                    } catch (err) {
                        this.toastError();
                    }
                } else {
                    try {
                        let {
                            data
                        } = await this.form.put(
                            `/api/sections/${this.selectedId}`
                        );
                        this.$store.commit("section/UPDATE_SECTION", data.section);
                        this.reset();
                        this.toastSuccess(data.message);
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
                    const response = await axios.delete(`/api/sections/${this.selectedId}`);
                    this.$store.commit("section/REMOVE_SECTION", this.selectedId);

                    this.reset();
                    this.toggleDeleteModal();
                    this.toastSuccess("Section delete successfully!");
                } catch (err) {
                    if (err.status == 409 || err.status == 403) {
                        this.toastError(
                            `Delete failed, please delete all related items first.`
                        );

                        this.reset();
                        this.toggleDeleteModal();
                        return;
                    }
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
            async loadData() {
                await this.$store.dispatch("section/fetchSection");
            },
        },
        computed: {
            sections() {
                return this.$store.getters["section/sections"];
            },
            emptyData() {
                let data = this.sections && this.sections.length;

                if (data) {
                    return false;
                } else {
                    return true;
                }
            },
        },
        created() {
            this.hasPermisssion("section-list");
            this.loadData();
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
