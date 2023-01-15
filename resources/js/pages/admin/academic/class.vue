<template>
  <div>
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <h2 class="page-title">{{ $route.meta.title }}</h2>
          <h2 class="page-pretitle">{{ $t("academic") }}</h2>
        </div>
        <div
          class="col-auto ms-auto d-print-none"
          v-if="checkPermission('class-create')"
        >
          <div class="d-flex">
            <a
              href="#"
              @click="toggleModalShow"
              class="btn btn-primary btn-outline"
            >
              <icon-plus></icon-plus>
              {{ $t("create") }}
            </a>
          </div>
        </div>
        <div class="row row-cards mt-2">
            <template v-if="classes && classes.length">
                <div v-for="classs in classes" :key="classs.id" class="col-md-6 col-xl-3">
                    <div class="card user-card">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <span class="avatar avatar-xl avatar-rounded">{{
                  classs.numeric
                }}</span>
                            </div>
                            <div class="card-title mb-1">
                                {{ $t("class") }}: <b>{{ classs.name }}</b>
                            </div>
                            <div class="text-muted">
                                {{ $t("sections") }}:
                                <template v-if="classs.sections && classs.sections.length">
                                    <span v-for="section in classs.sections" :key="section.id">
                                        {{ section.name }}
                                    </span>
                                </template>
                                <span v-else>{{ $t("no_sections") }}</span>
                            </div>
                            <CardDropdown v-if="
                  checkPermission('class-delete') ||
                  checkPermission('class-edit')
                " :canEdit="checkPermission('class-edit')" :canDelete="checkPermission('class-delete')" :data="classs"
                                @edit-data="editData" @delete-data="deleteConfirmation" />
                        </div>
                    </div>
                </div>
            </template>
            <div v-else class="d-flex justify-content-center py-3">
                <NotFound word="class" />
            </div>
        </div>

        <!-- Modal  -->
        <transition name="fade">
            <div v-if="isModalShow" class="modal modal-blur fade show modal-hidee"
                id="modal-danger" tabindex="-1" role="dialog"
                aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <button @click="reset" type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                        <div class="modal-header">
                            <h5 v-if="!isEditMode" class="modal-title">
                                {{ $t("create_class") }}
                            </h5>
                            <h5 v-else class="modal-title">{{ $t("update_class") }}</h5>
                            <button @click="toggleModalShow" type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form @submit.prevent="save" autocomplete="off">
                            <div class="modal-body py-4">
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label">{{ $t("class") }} {{ $t("name") }}</label>
                                        <input v-model="form.name" type="text" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('name') }"
                                            :placeholder="$t('name')" />
                                        <has-error :form="form" field="name"></has-error>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">{{ $t("class_numeric") }}</label>
                                        <input v-model="form.numeric" type="text" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('numeric') }"
                                            :placeholder="$t('enter_class_numeric')" />
                                        <has-error :form="form" field="numeric"></has-error>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">{{ $t('sections') }}</label>
                                        <v-select :class="{ 'is-invalid': form.errors.has('sections') }" value="id"
                                            label="name" :placeholder="$t('select_section')" multiple
                                            v-model="form.sections" :options="
                        sections.map((section) => ({
                          id: section.id,
                          name: section.name,
                        }))
                      " />
                                        <has-error :form="form" field="sections" class="d-block"></has-error>
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
</div>
</div>
</template>

<script>
import ButtonLoading from "../../../components/ButtonLoading.vue";
import CardDropdown from "../../../components/academic/CardDropdown.vue";
import DeleteModal from "../../../components/modal/DeleteModal.vue";
import NotFound from "../../../components/NotFound.vue";

export default {
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
                numeric: "",
                sections: []
            }),

            sections: []
        };
    },
    methods: {
        toggleModalShow() {
            if (!this.sections.length) {
                this.toastWarning("Please create section first");
                this.redirect("academic-section");
            } else {
                this.isModalShow = !this.isModalShow;
                this.form.clear();
            }
        },
        toggleDeleteModal() {
            this.isDeleteModalShow = !this.isDeleteModalShow;
            this.selectedId = "";
        },
        async save() {
            try {
                if (!this.isEditMode) {
                    let { data } = await this.form.post("/api/classes");
                    this.toastSuccess(data.message);
                } else {
                    let { data } = await this.form.put(
                        `/api/classes/${this.selectedId}`
                    );
                    this.toastSuccess(data.message);
                }

                this.loadClasses();
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
            this.loadClassSection(data.id);
        },
        deleteConfirmation(id) {
            this.selectedId = id;
            this.isDeleteModalShow = true;
        },
        async deleteData() {
            try {
                const response = await axios.delete(
                    `/api/classes/${this.selectedId}`
                );
                this.$store.commit("classs/REMOVE_CLASS", this.selectedId);

                this.reset();
                this.toggleDeleteModal();
                this.toastSuccess("Class delete successfully!");
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
        async loadClasses() {
            await this.$store.dispatch("classs/fetchClasses");
        },
        async loadSections() {
            let response = await axios.get("/api/allsections");
            this.sections = response.data.sections;
        },
        async loadClassSection(class_id) {
            let response = await axios.get(`/api/classes/${class_id}`);
            this.form.sections = response.data.sections;
        }
    },
    computed: {
        classes() {
            return this.$store.getters["classs/classes"];
        },
        emptyData() {
            return this.classes.length;
        }
    },
    created() {
        this.hasPermisssion("class-list");
        this.loadClasses();
        this.loadSections();
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
