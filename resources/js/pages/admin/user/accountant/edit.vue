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
                    <h3 class="card-title">{{ $t("edit_accountant") }}</h3>
                    <Back routeName="user-accountant" />
                </div>
                <div class="card-body border-bottom py-3">
                    <form autocomplete="off" @submit.prevent="updateTeacher">
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
                                        <base-input :form="accountantForm" inputType="password" field="email"
                                            v-model="accountantForm.email">
                                        </base-input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">{{ $t("change_password") }}</label>
                                        <base-input :form="accountantForm" field="password"
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
                                        <has-error :form="accountantForm" field="joining_date"></has-error>
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
            }),
            accountant: null
        };
    },
    methods: {
        handleJoiningLetterUpload() {
            this.accountantForm.joining_letter = this.$refs.joining_letter.files[0];
        },
        handleResumeUpload() {
            this.accountantForm.resume = this.$refs.resume.files[0];
        },
        async updateTeacher() {
            try {
                const response = await this.accountantForm.post(
                    `/api/accountants/${this.accountant.id}`,
                    {
                        transformRequest: [
                            function(data, headers) {
                                return serialize(data);
                            }
                        ]
                    }
                );
                this.redirect("user-accountant");
                this.$refs.joining_letter.value = "";
                this.$refs.resume.value = "";

                this.toastSuccess(response.data.message);
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async getAccountant() {
            try {
                const accountantId = this.$route.params.id;
                const response = await axios.get(
                    `/api/accountants/${accountantId}`
                );
                this.accountant = response.data.data;

                Object.keys(this.accountantForm).forEach(k => {
                    if (this.accountant.hasOwnProperty(k)) {
                        this.accountantForm[k] = this.accountant[k];
                    }
                    if (this.accountant.user.hasOwnProperty(k)) {
                        this.accountantForm[k] = this.accountant.user[k];
                    }
                });
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
                if (error.response.status === 404) {
                    this.redirect("404");
                }
            }
        }
    },
    async mounted() {
        if (!this.$route.params.id) {
            this.redirect("404");
        }
        await this.hasPermisssion("accountant-edit");
        this.getAccountant();
    }
};
</script>
