<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("academic") }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none" v-if="checkPermission('subject-create')">
                    <div class="d-flex">
                        <a href="#" @click="toggleModalShow" class="btn btn-primary btn-outline">
                            <icon-plus></icon-plus>
                            {{ $t("create") }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cards">
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-md-2">
                        <select v-model="search_class_id" class="form-control">
                            <option class="d-none" value="">
                                {{ $t("select_class") }}
                            </option>
                            <option v-for="classs in classes" :key="classs.id" :value="classs.id">
                                {{ classs.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2" v-if="search_class_id">
                        <a href="#" @click="getClassSubjects" class="btn btn-primary btn-outline">
                            {{ $t("get_subjects") }}
                        </a>
                    </div>
                </div>
            </div>
            <template v-if="subjects && subjects.length">
                <div class="col-xl-3 col-lg-6 col-md-6" v-for="subject in subjects" :key="subject.id">
                    <div class="card">
                        <div class="card-img-top img-responsive img-responsive-16by9"
                            :style="{ backgroundImage: 'url(' + subject.image_url + ')' }"></div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h2 class="font-weight-bold mb-0 pb-0">
                                    {{ subject.name }}
                                    <span v-tooltip="'Subject Code'">({{ subject.code }})</span>
                                </h2>
                                <div v-if="checkPermission('subject-delete') || checkPermission('subject-edit')">
                                    <span class="cursor-pointer" v-if="checkPermission('subject-edit')"
                                        @click="editData(subject)">
                                        <icon-edit />
                                    </span>
                                    <span class="cursor-pointer" v-if="checkPermission('subject-delete')"
                                        @click="deleteConfirmation(subject.id)">
                                        <icon-trash />
                                    </span>
                                </div>
                            </div>
                            <dl class="row">
                                <dt class="col-5">Type:</dt>
                                <dd class="col-7">{{ subject.type | capitalize }}</dd>
                                <dt class="col-5">Pass Marks:</dt>
                                <dd class="col-7">
                                    {{ subject.pass_marks }} Out of {{ subject.total_marks }}
                                </dd>
                            </dl>
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
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content" v-on-clickaway="reset">
                        <button @click="reset" type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                        <div class="modal-header">
                            <h5 v-if="!isEditMode" class="modal-title">
                                {{ $t("create_subject") }}
                            </h5>
                            <h5 v-else class="modal-title">
                                {{ $t("update_subject") }}
                            </h5>
                            <button @click="toggleModalShow" type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form @submit.prevent="save" autocomplete="off">
                            <div class="modal-body py-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">{{ $t("class") }}</label>
                                            <v-select :class="{ 'is-invalid': form.errors.has('class_id') }" value="id"
                                                label="name" :placeholder="$t('select_class')" v-model="form.class_id"
                                                :options="classes.map((classs) => ({ id: classs.id, name: classs.name}))" />
                                            <has-error :form="form" field="class_id" class="d-block"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">{{ $t("name") }}</label>
                                            <input v-model="form.name" type="text" class="form-control"
                                                :class="{ 'is-invalid': form.errors.has('name') }"
                                                :placeholder="$t('enter_name')" />
                                            <has-error :form="form" field="name"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <base-label :title="isEditMode ? $t('change_image') : $t('image')" />
                                            <input @change="onImageChange"
                                                :class="{ 'is-invalid': form.errors.has('image') }" type="file"
                                                class="form-control" accept="image/png, image/jpeg, image/jpg" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">{{ $t("code") }}</label>
                                            <input v-model="form.code" type="text" class="form-control"
                                                :class="{ 'is-invalid': form.errors.has('code') }"
                                                :placeholder="$t('enter_code')" />
                                            <has-error :form="form" field="code"></has-error>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">{{ $t("type") }}</label>
                                            <select class="form-control" v-model="form.type"
                                                :class="{ 'is-invalid': form.errors.has('type') }">
                                                <option value="theory">
                                                    {{ $t("theory") }}
                                                </option>
                                                <option value="practical">
                                                    {{ $t("practical") }}
                                                </option>
                                            </select>
                                            <has-error :form="form" field="type"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-label">{{ $t("optional") }}</div>
                                            <div>
                                                <label class="form-check form-check-inline">
                                                    <input value="1" v-model="form.is_optional" class="form-check-input"
                                                        type="radio" :checked="form.is_optional" />
                                                    <span class="form-check-label">{{ $t("yes") }}</span>
                                                </label>
                                                <label class="form-check form-check-inline">
                                                    <input value="0" v-model="form.is_optional"
                                                        :checked="!form.is_optional" class="form-check-input"
                                                        type="radio" />
                                                    <span class="form-check-label">{{ $t("no") }}</span>
                                                </label>
                                            </div>
                                            <has-error :form="form" field="is_optional" class="d-block"></has-error>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ $t("pass_marks") }}</label>
                                            <input v-model="form.pass_marks" type="text" class="form-control"
                                                :class="{ 'is-invalid': form.errors.has('pass_marks') }"
                                                :placeholder="$t('enter_pass_marks')" />
                                            <has-error :form="form" field="pass_marks"></has-error>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">{{ $t("total_marks") }}</label>
                                            <input v-model="form.total_marks" type="text" class="form-control" :class="{'is-invalid':form.errors.has('total_marks')}" :placeholder="$t('enter_total_marks')" />
                                            <has-error :form="form" field="total_marks"></has-error>
                                        </div>
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
                name: "",
                image: "",
                class_id: "",
                code: "",
                is_optional: 0,
                type: "theory",
                pass_marks: "40",
                total_marks: "100"
            }),
            subjects: [],
            classes: [],
            search_class_id: ""
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
                    let { data } = await this.form.post("/api/subjects", {
                        transformRequest: [
                            function(data, headers) {
                                return serialize(data);
                            }
                        ]
                    });

                    this.subjects.push(data.subject);
                    this.reset();
                    this.toastSuccess(data.message);
                } catch (err) {
                    this.toastError();
                }
            } else {
                try {
                    let { data } = await this.form.post(
                        `/api/subjects/${this.selectedId}/update`,
                        {
                            transformRequest: [
                                function(data, headers) {
                                    return serialize(data);
                                }
                            ]
                        }
                    );

                    console.log(data);
                    this.subjects.splice(
                        this.subjects.indexOf(this.form.id),
                        1,
                        data.subject
                    );

                    const pos = this.subjects
                        .map(e => e.id)
                        .indexOf(data.subject.id);
                    this.subjects.splice(pos, 1, data.subject);

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

            let obj_class = this.classes.filter(
                classs => classs.id == data.class_id
            );
            this.form.class_id = obj_class[0];
        },
        deleteConfirmation(id) {
            this.selectedId = id;
            this.isDeleteModalShow = true;
        },
        async deleteData() {
            try {
                const response = await axios.delete(
                    `/api/subjects/${this.selectedId}`
                );
                this.subjects.splice(this.subjects.indexOf(this.selectedId), 1);

                this.reset();
                this.toggleDeleteModal();
                this.toastSuccess(data.message);
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
        async getClassSubjects() {
            let response = await axios.get(
                `/api/classes/${this.search_class_id}/subjects`
            );
            this.subjects = response.data.subjects;
        },
        reset() {
            this.isEditMode = false;
            this.isModalShow = false;
            this.selectedId = "";
            this.form.reset();
            this.form.clear();
        },
        async loadClasses() {
            let response = await axios.get("/api/subjects/allclasses");
            this.classes = response.data.classes;
        },
        async dataExistsChecking() {
            if (!this.classes.length) {
                this.toastWarning("Please create class first");
                this.redirect("academic-class");
            }
        }
    },
    computed: {
        sections() {
            return this.$store.getters["section/sections"];
        },
        emptyData() {
            let data = this.subjects && this.subjects.length;

            if (data) {
                return false;
            } else {
                return true;
            }
        }
    },
    async created() {
        await this.hasPermisssion("subject-list");
        await this.loadClasses();
        await this.dataExistsChecking();
        this.search_class_id = this.classes[0].id;
        this.getClassSubjects();
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
