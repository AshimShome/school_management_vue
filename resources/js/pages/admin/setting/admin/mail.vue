<template>
    <div class="tab-pane active show" id="website">
        <div class="card">
            <div class="card-body border-bottom py-3">
                <form @submit.prevent="saveSetting" autocomplete="off">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-6 col-xxl-5">
                            <div class="mb-3">
                                <div class="form-floating mb-3">
                                    <input disabled type="text" class="form-control" value="SMTP" autocomplete="off"
                                        placeholder="" />
                                    <label for="floating-input">{{ $t("mail_type") }}</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('host') }" v-model="form.host"
                                        autocomplete="off" :placeholder="$t('host')" />
                                    <label for="floating-input">{{ $t("mail_host") }}</label>
                                    <has-error :form="form" field="host"></has-error>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('port') }" v-model="form.port"
                                        autocomplete="off" :placeholder="$t('port')" />
                                    <label for="floating-input"> {{ $t("mail_port") }}</label>
                                    <has-error :form="form" field="port"></has-error>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('encryption') }"
                                        v-model="form.encryption" autocomplete="off" :placeholder="$t('encryption')" />
                                    <label for="floating-input">
                                        {{ $t("mail_encryption") }}</label>
                                    <has-error :form="form" field="encryption"></has-error>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xxl-5">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('username') }" v-model="form.username" autocomplete="off"
                                    :placeholder="$t('username')" />
                                <label for="floating-input">{{ $t("mail_username") }}</label>
                                <has-error :form="form" field="username"></has-error>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" v-model="form.password" autocomplete="off"
                                    :placeholder="$t('password')" />
                                <label for="floating-input">{{ $t("mail_password") }}</label>
                                <has-error :form="form" field="password"></has-error>
                            </div>
                            <div class="form-floating mb-3">
                                <input disabled type="text" class="form-control" v-model="form.from_name"
                                    :class="{ 'is-invalid': form.errors.has('from_name') }" autocomplete="off"
                                    :placeholder="$t('from_name')" />
                                <label for="floating-input">{{ $t("mail_from_name") }}</label>
                                <has-error :form="form" field="from_name"></has-error>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" v-model="form.from_address"
                                    :class="{ 'is-invalid': form.errors.has('from_address') }" autocomplete="off"
                                    :placeholder="$t('from_address')" />
                                <label for="floating-input">{{ $t("mail_from_email") }}</label>
                                <has-error :form="form" field="from_address"></has-error>
                            </div>
                        </div>
                        <div class="col-12 col-md-8 col-xxl-6 text-center" v-if="checkPermission('setting-edit')">
                            <button class="btn btn-primary mt-3 w-200 h-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 12l5 5l10 -10"></path>
                                </svg>
                                {{ $t("save") }}
                            </button>
                            <button @click="reset" type="button" class="btn btn-secondary mt-3 w-200 h-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
                                    <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"></path>
                                </svg>
                                {{ $t("reset") }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">{{ $t("send_test_mail") }}</h3>
            </div>
            <div class="card-body">
                <form @submit.prevent="testMailSend" autocomplete="off">
                    <div class="row justify-content-center">
                        <div class="col-xxl-5 col-xl-7 col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input :placeholder="$t('test_email')" type="email" class="form-control"
                                    :class="{ 'is-invalid': testMailForm.errors.has('email') }"
                                    v-model="testMailForm.email" autocomplete="off" />
                                <label for="floating-input">{{ $t("email") }}</label>
                                <has-error :form="testMailForm" field="email"></has-error>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-5 col-md-6 col-12">
                            <button v-if="testMailForm.busy" type="button" class="btn btn-primary w-200 h-58">
                                {{ $t("sending") }}...
                            </button>
                            <button v-else type="submit" class="btn btn-primary w-200 h-58">
                                <icon-send />
                                {{ $t("send") }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: new Form({
                type: "",
                host: "",
                port: "",
                password: "",
                username: "",
                encryption: "",
                from_name: "",
                from_address: ""
            }),

            testMailForm: new Form({
                email: ""
            })
        };
    },
    async created() {
        this.loadData();
    },
    methods: {
        async saveSetting() {
            try {
                let { data } = await this.form.put("/api/setting/mail");
                this.toastSuccess(data.message);

                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } catch (err) {
                this.toastError();
            }
        },
        async testMailSend() {
            try {
                let { data } = await this.testMailForm.post(
                    "/api/setting/send-test-mail"
                );
                this.testMailForm.reset();
                this.toastSuccess(data.message);
            } catch (err) {
                this.toastError();
            }
        },
        async loadData() {
            try {
                let { data } = await axios.get("/api/setting/mail");
                this.form.fill(data);
            } catch (err) {
                this.toastError();
            }
        },
        async reset() {
            this.loadData();
        }
    }
};
</script>
