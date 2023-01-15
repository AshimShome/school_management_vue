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
                        <router-link :to="{ name: 'exam-schedule-create' }" class="btn btn-primary btn-outline"
                            @click.prevent="createSchedule" v-if="checkPermission('exam-schedule-create')">
                            <icon-plus></icon-plus>
                            {{ $t("create") }}
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 mb-3">
                <div class="row justify-content-center">
                    <div class="col-md-3 col-xl-2">
                        <select class="form-control mb-3" v-model="search_form.exam_id">
                            <option value="" class="d-none">{{ $t("select_exam") }}</option>
                            <option v-for="exam in exams" :key="exam.id" :value="exam.id">
                                {{ exam.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3 col-xl-2" v-if="search_form.exam_id">
                        <button :disabled="!search_form.exam_id" @click="loadSchedule"
                            class="btn btn-primary btn-outline">
                            {{ $t("get_exam") }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-12" v-if="classes">
                <div class="card mb-3" v-for="(exam_schedules, index) in classes" :key="index">
                    <div class="card-header">
                        <div class="card-title">
                            <h3>{{ $t("class") }}: {{ exam_schedules[0].classs.name }}</h3>
                        </div>
                    </div>
                    <div class="card-body text-center table-responsive">
                        <table class="table table-bordered table-vcenter text-nowrap">
                            <thead>
                                <tr>
                                    <th>{{ $t("sl") }}</th>
                                    <th>{{ $t("exam") }}</th>
                                    <th>{{ $t("room") }}</th>
                                    <th>{{ $t("subject") }}</th>
                                    <th>{{ $t("section") }}</th>
                                    <th>{{ $t("time") }}</th>
                                    <th v-if="checkPermission('exam-schedule-edit') || checkPermission('exam-schedule-delete')" width="20%">
                                        {{ $t("action") }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(schedule, i) in exam_schedules" :key="schedule.id">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ schedule.exam.name }}</td>
                                    <td>{{ schedule.room.room_no }}</td>
                                    <td>{{ schedule.subject.name }}</td>
                                    <td>{{ schedule.section.name }}</td>
                                    <td>
                                        <b>{{ formateDate(schedule.exam_date) }}</b> <br />
                                        <span v-if="schedule.start_time && schedule.end_time">
                                            {{ schedule.start_time }} - {{ schedule.end_time }}
                                        </span>
                                        <span v-else> {{ $t("not_set") }} </span>
                                    </td>
                                    <td v-if="checkPermission('exam-schedule-edit') || checkPermission('exam-schedule-delete')">
                                        <router-link :to="{ name: 'exam-schedule-edit', params: { id: schedule.id } }" class="btn btn-primary" v-if="checkPermission('exam-schedule-edit')">
                                            {{ $t("edit") }}
                                        </router-link>
                                        <DeleteButton v-if="checkPermission('exam-schedule-delete')" :id="schedule.id" :index="index" :i="i"
                                            @delete-data="deleteData" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div v-else class="py-3">
                <NotFound word="Schedules" />
            </div>
        </div>
    </div>
</template>

<script>
import DeleteModal from "../../../../components/modal/DeleteModal.vue";
import NotFound from "../../../../components/NotFound.vue";

export default {
    components: {
        DeleteModal,
        NotFound,
        DeleteButton: () =>
            import("../../../../components/DeleteConfirmation.vue")
    },
    data() {
        return {
            schedules: [],
            classes: [],
            search_form: new Form({
                exam_id: ""
            }),
            show_modal: false,
            edit_mode: false,
            edit_item: {}
        };
    },
    methods: {
        async loadSchedule() {
            try {
                const response = await axios.get(
                    `/api/exams/${this.search_form.exam_id}/schedules`
                );
                this.classes = response.data;
                console.log(this.classes)
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        createSchedule() {
            this.show_modal = true;
        },
        hideModal() {
            this.show_modal = false;
            this.edit_mode = false;
        },
        edit(item) {
            this.edit_item = item;
            this.edit_mode = true;
            this.show_modal = true;
        },
        async deleteData(id,index,i) {
            console.log(this.classes[index][i]);
            this.classes[index][i].splice(i,-1);

            try {
                const response = await axios.delete(
                    `/api/exam-schedules/${id}`
                );
                // this.toastSuccess(response.data.message);
                // this.schedules = this.schedules.filter(
                //     schedule => schedule.id != id
                // );
            } catch (error) {
                console.log(error);
                // this.toastError(error.response.data.message);
            }
        },
        async loadExamBySession() {
            try {
                const response = await axios.post("/api/exams-by-session", {
                    session_id: this.search_form.session_id
                });
                this.exams = response.data.data;
                console.log(response);
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        }
    },
    computed: {
        exams() {
            return this.$store.getters["exam/examList"];
        }
    },
    async created() {
        await this.hasPermisssion("exam-schedule-list");
        this.$store.dispatch("exam/fetchExamsList");
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

    select {
        margin-bottom: 0;
    }

    .form-group {
        margin-bottom: 15px;
    }
</style>
