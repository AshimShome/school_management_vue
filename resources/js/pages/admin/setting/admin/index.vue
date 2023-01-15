<template>
    <div class="tab-pane active show" id="website">
        <div class="card">
            <div class="card-body border-bottom py-3">
                <form @submit.prevent="websiteSettingForm" autocomplete="off">
                    <div class="row justify-content-center">
                        <div class="col-xl-6">
                            <div class="form-group mb-3 row">
                                <label for="name" class="form-label col-md-3 col-form-label">{{ $t("app_name") }}</label>
                                <div class="col-md-9">
                                    <input v-model="settingForm.name"
                                        :class="{ 'is-invalid': settingForm.errors.has('name') }" type="text"
                                        class="form-control" :placeholder="$t('name')" id="name" />
                                    <has-error :form="settingForm" field="name"></has-error>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <label for="name" class="form-label col-md-3 col-form-label">{{ $t("app_short_name") }}</label>
                                <div class="col-md-9">
                                    <input v-model="settingForm.short_name"
                                        :class="{ 'is-invalid': settingForm.errors.has('short_name') }" type="text"
                                        class="form-control" :placeholder="$t('short_name')" id="short_name" />
                                    <has-error :form="settingForm" field="short_name"></has-error>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <label for="email" class="form-label col-md-3 col-form-label">{{ $t("email") }}</label>
                                <div class="col-md-9">
                                    <input v-model="settingForm.email"
                                        :class="{ 'is-invalid': settingForm.errors.has('email') }" type="text"
                                        class="form-control" :placeholder="$t('email')" id="email" />
                                    <has-error :form="settingForm" field="email"></has-error>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <label for="phone" class="form-label col-md-3 col-form-label">
                                    {{ $t("phone") }}
                                </label>
                                <div class="col-md-9">
                                    <input v-model="settingForm.phone"
                                        :class="{ 'is-invalid': settingForm.errors.has('phone') }" type="text"
                                        class="form-control" :placeholder="$t('phone')" id="phone" />
                                    <has-error :form="settingForm" field="phone"></has-error>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <label for="email" class="form-label col-md-3 col-form-label">{{ $t("address") }}</label>
                                <div class="col-md-9">
                                    <textarea v-model="settingForm.address" class="form-control" rows="8"></textarea>
                                    <has-error :form="settingForm" field="address"></has-error>
                                </div>
                            </div>
                        </div>
                        <div class="ml-5 col-xl-4">
                            <div class="form-group row">
                                <label for="name" class="form-label col-md-3 col-form-label">{{ $t("favicon") }}</label>
                                <div class="col-md-9">
                                    <img class="mb-3 border border-secondary" width="32px" height="32px" :src="preview_favicon" alt="image"
                                        /><br />
                                    <input @change="onFavChange" type="file" accept="image/png, image/ico"/>
                                </div>
                            </div>
                            <div class="form-group my-4 row">
                                <label for="name" class="form-label col-md-3 col-form-label">{{ $t("logo") }}</label>
                                <div class="col-md-9">
                                    <img class="mb-3 border border-secondary" width="200px" height="50px" :src="preview_logo" alt="image" /><br />
                                    <input @change="onLogoChange" type="file" />
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <label for="name" class="form-label col-md-3 col-form-label">{{ $t("dark_mode") + " " + $t("logo") }}</label>
                                <div class="col-md-9">
                                    <img class="mb-3 border border-secondary" width="200px" height="50px" :src="preview_dark_logo" alt="image"
                                        /><br />
                                    <input @change="onDarkLogoChange" type="file" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center" v-if="checkPermission('setting-edit')">
                            <button-loading v-if="settingForm.busy" />
                            <button type="submit" v-else class="btn btn-primary mt-3 w-200 h-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 12l5 5l10 -10"></path>
                                </svg>
                                {{ $t("save") }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import ButtonLoading from "../../../../components/ButtonLoading.vue";
import { serialize } from "object-to-formdata";

export default {
    components: {
        ButtonLoading
    },
    data() {
        return {
            settingForm: new Form({
                name: "",
                short_name: "",
                email: "",
                address: "",
                phone: "",
                favicon: "",
                logo: "",
                dark_logo: ""
            }),

            preview_favicon: "",
            preview_logo: "",
            preview_dark_logo: ""
        };
    },
    methods: {
        onFavChange(e) {
            var file = e.target.files[0];
            this.preview_favicon = URL.createObjectURL(file);
            this.settingForm.favicon = file;
        },
        onLogoChange(e) {
            var file = e.target.files[0];
            this.preview_logo = URL.createObjectURL(file);
            this.settingForm.logo = file;
        },
        onDarkLogoChange(e) {
            var file = e.target.files[0];
            this.preview_dark_logo = URL.createObjectURL(file);
            this.settingForm.dark_logo = file;
        },
        async websiteSettingForm() {
            try {
                let response = await this.settingForm.post("/api/setting", {
                    transformRequest: [
                        function(data, headers) {
                            return serialize(data);
                        }
                    ]
                });

                if (this.settingForm.favicon) {
                    const favicon = document.getElementById("favicon");
                    favicon.setAttribute(
                        "href",
                        response.data.setting.favicon_url
                    );
                }

                this.toastSuccess(response.data.message);
            } catch (err) {
                this.toastError();

                console.log(err.response);
            }
        },
        async loadData() {
            // await this.$store.dispatch("setting/fetchSetting");
            this.settingForm.fill(this.setting);
            this.settingForm.logo = "";
            this.settingForm.favicon = "";
            this.settingForm.dark_logo = "";
            this.preview_favicon = this.setting.favicon_url;
            this.preview_logo = this.setting.logo_url;
            this.preview_dark_logo = this.setting.dark_logo_url;
        }
    },
    computed: {
        setting() {
            return this.$store.getters["setting/setting"];
        }
    },
    created() {
        this.loadData();
    }
};
</script>
