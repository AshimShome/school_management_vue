<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $t("department") }}</h2>
                    <h2 class="page-pretitle">{{ $t("academic") }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none" v-if="checkPermission('department-create')">
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
            <template v-if="departments && departments.length">
                <div :class="` ${departments.length <= 3 ? 'col-lg-4 col-md-3 col-sm-6 ' : 'col-lg-4 col-xl-3 col-sm-6' } `" v-for="department in departments" :key="department.id">
                    <div class="card ">
                        <div class="card-img-top img-responsive img-responsive-16by9"
                            :style="{ backgroundImage: 'url('+department.image_url+')' }"></div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h2 class="font-weight-bold mb-0 pb-0">{{ department.name }}</h2>
                                <div v-if="checkPermission('department-delete') || checkPermission('department-edit')">
                                    <span class="cursor-pointer" v-if="checkPermission('department-edit')"
                                        @click="editData(department)">
                                        <icon-edit />
                                    </span>
                                    <span class="cursor-pointer" v-if="checkPermission('department-delete')"
                                        @click="deleteConfirmation(department.id)">
                                        <icon-trash />
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <div v-else class="d-flex justify-content-center py-3">
                <NotFound word="department" />
            </div>
        </div>

        <!-- Modal  -->
        <transition name="fade">
            <div v-if="isModalShow" class="modal modal-blur fade show modal-hidee"
               id="modal-danger" tabindex="-1" role="dialog"
                aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                    <div class="modal-content" v-on-clickaway="reset">
                        <div class="modal-header">
                            <h5 v-if="!isEditMode" class="modal-title">
                                {{ $t("create_department") }}
                            </h5>
                            <h5 v-else class="modal-title">
                                {{ $t("update_department") }}
                            </h5>
                            <button @click.prevent="reset" type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form @submit.prevent="save" autocomplete="off">
                            <div class="modal-body py-4">
                                <div class="row">
                                    <div class="mb-3">
                                        <base-label :title="$t('name')"/>
                                        <input v-model="form.name" type="text" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('name') }"
                                            :placeholder="$t('enter_name')" />
                                        <has-error :form="form" field="name"></has-error>
                                    </div>
                                    <div class="mb-3">
                                        <base-label :title="!isEditMode ? $t('image'):$t('change_image')" :required="!isEditMode ? false:true"/>
                                        <input @change="onImageChange"
                                            :class="{ 'is-invalid': form.errors.has('image') }" type="file"
                                            class="form-control" accept="image/png, image/jpeg, image/jpg">
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
import ButtonLoading from "../../../components/ButtonLoading.vue";
import CardDropdown from "../../../components/academic/CardDropdown.vue";
import DeleteModal from "../../../components/modal/DeleteModal.vue";
import NotFound from "../../../components/NotFound.vue";
import { mapGetters } from "vuex";
import { mixin as clickaway } from "vue-clickaway";
import { serialize } from "object-to-formdata";

export default {
    mixins: [clickaway],
    components: {
        ButtonLoading,
        CardDropdown,
        DeleteModal,
        NotFound
    },
    data() {
        return {
            isModalShow: false,
            isDeleteModalShow: false,
            selectedId: "",
            isEditMode: false,
            form: new Form({
                name: "",
                image: ""
            })
        };
    },
    methods: {
        onImageChange(e) {
            this.form.image = e.target.files[0];
        },
        toggleModalShow() {
            this.isModalShow = !this.isModalShow;
            this.form.clear();
        },
        toggleDeleteModal() {
            this.isDeleteModalShow = !this.isDeleteModalShow;
            this.selectedId = "";
        },
        async save() {
            try {
                if (!this.isEditMode) {
                    let { data } = await this.form.post("/api/departments", {
                        transformRequest: [
                            function(data, headers) {
                                return serialize(data);
                            }
                        ]
                    });
                    this.$store.commit(
                        "department/ADD_DEPARTMENT",
                        data.department
                    );
                    this.toastSuccess(data.message);
                } else {
                    let { data } = await this.form.post(
                        `/api/departments/${this.selectedId}/update`,
                        {
                            transformRequest: [
                                function(data, headers) {
                                    return serialize(data);
                                }
                            ]
                        }
                    );

                    this.$store.commit(
                        "department/UPDATE_DEPARTMENT",
                        data.department
                    );
                    this.toastSuccess(data.message);
                }
                this.reset();
            } catch (err) {
                this.toastError();
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
                const response = await axios.delete(
                    `/api/departments/${this.selectedId}`
                );
                this.$store.commit(
                    "department/REMOVE_DEPARTMENT",
                    this.selectedId
                );

                this.toggleDeleteModal();
                this.toastSuccess(response.data.message);
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
        reset() {
            this.isEditMode = false;
            this.isModalShow = false;
            this.selectedId = "";
            this.form.reset();
            this.form.clear();
        },
        async loadDepartments() {
            await this.$store.dispatch("department/fetchDepartments");
        }
    },
    computed: {
        ...mapGetters({
            departments: "department/departments"
        }),
        emptyData() {
            return this.departments.length;
        }
    },
    async created() {
        await this.hasPermisssion("department-list");
        this.loadDepartments();
    }
};
</script>
