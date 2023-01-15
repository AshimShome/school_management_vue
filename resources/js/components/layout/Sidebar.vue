<template>
    <aside class="navbar navbar-vertical navbar-expand-lg navbar-dark"
        :style="{ 'background-color': setting.sidebar_bg }">
        <div class="container-fluid">
            <button @click.prevent="navToggler = !navToggler" :aria-expanded="navToggler ? true : false"
                :class="navToggler ? '' : 'collapsed'" class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbar-menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-brand">
                <a @click="$router.push({ name: 'home' })" href="javascript:void(0)">
                    <img v-if="!darkMode && setting.logo" :src="setting.logo_url" alt="" />
                    <img v-else-if="darkMode && setting.dark_logo" :src="setting.dark_logo_url" alt="" />
                    <img v-else :src="logo" alt="" />
                </a>
            </div>
            <div :class="{ show: navToggler }" class="collapse navbar-collapse" id="navbar-menu">
                <app-menu-items listClass="pt-lg-3" v-if="userType == 'admin' || userType == 'staff'" />
                <students-menu-items listClass="pt-lg-3" v-if="userType == 'student'" />
                <parents-menu-items listClass="pt-lg-3" v-if="userType == 'guardian'" />
            </div>
        </div>
    </aside>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
    components: {
        AppMenuItems: () =>
            import("./../partials/menus/admin/VerticalMenuItems.vue"),
        StudentsMenuItems: () =>
            import("./../partials/menus/students/VerticalMenuItems.vue"),
        ParentsMenuItems: () =>
            import("./../partials/menus/parents/VerticalMenuItems.vue")
    },
    data() {
        return {
            navToggler: false,
            sidebarDropdown: false,
            logo: "/images/logo/logo.png"
        };
    },
    computed: {
        ...mapGetters({
            authenticated: "auth/authenticated",
            user: "auth/user",
            setting: "setting/setting",
            darkMode: "getMode"
        }),
        userPermissions() {
            return this.$store.getters.getUserPermissions;
        },
        userType() {
            return this.user.role;
        }
    },
    methods: {
        ...mapActions({
            logoutAction: "auth/logout"
        })
    }
};
</script>
<style scoped>
@media (max-width: 768px) {
    .navbar-brand {
        width: 110px;
    }
    button {
        order: 2;
    }
 }
</style>
