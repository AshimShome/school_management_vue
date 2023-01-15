<template>
    <header class="navbar navbar-expand-md d-none d-lg-flex d-print-none"
        :style="[!darkMode ? {'background-color':setting.navbar_bg,'color': setting.navbar_text_color}: '']">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-nav flex-row order-md-last align-items-center">
                <!-- Session Switch  -->
                <session-year />

                <!-- Switch Language  -->
                <switch-language />

                <!-- Switch Mode  -->
                <darkmode />

                <!-- Notification  -->
                <notification />

                <div class="nav-item dropdown">
                    <a href="javascript:void(0)" @click.prevent="navDropDown = !navDropDown"
                        :class="{'show': navDropDown}" class="nav-link d-flex lh-1 text-reset p-0"
                        data-bs-toggle="dropdown" aria-label="Open user menu">
                        <span class="avatar avatar-sm" :style="{ backgroundImage: `url(${user.image_url})` }"></span>
                        <div class="d-none d-xl-block ps-2">
                            <div>{{ user.name }}</div>
                            <div class="mt-1 small text-muted">{{ user.email }}</div>
                        </div>
                    </a>
                    <div v-on-clickaway="away" v-if="navDropDown"
                        class="show dropdown-menu dropdown-menu-end dropdown-menu-arrow" data-bs-popper="none">
                        <router-link :to="{ name: 'user-profile' }" @click.native="navDropDown = false"
                            class="dropdown-item">
                            <icon-user />&nbsp;
                            {{ $t('profile') }}
                        </router-link>
                        <div class="dropdown-divider"></div>
                        <logout linkClass="dropdown-item">
                            <icon-logout />&nbsp;
                        </logout>
                    </div>
                </div>
            </div>
            <!-- User Role  -->
            <RoleBadge :role="user.original_role" />
        </div>
    </header>
</template>

<script>
import { mixin as clickaway } from "vue-clickaway";
import Darkmode from "../navbar/Darkmode.vue";
import { mapGetters, mapActions } from "vuex";
import Logout from "../Logout.vue";
import SwitchLanguage from "../navbar/SwitchLanguage.vue";
import Notification from "../navbar/Notification.vue";
import RoleBadge from "../navbar/RoleBadge.vue";
import SessionYear from "../navbar/SessionYear.vue";

export default {
    mixins: [clickaway],
    components: {
        Darkmode,
        SwitchLanguage,
        Notification,
        RoleBadge,
        SessionYear,
        Logout
    },
    data() {
        const lang = localStorage.getItem("lang") || "en";
        return {
            navDropDown: false,
            notification: false,
            lang: lang
        };
    },
    methods: {
        away() {
            this.navDropDown = false;
        },
        ...mapActions({
            logoutAction: "auth/logout"
        }),
        logout() {
            this.logoutAction();
        }
    },
    computed: {
        ...mapGetters({
            authenticated: "auth/authenticated",
            user: "auth/user",
            setting: "setting/setting",
            darkMode: "getMode"
        })
    }
};
</script>
