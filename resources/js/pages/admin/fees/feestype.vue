<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("fees") }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none" v-if="checkPermission('fee-type-create')">
                    <div class="d-flex">
                        <a href="#" @click="toggleModalShow" class="btn btn-primary btn-outline">
                            <icon-plus></icon-plus>
                            {{ $t("create") }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2 row-cards">
            <template v-if="feesTypes && feesTypes.length">
                <div class="col-md-4 col-xl-3" v-for="type in feesTypes" :key="type.id">
                    <div class="card">
                        <div class="card-img-top img-responsive img-responsive-16by9"
                            :style="{ backgroundImage: 'url(' + type.image_url + ')' }"></div>
                        <div class="card-body d-flex justify-content-between">
                            <h3 class="card-title">{{ type.name }}</h3>

                            <div v-if="checkPermission('fee-type-delete') || checkPermission('fee-type-edit')">
                                <span class="cursor-pointer" v-if="checkPermission('fee-type-edit')"
                                    @click="editData(type)">
                                    <icon-edit />
                                </span>
                                <span class="cursor-pointer" v-if="checkPermission('fee-type-delete')"
                                    @click="deleteConfirmation(type.id)">
                                    <icon-trash />
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <div v-else class="d-flex justify-content-center py-3">
                <NotFound word="fee type" />
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
                            <h5 v-if="!isEditMode" class="modal-title">{{ $t('create_fees_type') }}</h5>
                            <h5 v-else class="modal-title">{{ $t('update_fees_type') }}</h5>
                            <button @click.prevent="reset" type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form @submit.prevent="save" autocomplete="off">
                            <div class="modal-body py-3">
                                <div class="row">
                                    <div class="mb-3">
                                        <base-label :title="$t('name')" :required="true" />
                                        <input v-model="form.name" type="text" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('name') }"
                                            :placeholder="$t('enter_name')" />
                                        <has-error :form="form" field="name"></has-error>
                                    </div>
                                    <div class="mb-3">
                                        <base-label :title="!isEditMode ? $t('image') : $t('change_image')" />
                                        <input @change="onImageChange"
                                            :class="{ 'is-invalid': form.errors.has('image') }" type="file"
                                            class="form-control" accept="image/png, image/jpeg, image/jpg" />
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
import { serialize } from "object-to-formdata";
import ButtonLoading from "../../../components/ButtonLoading.vue";
import CardDropdown from "../../../components/academic/CardDropdown.vue";
import DeleteModal from "../../../components/modal/DeleteModal.vue";
import NotFound from "../../../components/NotFound.vue";
import { mapGetters } from "vuex";
import { mixin as clickaway } from "vue-clickaway";

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
                    let { data } = await this.form.post("/api/feetypes", {
                        transformRequest: [
                            function(data, headers) {
                                return serialize(data);
                            }
                        ]
                    });
                    await this.$store.commit("fee/ADD_FEE_TYPE", data.feetype);
                    this.toastSuccess(data.message);
                    this.reset();
                } else {
                    let { data } = await this.form.post(
                        `/api/feetypes/${this.selectedId}/update`,
                        {
                            transformRequest: [
                                function(data, headers) {
                                    return serialize(data);
                                }
                            ]
                        }
                    );
                    this.$store.commit("fee/UPDATE_FEE_TYPE", data.feetype);
                    this.toastSuccess(data.message);
                    this.reset();
                }
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
                    `/api/feetypes/${this.selectedId}`
                );
                this.$store.commit("fee/REMOVE_FEE_TYPE", this.selectedId);
                this.reset();
                this.toggleDeleteModal();
                this.toastSuccess(response.data.message);
            } catch (err) {
                if (err.status == 409) {
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
        async loadFeesType() {
            await this.$store.dispatch("fee/fetchFeesType");
        }
    },
    computed: {
        ...mapGetters({
            feesTypes: "fee/feesType"
        }),
        emptyData() {
            return this.sessions.length;
        }
    },
    async created() {
        await this.hasPermisssion("fee-type-list");
        this.loadFeesType();
    }
};
</script>
