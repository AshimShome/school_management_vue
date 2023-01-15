<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("class_routine") }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none" v-if="checkPermission('routine-create')">
                    <div class="d-flex">
                        <router-link :to="{ name: 'academic-routine-create' }" class="btn btn-primary btn-outline">
                            <icon-plus></icon-plus>
                            {{ $t("create") }}
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-md-2 col-sm-12">
                        <select v-model="searchForm.class_id" class="form-control" @change="loadSerachFormSections">
                            <option value="" class="d-none">
                                {{ $t("select_class") }}
                            </option>
                            <option v-for="singleClass in classes" :key="singleClass.id" :value="singleClass.id">
                                {{ singleClass.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-2 col-lg-2" v-if="searchForm.class_id">
                        <select v-model="searchForm.section_id" class="form-control">
                            <option value="" class="d-none">
                                {{ $t("select_section") }}
                            </option>
                            <option v-for="section in sections" :key="section.id" :value="section.id">
                                {{ section.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-2 d-flex" v-if="searchForm.class_id && searchForm.section_id">
                        <button :disabled="searchButtonDisabled" @click="getRoutines" class="btn btn-primary mx-1 h-40">
                            {{ $t("get_routine") }}
                        </button>
                        <button :disabled="searchButtonDisabled" @click="getRoutinesPreview" class="btn btn-primary h-40">
                            {{ $t("preview_routine") }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 my-3" v-if="searchForm.class_id && searchForm.section_id && showInfo">
                <div class="card bg-secondary text-white">
                    <div class="card-body">
                        <div class="text-center">
                            <h2>{{ $t("class_routine") }}</h2>
                            <h4>{{ $t("class") }} : {{ getClassName.name }}</h4>
                            <h5>{{ $t("section") }} : {{ getSectionName.name }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-3" v-if="showRoutinePreview && calendarData && weekDays">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3>{{ $t("class_routine") }}</h3>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <ClassRoutine :calendarData="calendarData" :weekDays="weekDays"/>
                    </div>
                </div>
            </div>
            <div class="col-12" v-else-if="!showRoutinePreview">
                <div class="card mb-4" v-for="(dayRoutines, index) in routines" :key="index">
                    <div class="card-header">
                        <h2 class="card-title">{{ getWeekname(dayRoutines[0].weekday) }} {{ dayRoutines[0].weekday }}</h2>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-vcenter text-nowrap">
                            <thead>
                                <tr>
                                    <th>{{ $t("subject") }}</th>
                                    <th>{{ $t("teacher") }}</th>
                                    <th>{{ $t("room") }}</th>
                                    <th>{{ $t("time") }}</th>
                                    <th v-if="
                      checkPermission('routine-edit') ||
                      checkPermission('routine-delete')
                    ">
                                        {{ $t("action") }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="routine in dayRoutines" :key="routine.id">
                                    <td>{{ routine.subject.name }}</td>
                                    <td>{{ routine.teacher.user.name }}</td>
                                    <td>{{ routine.class_room.room_no }}</td>
                                    <td>{{ routine.start_time }} - {{ routine.end_time }}</td>
                                    <td>
                                        <router-link :to="{
                        name: 'academic-routine-edit',
                        params: { id: routine.id },
                      }" class="btn btn-primary btn-sm" v-if="checkPermission('routine-edit')">
                                            {{ $t("edit") }}
                                        </router-link>
                                        <button class="btn btn-danger btn-sm" @click="deleteRoutine(routine.id)"
                                            v-if="checkPermission('routine-delete')">
                                            {{ $t("delete") }}
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div v-else class="d-flex justify-content-center py-3">
                <NotFound word="class routine" />
            </div>
        </div>

        <!-- delete modal  -->
        <DeleteModal :isShow="isDeleteModalShow" @close-modal="toggleDeleteModal" @delete-data="deleteData" />
    </div>
</template>

<script>
import { mixin as clickaway } from "vue-clickaway";
import ClassRoutine from "../../../../components/academic/ClassRoutine.vue";
import NotFound from "../../../../components/NotFound.vue";
import ButtonLoading from "../../../../components/ButtonLoading.vue";
import CardDropdown from "../../../../components/academic/CardDropdown.vue";
import DeleteModal from "../../../../components/modal/DeleteModal.vue";
import { mapGetters } from "vuex";
export default {
    mixins: [clickaway],
    components: {
        ClassRoutine,
        NotFound,
        ButtonLoading,
        CardDropdown,
        DeleteModal
    },
    computed: {
        ...mapGetters({
            sessions: "session/sessions",
            classes: "classs/classes",
            class_rooms: "classs/classrooms"
        }),
        searchButtonDisabled() {
            return (
                this.searchForm.session_id == "" ||
                this.searchForm.class_id == "" ||
                this.searchForm.section_id == ""
            );
        },
        getClassName() {
            return this.classes.find(
                item => item.id == this.searchForm.class_id
            );
        },
        getSectionName() {
            return this.sections.find(
                item => item.id == this.searchForm.section_id
            );
        }
    },
    watch: {
        "form.class_id"(to, from) {
            this.loadSections();
        }
    },
    data() {
        return {
            weekDays: [],
            calendarData: [],

            searchForm: new Form({
                class_id: "",
                section_id: ""
            }),
            isModalShow: false,
            isDeleteModalShow: false,
            selectedId: "",
            isEditMode: false,
            teachers: [],
            sections: [],
            subjects: [],

            form: new Form({
                session_id: "",
                class_id: "",
                section_id: "",
                subject_id: "",
                teacher_id: "",
                class_room_id: "",
                day: "",
                start_time: "",
                end_time: ""
            }),
            routines: [],
            routinesPreview: null,
            showInfo: false,
            showRoutinePreview: false
        };
    },
    methods: {
        deleteRoutine(id) {
            this.selectedId = id;
            this.isDeleteModalShow = true;
        },
        async getRoutines() {
            try {
                const response = await axios.post(
                    `/api/get-class-routines`,
                    this.searchForm
                );
                this.routines = response.data;
                this.showInfo = true;
                this.showRoutinePreview = false;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async getRoutinesPreview() {
            try {
                const response = await axios.post(
                    `/api/get-class-routines-preview`,
                    this.searchForm
                );

                this.showInfo = true;
                this.showRoutinePreview = true;

                this.weekDays = response.data.weekDays;
                this.calendarData = response.data.calendarData;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async loadSerachFormSections() {
            try {
                const response = await axios.get(
                    `/api/classes/${this.searchForm.class_id}/sections`
                );
                this.sections = response.data.sections;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },

        async loadSections() {
            try {
                const response = await axios.get(
                    `/api/classes/${this.form.class_id}/sections`
                );
                this.sections = response.data.sections;
                this.loadSubjects();
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async loadSubjects() {
            try {
                let response = await axios.get(
                    `/api/classes/${this.form.class_id}/subjects`
                );
                this.subjects = response.data.subjects;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async deleteData() {
            try {
                const response = await axios.delete(
                    `/api/remove-class-routines/${this.selectedId}`
                );
                this.toggleDeleteModal();
                this.toastSuccess(response.data.message);
                this.routines = this.routines.filter(
                    item => item.id !== this.selectedId
                );
                this.routines.splice(this.routines.indexOf(this.selectedId), 1);
            } catch (err) {
                this.toastError();
            }
        },
        toggleDeleteModal() {
            this.isDeleteModalShow = !this.isDeleteModalShow;
            this.selectedId = "";
        },
        async getAllTeachers() {
            try {
                const response = await axios.get("/api/get-all-teachers");
                this.teachers = response.data;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        getWeekname(weekno) {
            const week = [
                "",
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday",
                "Saturday",
                "Sunday"
            ];
            return week[weekno];
        }
    },
    created() {
        this.hasPermisssion("routine-list");
        this.$store.dispatch("session/fetchSessions");
        this.$store.dispatch("classs/fetchClasses");
        this.$store.dispatch("classs/fetchClassrooms");
        this.getAllTeachers();
    }
};
</script>

<style lang="scss" scoped>
    td {
        padding: 0;
    }

    tr td:first-of-type {
        padding: 0.5rem;
        text-transform: capitalize;
    }
</style>
