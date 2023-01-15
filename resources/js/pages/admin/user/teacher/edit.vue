<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("teacher") }}</h2>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title">{{ $t("edit_teacher") }}</h3>
                    <Back routeName="user-teacher" />
                </div>
                <div class="card-body border-bottom py-3">
                    <form autocomplete="off" @submit.prevent="updateTeacher">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">{{ $t("name") }}
                                        </label>
                                        <base-input :form="teacherForm" field="name" v-model="teacherForm.name">
                                        </base-input>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">{{ $t("email") }}</label>
                                        <base-input :form="teacherForm" field="email" v-model="teacherForm.email">
                                        </base-input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">{{ $t("change_password") }}</label>
                                        <base-input :form="teacherForm" field="password" inputType="password"
                                            v-model="teacherForm.password">
                                        </base-input>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">{{ $t("phone") }}
                                        </label>
                                        <base-input :form="teacherForm" field="phone" v-model="teacherForm.phone">
                                        </base-input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 mb-3">
                                        <label for="gender" class="form-label">
                                            {{ $t("department") }}
                                        </label>
                                        <base-select :form="teacherForm" field="department_id"
                                            v-model="teacherForm.department_id">
                                            <option value="" class="d-none">
                                                {{ $t("select_department") }}
                                            </option>
                                            <option v-for="department in departments" :key="department.id"
                                                :value="department.id"
                                                :selected="department.id == teacherForm.department_id">
                                                {{ department.name }}
                                            </option>
                                        </base-select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="resume" class="form-label">
                                            {{ $t("joining_date") }}
                                        </label>
                                        <date-picker format="dd MMMM, yyyy" @input="setDate($event)"
                                            input-class="form-control" :placeholder="$t('select_date')"
                                            :value="teacherForm.joining_date" />
                                        <has-error :form="teacherForm" field="joining_date"></has-error>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 mb-3">
                                        <label for="joining_letter" class="form-label">
                                            {{ $t("joining_letter") }}
                                        </label>
                                        <input @change="handleJoiningLetterUpload" :class="{ 'is-invalid': teacherForm.errors.has('joining_letter') }" type="file" class="form-control" ref="joining_letter" />
                                        <has-error :form="teacherForm" field="joining_letter"></has-error>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="resume" class="form-label">
                                            {{ $t("resume") }}
                                        </label>
                                        <input @change="handleResumeUpload" :class="{ 'is-invalid': teacherForm.errors.has('resume')  }" type="file" class="form-control" ref="resume" />
                                        <has-error :form="teacherForm" field="resume"></has-error>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label">{{ $t("gender") }}</label>
                                    <div>
                                        <label class="form-check form-check-inline">
                                            <input v-model="teacherForm.gender" class="form-check-input" type="radio"
                                                value="male" />
                                            <span class="form-check-label">{{ $t("male") }}</span>
                                        </label>
                                        <label class="form-check form-check-inline">
                                            <input v-model="teacherForm.gender" class="form-check-input" type="radio"
                                                value="female" />
                                            <span class="form-check-label">{{ $t("female") }}</span>
                                        </label>
                                    </div>
                                    <has-error :form="teacherForm" field="name"></has-error>
                                </div>
                                <div class="form-footer text-center">
                                    <base-button :loading="teacherForm.busy">
                                        {{ $t("save") }}
                                    </base-button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { serialize } from "object-to-formdata";
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            teacherForm: new Form({
                name: "",
                email: "",
                password: "",
                department_id: "",
                joining_date: "",
                phone: "",
                gender: "male",
                resume: "",
                joining_letter: ""
            }),
            teacher: null
        };
    },
    computed: {
        ...mapGetters({
            departments: "department/departments"
        })
    },
    methods: {
        handleJoiningLetterUpload() {
            this.teacherForm.joining_letter = this.$refs.joining_letter.files[0];
        },
        handleResumeUpload() {
            this.teacherForm.resume = this.$refs.resume.files[0];
        },
        async updateTeacher() {
            try {
                const response = await this.teacherForm.post(
                    `/api/teachers/${this.teacher.id}`,
                    {
                        transformRequest: [
                            function(data, headers) {
                                return serialize(data);
                            }
                        ]
                    }
                );

                this.redirect("user-teacher");
                this.$refs.joining_letter.value = "";
                this.$refs.resume.value = "";

                this.toastSuccess(response.data.message);
            } catch (error) {
                console.log(error);
            }
        },
        async getTeacher() {
            try {
                const teacherId = this.$route.params.id;
                const response = await axios.get(`/api/teachers/${teacherId}`);
                this.teacher = response.data.data;

                Object.keys(this.teacherForm).forEach(k => {
                    if (this.teacher.hasOwnProperty(k)) {
                        this.teacherForm[k] = this.teacher[k];
                    }
                    if (this.teacher.user.hasOwnProperty(k)) {
                        this.teacherForm[k] = this.teacher.user[k];
                    }
                });
            } catch (error) {
                if (error.response.status === 404) {
                    this.redirect("404");
                } else {
                    this.toastError("Something went wrong while saving data");
                }
            }
        }
    },
    async mounted() {
        if (!this.$route.params.id) {
            this.redirect("404");
        }
        await this.hasPermisssion("teacher-list");
        this.getTeacher();
        this.$store.dispatch("department/fetchDepartments");
    }
};
</script>

<style>
</style>
