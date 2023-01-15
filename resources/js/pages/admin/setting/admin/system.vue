<template>
    <div class="tab-pane active show" id="website">
        <form @submit.prevent="saveSetting">
            <div class="row justify-content-start">
                <div class="col-xl-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="card-title">
                                <h3>{{ $t("app_configuration") }}</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3 row">
                                <label for="name" class="form-label col-md-3 col-form-label">
                                    {{ $t("app_debug") }}</label>
                                <div class="col-md-9">
                                    <label class="form-check form-switch">
                                        <input class="form-check-input h-20 w-40" type="checkbox"
                                            v-model="form.app_debug"/>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <base-label :title="$t('app_url')" class="form-label col-md-3 col-form-label" />
                                <div class="col-md-9">
                                    <base-input :form="form" field="app_url" v-model="form.app_url">
                                    </base-input>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <base-label :title="$t('timezone')" class="form-label col-md-3 col-form-label" />
                                <div class="col-md-9">
                                    <base-select :form="form" field="timezone" v-model="form.timezone">
                                        <option v-for="time in timezones" :value="time.value" :key="time.value" :selected="time.value == form.timezone">
                                            {{ time.value }}
                                        </option>
                                    </base-select>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <base-label :title="$t('set_default_language')" class="form-label col-md-3 col-form-label" />
                                <div class="col-md-9">
                                    <base-select :form="form" field="default_language" v-model="form.default_language">
                                        <option v-for="(lang, i) in langs" :value="i" :key="`lang-${i}`" :selected="i == default_language">
                                            {{ i.toUpperCase() }}
                                        </option>
                                    </base-select>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <base-label :title="$t('currency_sign')" class="form-label col-md-3 col-form-label" />
                                <div class="col-md-9">
                                    <base-input :form="form" field="currency_sign" v-model="form.currency_sign">
                                    </base-input>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                {{ $t('class_routine') }}
                            </div>
                        </div>
                        <div class="card-body border-bottom py-3">
                            <div class="row justify-content-center">
                                <div class="form-group mb-3">
                                    <base-label :title="$t('routine_time_difference')" />
                                    <base-select :form="form" field="time_diff" v-model="form.time_diff">
                                        <option disabled class="d-none">{{ $t("select_time") }}</option>
                                        <option v-for="(time,index) in routine_time_difference" :key="index"
                                            :value="time" :selected="form.time_diff == time">
                                            {{ time }}
                                        </option>
                                    </base-select>
                                </div>
                                <div class="form-group mb-3 row">
                                    <div class="col-4">
                                        <base-label :title="$t('class')+' '+$t('start_time')" />
                                        <vue-timepicker :minute-interval="60" v-model="form.start_time"
                                            placeholder="Hour:Minute">
                                        </vue-timepicker>
                                        <has-error :form="form" field="start_time" class="d-block"></has-error>
                                    </div>
                                    <div class="col-4">
                                        <base-label :title="$t('class')+' '+$t('end_time')" />
                                        <vue-timepicker :minute-interval="60" v-model="form.end_time"
                                            placeholder="Hour:Minute">
                                        </vue-timepicker>
                                        <has-error :form="form" field="end_time" class="d-block"></has-error>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h3>{{ $t("db_configuration") }}</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3 row">
                                <base-label :title="$t('db_connection')" class="form-label col-md-3 col-form-label" />
                                <div class="col-md-9">
                                    <base-select :form="form" field="db_connection" v-model="form.db_connection">
                                        <option :selected="form.db_connection == 'sqlite'" value="sqlite">sqlite</option>
                                        <option :selected="form.db_connection == 'mysql'" value="mysql">mysql</option>
                                        <option :selected="form.db_connection == 'pgsql'" value="pgsql">pgsql</option>
                                        <option :selected="form.db_connection == 'sqlsrv'" value="sqlsrv">sqlsrv</option>
                                    </base-select>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <base-label :title="$t('db_host')" class="form-label col-md-3 col-form-label" />
                                <div class="col-md-9">
                                    <base-input :form="form" field="db_host" v-model="form.db_host">
                                    </base-input>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <base-label :title="$t('db_port')" class="form-label col-md-3 col-form-label" />
                                <div class="col-md-9">
                                    <base-input :form="form" field="db_port" v-model="form.db_port">
                                    </base-input>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <base-label :title="$t('db_name')" class="form-label col-md-3 col-form-label" />
                                <div class="col-md-9">
                                    <base-input :form="form" field="db_name" v-model="form.db_name">
                                    </base-input>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <base-label :title="$t('db_username')" class="form-label col-md-3 col-form-label" />
                                <div class="col-md-9">
                                    <base-input :form="form" field="db_username" v-model="form.db_username">
                                    </base-input>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <base-label :title="$t('db_password')" class="form-label col-md-3 col-form-label" />
                                <div class="col-md-9">
                                    <base-input :form="form" field="db_password" v-model="form.db_password">
                                    </base-input>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             <button type="submit" class="lang-btn btn btn-primary mt-5" v-if="checkPermission('setting-edit')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M5 12l5 5l10 -10"></path>
                    </svg>
                    {{ $t("save") }}
                </button>
        </form>
    </div>
</template>

<script>
import VueTimepicker from "vue2-timepicker";
export default {
    components: {
        VueTimepicker
    },
    data() {
        return {
            form: new Form({
                // db
                db_connection: "",
                db_host: "",
                db_port: "",
                db_name: "",
                db_username: "",
                db_password: "",

                // app config
                app_debug: "",
                app_url: "",
                default_language: "",
                timezone: "",
                currency_sign: "",

                // class routine
                time_diff: "",
                start_time: "",
                end_time: ""
            }),

            routine_time_difference: [10, 20, 25, 30, 35, 40, 50, 60],
            timezones: [],
            languages: [],
            default_language : "",
        };
    },
    async created() {
        this.loadData();
    },
    computed:{
        langs(){
            return this.$store.getters.getAllLocales;
        }
    },
    methods: {
        async saveSetting() {
            try {
                let response = await this.form.put(`/api/setting/system`);

                this.toastSuccess(response.message);
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            } catch (err) {
                this.toastError();
            }
        },
        async loadData() {
            try {
                let { data } = await axios.get("/api/setting/system");
                let app_default = await axios.get('/api/app/default');

                this.form.fill(data.setting);
                this.timezones = data.timezones;
                this.default_language = app_default.data.language;
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

<style scoped>
    @import "vue2-timepicker/dist/VueTimepicker.css";

    .lang-btn {
        position: fixed;
        left: 50%;
        bottom: 50px;
        width: 200px;
        padding: 15px;
        text-align: center;
    }
</style>
