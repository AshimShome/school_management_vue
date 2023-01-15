<template>
    <div class="antialiased border-top-wide border-primary d-flex flex-column mh-100vh">
        <div class="flex-fill d-flex flex-column justify-content-center py-4">
            <div class="container-tight">
                <div class="text-center mb-2">
                    <router-link :to="{ name: 'home' }">
                        <img :src="setting.dark_logo ? setting.dark_logo_url : logo" alt="Schooling - School Management System PHP Script">
                    </router-link>
                </div>
                <vue-page-transition name="fade">
                    <router-view />
                </vue-page-transition>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            logo: "/images/logo/blue-logo.png"
        };
    },
    computed: {
        setting() {
            return this.$store.getters["setting/setting"];
        }
    },
    async created() {
        await this.$store.dispatch("setting/fetchSetting");
    }
};
</script>
