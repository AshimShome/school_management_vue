<template>
    <div v-if="!isMailConfigured" class="alert alert-danger my-1" role="alert">
        <h4 class="alert-title">Please configuration mail setting</h4>
        <div class="text-muted">You need to configure your mail setting to send mail. <router-link :to="{name: 'setting-admin-mail'}">Go to setting</router-link></div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isMailConfigured: false
        };
    },
    async mounted() {
        let response = await axios.get("/api/setting/check-mail-setting");
        this.isMailConfigured = response.data;
    }
};
</script>
