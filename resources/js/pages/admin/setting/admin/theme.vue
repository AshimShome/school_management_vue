<template>
    <div class="tab-pane active show" id="website">
        <div class="card">
            <div class="card-body border-bottom py-3">
                <div class="row justify-content-center">
                    <div class="col-12 col-xl-10 col-xxl-8">
                        <form @submit.prevent="saveSetting">
                            <div class="mb-3">
                                <div class="col">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 mb-2">
                                            <label class="form-label col-form-label">{{ $t("sidebar_background_color") }}</label>
                                            <input type="color" v-model="typeForm.sidebar_bg"
                                                class="form-control form-control-color"
                                                :title="$t('choose_your_color')" />
                                        </div>
                                        <div class="col-12 col-sm-6 mb-2">
                                            <label class="form-label col-form-label">{{ $t("navigation_background_color") }}</label>
                                            <input type="color" v-model="typeForm.navbar_bg"
                                                class="form-control form-control-color"
                                                :title="$t('choose_your_color')" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6 mb-2">
                                            <label class="form-label col-form-label">{{ $t("sidebar_text_color") }}</label>
                                            <input type="color" class="form-control form-control-color"
                                                v-model="typeForm.sidebar_text_color" :title="$t('choose_your_color')"
                                                name="sidebar_bg" />
                                        </div>
                                        <div class="col-12 col-sm-6 mb-2">
                                            <label class="form-label col-form-label">{{ $t("navigation_text_color") }}</label>
                                            <input type="color" class="form-control form-control-color"
                                                v-model="typeForm.navbar_text_color" :title="$t('choose_your_color')" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label col-form-label">{{ $t("navbar_position") }}</label>
                                <div class="col">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 mb-2">
                                            <label class="form-selectgroup-item flex-fill">
                                                <input type="radio" v-model="typeForm.nav_position" :class="{'is-invalid': typeForm.errors.has('nav_position') }" name="nav_position" value="left" class="form-selectgroup-input" />
                                                <div class="form-selectgroup-label d-flex align-items-center p-3">
                                                    <div class="me-3">
                                                        <span class="form-selectgroup-check"></span>
                                                    </div>
                                                    <div>
                                                        {{ $t("left") + " " + $t("navbar") }}
                                                    </div>
                                                </div>
                                            </label>
                                            <has-error :form="typeForm" class="d-block" field="nav_position">
                                            </has-error>
                                        </div>
                                        <div class="col-12 col-sm-6 mb-2">
                                            <label class="form-selectgroup-item flex-fill">
                                                <input v-model="typeForm.nav_position" :class="{'is-invalid': typeForm.errors.has('nav_position')}" type="radio" name="nav_position" value="top" class="form-selectgroup-input" />
                                                <div class="form-selectgroup-label d-flex align-items-center p-3">
                                                    <div class="me-3">
                                                        <span class="form-selectgroup-check"></span>
                                                    </div>
                                                    <div>
                                                        {{ $t("top") + " " + $t("navbar") }}
                                                    </div>
                                                </div>
                                            </label>
                                            <has-error :form="typeForm" class="d-block" field="nav_position">
                                            </has-error>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label col-form-label">{{ $t("app") + " " + $t("layout") }}</label>
                                <div class="col">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 mb-2">
                                            <label class="form-selectgroup-item flex-fill">
                                                <input v-model="typeForm.layout" :class="{'is-invalid': typeForm.errors.has('layout')}" type="radio" name="layout" value="boxed" class="form-selectgroup-input" />
                                                <div class="form-selectgroup-label d-flex align-items-center p-3">
                                                    <div class="me-3">
                                                        <span class="form-selectgroup-check"></span>
                                                    </div>
                                                    <div>
                                                        {{ $t("boxed") + " " + $t("layout") }}
                                                    </div>
                                                </div>
                                            </label>
                                            <has-error :form="typeForm" class="d-block" field="layout">
                                            </has-error>
                                        </div>
                                        <div class="col-12 col-sm-6 mb-2">
                                            <label class="form-selectgroup-item flex-fill">
                                                <input v-model="typeForm.layout" :class="{'is-invalid': typeForm.errors.has('layout')}" type="radio" name="layout" value="full-width" class="form-selectgroup-input" />
                                                <div class="form-selectgroup-label d-flex align-items-center p-3">
                                                    <div class="me-3">
                                                        <span class="form-selectgroup-check"></span>
                                                    </div>
                                                    <div>
                                                        {{ $t("full_width") + " " + $t("layout") }}
                                                    </div>
                                                </div>
                                            </label>
                                            <has-error :form="typeForm" class="d-block" field="layout">
                                            </has-error>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center" v-if="checkPermission('setting-edit')">
                                <div class="col-4 text-center">
                                    <button type="submit" class="btn btn-primary mt-3 w-200 h-50">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-check" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
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
        </div>
    </div>
</template>


<script>
export default {
    data() {
        return {
            typeForm: new Form({
                sidebar_bg: "",
                navbar_bg: "",
                sidebar_text_color: "",
                navbar_text_color: "",
                nav_position: "",
                layout: ""
            })
        };
    },
    watch: {
        "typeForm.sidebar_bg": function(value) {
            this.typeForm.sidebar_bg = value;
        },
        "typeForm.navbar_bg": function(value) {
            this.typeForm.navbar_bg = value;
        },
        "typeForm.sidebar_text_color": function(value) {
            this.typeForm.sidebar_text_color = value;
        },
        "typeForm.navbar_text_color": function(value) {
            this.typeForm.navbar_text_color = value;
        }
    },
    methods: {
        async loadData() {
            try {
                let { data } = await axios.get("/api/setting/layout");
                var setting = data["setting"];

                this.typeForm.sidebar_bg = setting.sidebar_bg;
                this.typeForm.sidebar_text_color = setting.sidebar_text_color;
                this.typeForm.navbar_bg = setting.navbar_bg;
                this.typeForm.navbar_text_color = setting.navbar_text_color;
                this.typeForm.nav_position = setting.nav_position;
                this.typeForm.layout = setting.layout;
            } catch (err) {
                this.toastError();
            }
        },
        async saveSetting() {
            try {
                let { data } = await this.typeForm.put("/api/setting/layout");
                this.toastSuccess(data.message);
                setTimeout(() => {
                    this.$store.commit(
                        "setting/SET_ADMIN_SETTING",
                        data["setting"]
                    );
                    location.reload();
                }, 500);
            } catch (err) {
                this.toastError();
            }
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
