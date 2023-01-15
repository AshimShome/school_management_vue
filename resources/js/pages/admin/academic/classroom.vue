<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("academic") }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none" v-if="checkPermission('class-room-create')">
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
            <template v-if="classrooms && classrooms.length">
                <div class="col-md-6 col-xl-3 col-lg-4" v-for="room in classrooms" :key="room.id">
                    <div class="card">
                        <div class="card-img-top img-responsive img-responsive-16by9"
                            :style="{ backgroundImage: 'url(' + room.image_url + ')' }"></div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h2 class="font-weight-bold mb-0 pb-0">
                                    {{ $t("room_no") }}: {{ room.room_no }}
                                    <span v-tooltip="'Room Capacity'">({{ room.capacity }})</span>
                                </h2>
                                <div v-if="checkPermission('class-room-delete') || checkPermission('class-room-edit')">
                                    <span class="cursor-pointer" v-if="checkPermission('class-room-edit')"
                                        @click="editData(room)">
                                        <icon-edit />
                                    </span>
                                    <span class="cursor-pointer" v-if="checkPermission('class-room-delete')"
                                        @click="deleteConfirmation(room.id)">
                                        <icon-trash />
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <div v-else class="d-flex justify-content-center py-3">
                <NotFound word="classroom" />
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
                                {{ $t("create_class_room") }}
                            </h5>
                            <h5 v-else class="modal-title">
                                {{ $t("update_class_room") }}
                            </h5>
                            <button @click="toggleModalShow" type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form @submit.prevent="save" autocomplete="off">
                            <div class="modal-body py-4">
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label">{{ $t("room_no") }}</label>
                                        <input v-model="form.room_no" type="text" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('room_no') }"
                                            :placeholder="$t('enter_room_no')" />
                                        <has-error :form="form" field="room_no"></has-error>
                                    </div>
                                    <div class="mb-3">
                                        <base-label :title="!isEditMode ? $t('image') : $t('change_image')" />
                                        <input @change="onImageChange"
                                            :class="{ 'is-invalid': form.errors.has('image') }" type="file"
                                            class="form-control" accept="image/png, image/jpeg, image/jpg" />
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
import { mixin as clickaway } from "vue-clickaway";
import ButtonLoading from "../../../components/ButtonLoading.vue";
import CardDropdown from "../../../components/academic/CardDropdown.vue";
import DeleteModal from "../../../components/modal/DeleteModal.vue";
import NotFound from "../../../components/NotFound.vue";
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
                room_no: "",
                image: "",
                capacity: ""
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
        async save() {
            if (!this.isEditMode) {
                try {
                    let { data } = await this.form.post("/api/classrooms", {
                        transformRequest: [
                            function(data, headers) {
                                return serialize(data);
                            }
                        ]
                    });
                    this.$store.commit("classs/ADD_CLASSROOM", data.classroom);
                    this.reset();
                    this.toastSuccess(data.message);
                } catch (err) {
                    this.toastError();
                }
            } else {
                try {
                    let { data } = await this.form.post(
                        `/api/classrooms/${this.selectedId}/update`,
                        {
                            transformRequest: [
                                function(data, headers) {
                                    return serialize(data);
                                }
                            ]
                        }
                    );
                    this.$store.commit(
                        "classs/UPDATE_CLASSROOM",
                        data["classroom"]
                    );
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
                const response = await axios.delete(
                    `/api/classrooms/${this.selectedId}`
                );
                this.$store.commit("classs/REMOVE_CLASSROOM", this.selectedId);

                this.reset();
                this.toggleDeleteModal();
                this.toastSuccess("Class room delete successfully");
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
            await this.$store.dispatch("classs/fetchClassrooms");
        }
    },
    computed: {
        classrooms() {
            return this.$store.getters["classs/classrooms"];
        },
        emptyData() {
            let data = this.classrooms && this.classrooms.length;

            if (data) {
                return false;
            } else {
                return true;
            }
        }
    },
    created() {
        this.hasPermisssion("class-room-list");
        this.loadData();
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

    .user-card {
        position: relative;
    }

    .dots {
        position: absolute;
        top: 5px;
        right: 10px;
    }
</style>
