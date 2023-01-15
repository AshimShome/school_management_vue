<template>
    <div>
        <div class="page" v-if="permissionLoaded">
            <sidebar />
            <navbar />
            <div class="content">
                <mail-configure-alert/>
                <div :class="setting.layout == 'boxed' ? 'container-xl' : 'container-fluid'">
                    <vue-page-transition name="fade">
                        <router-view />
                    </vue-page-transition>
                </div>
                <footer />
            </div>
        </div>
    </div>
</template>

<script>
import Footer from "../components/layout/Footer.vue";
import Navbar from "../components/layout/Navbar.vue";
import Sidebar from "../components/layout/Sidebar.vue";
import Loader from "../components/Loader.vue";
import MailConfigureAlert from "../components/partials/MailAlert.vue";

export default {
    components: {
        Loader,
        Navbar,
        Sidebar,
        Footer,
        MailConfigureAlert
    },
    data() {
        return {
            message: "",
            isMailConfigured: false
        };
    },
    computed: {
        permissionLoaded() {
            return this.$store.getters[
                "rolepermission/getPermissionLoadingStatus"
            ];
        },
        setting() {
            return this.$store.getters["setting/setting"];
        }
    }
};
</script>
