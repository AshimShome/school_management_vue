<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $t("edit_student") }}</h2>
                    <h2 class="page-pretitle">{{ $t("admin_setting") }}</h2>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title">{{ $t("edit_student") }}</h3>
                    <Back routeName="user-student" />
                </div>
                <div class="card-body border-bottom py-3">
                    <form autocomplete="off" @submit.prevent="updateStudent">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">{{ $t("name") }}
                                            <span class="text-danger">*</span></label>
                                        <div>
                                            <input v-model="studentForm.name" :class="{ 'is-invalid': studentForm.errors.has('name') }" type="text" class="form-control" :placeholder="$t('name')" />
                                            <has-error :form="studentForm" field="name"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">{{ $t("email") }}
                                            <span class="text-danger">*</span></label>
                                        <div>
                                            <input v-model="studentForm.email" :class="{ 'is-invalid': studentForm.errors.has('email') }" type="text" class="form-control" :placeholder="$t('email')" />
                                            <has-error :form="studentForm" field="email"></has-error>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">{{ $t("change_password") }}
                                            <span class="text-danger">*</span></label>
                                        <div>
                                            <input v-model="studentForm.password" :class="{ 'is-invalid': studentForm.errors.has('password') }" type="password" class="form-control" :placeholder="$t('enter_password')" />
                                            <has-error :form="studentForm" field="password"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">{{ $t('parent') }} <span class="text-danger">*</span></label>
                                        <div>
                                            <input id="guardian_id" class="form-control" type="text"
                                                :placeholder="$t('choose_a_parent')" :value="defaultGuardian.name"
                                                autocomplete="off" :class="{ 'is-invalid': studentForm.errors.has('parent_id') }" />
                                            <typeahead v-model="studentForm.parent_id" match-start
                                                :append-to-body="true" target="#guardian_id" item-key="name"
                                                :async-function="searchGuardian">
                                                <template slot="item" slot-scope="props">
                                                    <li v-for="(item, index) in props.items" class="typehead-list"
                                                        :class="{ active: props.activeIndex === index }" :key="index">
                                                        <a role="button" @click="props.select(item)" class="">
                                                            <img width="30px" height="30px"
                                                                :src="item.image_url + '&s=40'" />
                                                            <span v-html="props.highlight(item)"></span>
                                                        </a>
                                                    </li>
                                                </template>
                                            </typeahead>
                                            <has-error :form="studentForm" field="parent_id"></has-error>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">{{ $t('class') }} <span class="text-danger">*</span></label>
                                        <select v-model="studentForm.class_id" class="form-control mb-0"
                                            @change="getSections" :class="{ 'is-invalid': studentForm.errors.has('class_id') }">
                                            <option class="d-none" value="">{{ $t('select_class') }}</option>
                                            <option v-for="singleClass in classes" :key="singleClass.id"
                                                :value="singleClass.id">
                                                {{ singleClass.name }}
                                            </option>
                                        </select>
                                        <has-error :form="studentForm" field="class_id"></has-error>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">{{ $t('section') }} <span class="text-danger">*</span></label>
                                        <select v-model="studentForm.section_id" class="form-control mb-0" :class="{ 'is-invalid': studentForm.errors.has('section_id') }">
                                            <option class="d-none" value="">{{ $t('select_section') }}</option>
                                            <option v-for="section in sections" :key="section.id" :value="section.id">
                                                {{ section.name }}
                                            </option>
                                        </select>
                                        <has-error :form="studentForm" field="section_id"></has-error>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">{{ $t('roll_no') }} <span class="text-danger">*</span></label>
                                        <div>
                                            <input v-model="studentForm.roll_no" :class="{ 'is-invalid': studentForm.errors.has('roll_no') }" type="number" class="form-control" :placeholder="$t('roll_no')" />
                                            <has-error :form="studentForm" field="roll_no"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">{{ $t("admission_date") }} <span
                                                class="text-danger">*</span></label>
                                        <div>
                                            <date-picker format="dd MMMM, yyyy" @input="setDate($event)"
                                                input-class="form-control" :placeholder="$t('select_date')"
                                                :value="studentForm.admission_date" />
                                            <has-error :form="studentForm" field="admission_date"></has-error>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ $t("gender") }}</label>
                                    <div>
                                        <label class="form-check form-check-inline">
                                            <input v-model="studentForm.gender" class="form-check-input" type="radio"
                                                value="male" />
                                            <span class="form-check-label">{{ $t("male") }}</span>
                                        </label>
                                        <label class="form-check form-check-inline">
                                            <input v-model="studentForm.gender" class="form-check-input" type="radio"
                                                value="female" />
                                            <span class="form-check-label">{{ $t("female") }}</span>
                                        </label>
                                    </div>
                                    <has-error :form="studentForm" field="name"></has-error>
                                </div>
                                <div class="form-footer text-center">
                                    <base-button :loading="studentForm.busy">
                                        {{  $t("save") }}
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
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            studentForm: new Form({
                name: "",
                email: "",
                password: "",
                parent_id: "",
                class_id: "",
                section_id: "",
                roll_no: "",
                admission_date: "",
                gender: "male"
            }),
            student: null,
            sections: [],
            keyword: null,
            defaultGuardian: {}
        };
    },
    computed: {
        ...mapGetters({
            classes: "classs/classes"
        })
    },
    methods: {
        async getSections() {
            this.sections = [];
            const response = await axios.get(
                `/api/classes/${this.studentForm.class_id}/sections`
            );
            this.sections = response.data.sections;
        },
        searchGuardian(query, done) {
            axios
                .get(`/api/student/guardians?keyword=${escape(query)}`)
                .then(res => {
                    console.log(res);
                    done(res.data);
                })
                .catch(err => {
                    console.log(err);
                });
        },
        async updateStudent() {
            try {
                const response = await this.studentForm.put(
                    `/api/students/${this.student.id}`
                );
                this.$store.commit(
                    "student/UPDATE_STUDENT",
                    response.data.student
                );
                this.toastSuccess(response.data.message);
                this.redirect("user-student");
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async getStudent() {
            try {
                const studentId = this.$route.params.id;
                const response = await axios.get(`/api/students/${studentId}`);
                this.student = response.data;

                Object.keys(this.studentForm).forEach(k => {
                    if (this.student.hasOwnProperty(k)) {
                        this.studentForm[k] = this.student[k];
                    }
                    if (this.student.user.hasOwnProperty(k)) {
                        this.studentForm[k] = this.student.user[k];
                    }
                });

                const guardian = {
                    id: this.student.guardian.id,
                    name: this.student.guardian.user.name
                };
                this.defaultGuardian = guardian;
                this.studentForm.parent_id = guardian;

                this.getSections();
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async classChanged() {
            try {
                this.sections = [];
                const response = await axios.get(
                    `/api/classes/${this.studentForm.class_id}/sections`
                );
                this.sections = response.data.sections;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        }
    },
    async mounted() {
        if (!this.$route.params.id) {
            this.redirect("404");
        }
        await this.hasPermisssion("student-edit");
        await this.$store.dispatch("classs/fetchClasses");

        if (this.classes.length == 0) {
            this.redirect("academic-class");
            this.toastWarning("Please create class first");
        }

        this.getStudent();
        this.$store.dispatch("classs/fetchClasses");
    }
};
</script>

<style lang="scss" scoped>
    .style-chooser .vs__search::placeholder {
        color: #9a9b9a;
    }
</style>
