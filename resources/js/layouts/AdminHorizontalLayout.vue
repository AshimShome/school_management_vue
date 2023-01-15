<template>
    <div>
        <header class="navbar navbar-expand-md navbar-light d-print-none">
            <div :class="setting.layout == 'boxed' ? 'container-xl' : 'container-fluid'">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand d-none-navbar-horizontal pe-0 pe-md-3">
                    <router-link :to="{ name: 'home'}">
                        <img v-if="setting.logo" :src="setting.logo_url" alt="" class="navbar-brand-image">
                        <img v-else :src="logo" alt="" class="navbar-brand-image">
                    </router-link>
                </h1>
                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item d-none d-md-flex me-3 flex-row align-items-center">
                         <session-year />
                        <switch-language />
                        <darkmode />
                        <notification/>
                    </div>
                    <div class="nav-item dropdown show" @click.prevent="navDropDown = !navDropDown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                            aria-label="Open user menu">
                            <span class="avatar avatar-sm" :style="{ backgroundImage: `url(${user.image_url})` }"></span>
                            <div class="d-none d-xl-block ps-2">
                                <div> {{ user.name }}</div>
                                <div class="mt-1 small text-muted">{{ user.role }}</div>
                            </div>
                        </a>
                        <div v-on-clickaway="away" v-if="navDropDown"
                            class="show dropdown-menu dropdown-menu-end dropdown-menu-arrow r-0">
                            <router-link :to="{ name: 'user-profile' }"
                                class="dropdown-item">
                                <icon-user/>&nbsp;
                                {{ $t('profile') }}
                            </router-link>
                            <div class="dropdown-divider"></div>
                            <logout linkClass="dropdown-item">
                                <icon-logout/>&nbsp;
                            </logout>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="navbar-expand-md">
            <div class="collapse navbar-collapse" id="navbar-menu">
                <div class="navbar navbar-light">
                    <div :class="setting.layout == 'boxed' ? 'container-xl' : 'container-fluid'">
                        <AdminHorizontalAppMenuItems   v-if="userType =='admin' || userType =='staff'" />
                        <StudentHorizontalAppMenuItems   v-if="userType =='student' " />
                        <ParentHorizontalAppMenuItems   v-if="userType =='guardian' " />
                        <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
                            <!-- <form action="." method="get">
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <circle cx="10" cy="10" r="7"></circle>
                                            <line x1="21" y1="21" x2="15" y2="15"></line>
                                        </svg>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Search…" aria-label="Search in website">
                                </div>
                            </form> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-wrapper">
            <div :class="setting.layout == 'boxed' ? 'container-xl' : 'container-fluid'">
                <div class="page-header d-print-none mt-">
                    <mail-configure-alert/>
                </div>
                <vue-page-transition name="fade">
                    <router-view />
                </vue-page-transition>
            </div>
        </div>
    </div>
</template>

<script>
import { mixin as clickaway } from "vue-clickaway";
import { mapGetters } from "vuex";
import Darkmode from "../components/navbar/Darkmode.vue";
import Logout from "../components/Logout.vue";
import SwitchLanguage from "../components/navbar/SwitchLanguage.vue";
import Notification from "../components/navbar/Notification.vue";
import SessionYear from "../components/navbar/SessionYear.vue";
import MailConfigureAlert from "../components/partials/MailAlert.vue";

export default {
    mixins: [clickaway],
    data() {
        return {
            logo: "/images/logo/logo.png",
            url: "/images/default.png",
            navDropDown: false,
            notification: false,
            isMailConfigured: false
        };
    },
    components: {
        AdminHorizontalAppMenuItems: () =>
            import(
                "../components/partials/menus/admin/HorizontalAppMenuItems.vue"
            ),
        StudentHorizontalAppMenuItems: () =>
            import(
                "../components/partials/menus/students/HorizontalMenuItems.vue"
            ),
        ParentHorizontalAppMenuItems: () =>
            import(
                "../components/partials/menus/parents/HorizontalMenuItems.vue"
            ),
        Darkmode,
        Logout,
        SwitchLanguage,
        Notification,
        SessionYear,
        MailConfigureAlert
    },
    computed: {
        ...mapGetters({
            authenticated: "auth/authenticated",
            user: "auth/user",
            setting: "setting/setting"
        }),
        userType() {
            return this.user.role;
        }
    },
    methods: {
        logout() {
            this.logoutAction();
        },
        away() {
            this.navDropDown = false;
        }
    },
    async created() {
        let response = await axios.get("/setting/check-mail-setting");
        this.isMailConfigured = response.data;
    }
};
</script>
