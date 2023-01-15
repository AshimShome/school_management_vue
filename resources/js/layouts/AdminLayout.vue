<template>
    <div>
        <div v-if="permissionLoaded">
            <admin-vertical-layout v-if="setting.nav_position == 'left'" />
            <admin-horizontal-layout v-else-if="setting.nav_position == 'top'" />
            <admin-vertical-layout v-else/>
        </div>
    </div>
</template>

<script>
import Loader from "../components/Loader.vue";
import AdminHorizontalLayout from "./AdminHorizontalLayout.vue";
import AdminVerticalLayout from "./AdminVerticalLayout.vue";

export default {
    components: {
        Loader,
        AdminVerticalLayout,
        AdminHorizontalLayout
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
    },
    async created() {
        await this.$store.dispatch("setting/fetchSetting");
    }
};
</script>
