<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("accountant") }}</h2>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title">{{ $t("create_new_accountant") }}</h3>
                    <Back routeName="user-accountant" />
                </div>
                <div class="card-body border-bottom py-3">
                    <form autocomplete="off" @submit.prevent="addTeacher">
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <div class="form-group row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">{{ $t("name") }}
                                        </label>
                                        <base-input :form="accountantForm" field="name" v-model="accountantForm.name">
                                        </base-input>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">{{ $t("email") }}</label>
                                        <base-input :form="accountantForm" field="email" v-model="accountantForm.email">
                                        </base-input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">{{ $t("password") }}</label>
                                        <base-input :form="accountantForm" inputType="password" field="password"
                                            v-model="accountantForm.password">
                                        </base-input>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">{{ $t("phone") }}
                                        </label>
                                        <base-input :form="accountantForm" field="phone" v-model="accountantForm.phone">
                                        </base-input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 mb-3">
                                        <label for="joining_letter" class="form-label">
                                            {{ $t("joining_letter") }}
                                        </label>
                                        <input @change="handleJoiningLetterUpload" :class="{ 'is-invalid': accountantForm.errors.has('joining_letter') }" type="file" class="form-control" ref="joining_letter" />
                                        <has-error :form="accountantForm" field="joining_letter"></has-error>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="resume" class="form-label">
                                            {{ $t("resume") }}
                                        </label>
                                        <input @change="handleResumeUpload" :class="{ 'is-invalid': accountantForm.errors.has('resume') }" type="file" class="form-control" ref="resume" />
                                        <has-error :form="accountantForm" field="resume"></has-error>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 mb-3">
                                        <label for="resume" class="form-label">
                                            {{ $t("joining_date") }}
                                        </label>
                                        <date-picker format="dd MMMM, yyyy" @input="setDate($event)"
                                            input-class="form-control" :placeholder="$t('select_date')"
                                            :value="accountantForm.joining_date" />
                                        <has-error :form="accountantForm" field="joining_date" class="d-block">
                                        </has-error>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ $t("gender") }}</label>
                                        <div>
                                            <label class="form-check form-check-inline">
                                                <input v-model="accountantForm.gender" class="form-check-input"
                                                    type="radio" value="male" />
                                                <span class="form-check-label">{{ $t("male") }}</span>
                                            </label>
                                            <label class="form-check form-check-inline">
                                                <input v-model="accountantForm.gender" class="form-check-input"
                                                    type="radio" value="female" />
                                                <span class="form-check-label">{{ $t("female") }}</span>
                                            </label>
                                        </div>
                                        <has-error :form="accountantForm" field="name"></has-error>
                                    </div>
                                </div>
                                <div class="form-footer text-center">
                                    <base-button :loading="accountantForm.busy">
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
import dayjs from "dayjs";
import { serialize } from "object-to-formdata";
export default {
    data() {
        return {
            accountantForm: new Form({
                name: "",
                email: "",
                password: "",
                joining_date: "",
                phone: "",
                gender: "male",
                resume: "",
                joining_letter: ""
            })
        };
    },
    methods: {
        setDate(event) {
            const formatTime = dayjs(event).format("YYYY-MM-DD");
            this.accountantForm.joining_date = formatTime;
        },
        handleJoiningLetterUpload() {
            this.accountantForm.joining_letter = this.$refs.joining_letter.files[0];
        },
        handleResumeUpload() {
            this.accountantForm.resume = this.$refs.resume.files[0];
        },
        async addTeacher() {
            try {
                const response = await this.accountantForm.post(
                    "/api/accountants",
                    {
                        transformRequest: [
                            function(data, headers) {
                                return serialize(data);
                            }
                        ]
                    }
                );

                this.accountantForm.reset();
                this.accountantForm.clear();
                this.$refs.joining_letter.value = "";
                this.$refs.resume.value = "";

                this.toastSuccess(response.data.message);
                this.$router.go(-1)
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        }
    },
    async mounted() {
        await this.hasPermisssion("accountant-create");
    }
};
</script>
