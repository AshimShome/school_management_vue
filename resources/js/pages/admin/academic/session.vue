<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $t("session_list") }}</h2>
                    <h2 class="page-pretitle">{{ $t("academic") }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none" v-if="checkPermission('session-create')">
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
            <template v-if="sessions && sessions.length">
                <div v-for="session in sessions" :key="session.id" :class="` ${sessions.length <= 3 ? 'col-lg-4 col-md-3 col-sm-6 ' : 'col-lg-3 col-sm-6' } `">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="card-title mb-1">
                                {{ $t("year") }}: <b>{{ session.name }}</b>
                            </div>
                            <div class="card-body">{{ session.note }}</div>
                            <CardDropdown v-if="
                    checkPermission('session-delete') ||
                    checkPermission('session-edit')
                " :data="session" @edit-data="editData" @delete-data="deleteConfirmation"
                                :canEdit="checkPermission('session-edit')"
                                :canDelete="checkPermission('session-delete')" />
                        </div>
                    </div>
                </div>
            </template>
            <div v-else class="d-flex justify-content-center py-3">
                <NotFound word="sessions" />
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
                                {{ $t("session") }}
                            </h5>
                            <h5 v-else class="modal-title">{{ $t("update_session") }}</h5>
                            <button @click.prevent="reset" type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form @submit.prevent="save" autocomplete="off">
                            <div class="modal-body py-4">
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label">{{ $t("year") }}
                                            <span class="text-danger">*</span></label>
                                        <input v-model="form.name" type="text" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('name') }"
                                            :placeholder="$t('enter_year')" />
                                        <has-error :form="form" field="name"></has-error>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">{{ $t("note") }}</label>
                                        <input v-model="form.note" type="text" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('note') }"
                                            :placeholder="$t('enter_note')" />
                                        <has-error :form="form" field="note"></has-error>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button @click="reset" type="button" class="btn me-auto" data-bs-dismiss="modal">
                                    {{ $t("cancel") }}
                                </button>
                                <button-loading v-if="form.busy" />
                                <button v-else :disabled="!form.name" type="submit" class="btn btn-primary"
                                    data-bs-dismiss="modal">
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
                note: ""
            })
        };
    },
    methods: {
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
                    let { data } = await this.form.post("/api/sessions");
                    this.$store.commit("session/ADD_SESSION", data.session);
                    this.toastSuccess(data.message);
                    window.location.reload();
                } else {
                    let { data } = await this.form.put(
                        `/api/sessions/${this.selectedId}`
                    );
                    this.$store.commit("session/UPDATE_SESSION", data.session);

                    this.toastSuccess(data.message);
                    window.location.reload();
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
                await axios.delete(`/api/sessions/${this.selectedId}`);
                this.$store.commit("session/REMOVE_SESSION", this.selectedId);

                this.reset();
                this.toggleDeleteModal();

                this.toastSuccess("Academic session delete successfully!");
                window.location.reload();
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
        async loadSessions() {
            await this.$store.dispatch("session/fetchSessions");
        }
    },
    computed: {
        ...mapGetters({
            sessions: "session/sessions"
        }),
        emptyData() {
            return this.sessions.length;
        }
    },
    created() {
        this.hasPermisssion("session-list");
        this.loadSessions();
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
