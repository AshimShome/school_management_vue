<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("announcement") }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none" v-if="checkPermission('calendar-create')">
                    <div class="d-flex">
                        <a href="#" @click="toggleModalShow" class="btn btn-primary btn-outline">
                            <icon-plus></icon-plus>
                            {{ $t("create") }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="alert alert-primary">
                {{ $t("click_the_event_to_edit_or_delete") }}
            </div>
        </div>

        <div class="card">
            <div class="card-header">{{ $t("event_calendar") }}</div>
            <div class="card-body">
                <Fullcalendar :plugins="calendarPlugins" :events="events" :header="{
            right: 'prev today next',
          }" :selectable="true" @eventClick="eventClick" />
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
                            <h5 class="modal-title">{{ $t("create_event") }}</h5>
                            <button @click="toggleModalShow" type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form @submit.prevent="save" autocomplete="off">
                            <div class="modal-body py-4">
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label">{{ $t("event_title") }}</label>
                                        <input v-model="form.event_name" type="text" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('event_name') }"
                                            :placeholder="$t('enter_event_title')" />
                                        <has-error :form="form" field="event_name"></has-error>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">{{ $t("starting_date") }}</label>
                                        <date-picker format="dd MMMM, yyyy" @input="startDate($event)"
                                            input-class="form-control" :placeholder="$t('select_date')"
                                            :value="form.start_date" />
                                        <has-error :form="form" field="start_date"></has-error>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ $t("ending_date") }}</label>
                                        <date-picker format="dd MMMM, yyyy" @input="endDate($event)"
                                            input-class="form-control" :placeholder="$t('select_date')"
                                            :value="form.end_date" />
                                        <has-error :form="form" field="end_date"></has-error>
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

        <!-- Edit Modal -->
        <transition name="fade">
            <div v-if="isEditModalShow" class="modal modal-blur fade show modal-hidee"
                id="modal-danger" tabindex="-1" role="dialog"
                aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                    <div class="modal-content" v-on-clickaway="toggleEditModal">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $t("edit_event") }}</h5>
                            <button @click="toggleEditModal" type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form @submit.prevent="update" autocomplete="off">
                            <div class="modal-body py-4">
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label">{{ $t("event_title") }}</label>
                                        <input v-model="form.event_name" type="text" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('event_name') }"
                                            :placeholder="$t('enter_event_title')" />
                                        <has-error :form="form" field="event_name"></has-error>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">{{ $t("starting_date") }}</label>
                                        <date-picker format="dd MMMM, yyyy" @input="startDate($event)"
                                            input-class="form-control" :placeholder="$t('select_date')"
                                            :value="form.start_date" />
                                        <has-error :form="form" field="start_date"></has-error>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ $t("ending_date") }}</label>
                                        <date-picker format="dd MMMM, yyyy" @input="endDate($event)"
                                            input-class="form-control" :placeholder="$t('select_date')"
                                            :value="form.end_date" />
                                        <has-error :form="form" field="end_date"></has-error>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button @click="eventDelete" type="button" class="btn btn-danger me-auto"
                                    v-if="checkPermission('calendar-delete')">
                                    {{ $t("delete") }}
                                </button>
                                <template v-if="checkPermission('calendar-edit')">
                                    <button-loading v-if="form.busy" />
                                    <button v-else type="submit" class="btn btn-primary" data-bs-dismiss="modal">
                                        {{ $t("save") }}
                                    </button>
                                </template>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    import dayjs from "dayjs";
    import {
        mixin as clickaway
    } from "vue-clickaway";
    import ButtonLoading from "../../../components/ButtonLoading.vue";
    import Fullcalendar from "@fullcalendar/vue";
    import dayGridPlugin from "@fullcalendar/daygrid";
    import timeGridPlugin from "@fullcalendar/timegrid";
    import listPlugin from "@fullcalendar/list";
    import interactionPlugin from "@fullcalendar/interaction";
    import {
        mapGetters
    } from "vuex";

    export default {
        mixins: [clickaway],
        components: {
            ButtonLoading,
            Fullcalendar,
        },
        data() {
            return {
                isModalShow: false,
                isEditModalShow: false,
                form: new Form({
                    event_name: "",
                    start_date: "",
                    end_date: "",
                }),
                selectedId: "",
                calendarPlugins: [
                    dayGridPlugin,
                    interactionPlugin,
                    timeGridPlugin,
                    listPlugin,
                ],
            };
        },
        methods: {
            eventClick(e) {
                this.form.start_date = e.event.start.toLocaleDateString("fr-CA");
                this.form.end_date = e.event.end.toLocaleDateString("fr-CA");
                this.form.event_name = e.event.title;
                this.selectedId = e.event.id;
                this.isEditModalShow = true;
            },
            toggleModalShow() {
                this.isModalShow = !this.isModalShow;
                this.form.clear();
            },
            toggleEditModal() {
                this.isEditModalShow = !this.isEditModalShow;
                this.selectedId = "";
            },
            async save() {
                try {
                    let response = await this.form.post("/api/calendars");
                    this.reset();
                    this.loadData();
                    this.toastSuccess(response.data.message);
                } catch (e) {
                    this.toastError();
                }
            },
            async update() {
                if (this.checkPermission("calendar-edit")) {
                    try {
                        let response = await this.form.put(
                            `/api/calendars/${this.selectedId}`
                        );
                        this.isEditModalShow = false;
                        this.loadData();
                        this.toastSuccess(response.data.message);
                    } catch (e) {
                        this.toastError();
                    }
                } else {
                    this.toastError("You do not have permission to update this event.");
                }
            },
            async eventDelete() {
                if (this.checkPermission("calendar-delete")) {
                    try {
                        let response = await axios.delete(
                            `/api/calendars/${this.selectedId}`
                        );
                        this.isEditModalShow = false;
                        this.loadData();
                        this.toastSuccess(response.data.message);
                    } catch (e) {
                        this.toastError();
                    }
                } else {
                    this.toastError("You do not have permission to delete this event.");
                }
            },
            reset() {
                this.isModalShow = false;
                this.form.reset();
                this.form.clear();
            },
            startDate(event) {
                const formatTime = dayjs(event).format("YYYY-MM-DD");
                this.form.start_date = formatTime;
            },
            endDate(event) {
                const formatTime = dayjs(event).format("YYYY-MM-DD");
                this.form.end_date = formatTime;
            },
            async loadData() {
                await this.$store.dispatch("calendar/fetchEvents");
            },
        },
        computed: {
            ...mapGetters({
                events: "calendar/events",
            }),
        },
        async created() {
            await this.hasPermisssion("calendar-list");
            this.$store.dispatch("calendar/fetchEvents");
        },
    };
</script>

<style lang="css">
    @import "~@fullcalendar/core/main.css";
    @import "~@fullcalendar/daygrid/main.css";

    @media (max-width: 420px) {
        .fc-left h2 {
            font-size: 17px;
        }
        .fc-button {
            font-size: 8px;
        }
    }
    .fc-content:hover {
        cursor: pointer;
    }
</style>
