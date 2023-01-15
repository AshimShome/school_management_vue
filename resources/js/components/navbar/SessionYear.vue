<template>
    <div class="btn-list me-1">
        <select v-if="authenticateUser.original_role == 'Admin'" class="form-select" @change="changeSession" v-model="session">
            <option v-for="sessionYear in sessionsYear" :key="sessionYear.id" :selected="sessionYear.id == session" :value="sessionYear.id">
               {{ $t('session') }}: {{ sessionYear.name }}
            </option>
        </select>
        <template v-else>
            <button class="btn btn-transparent" disabled v-if="selectedSession.session">
                {{ $t('session') }} : {{ selectedSession.session.name }}
            </button>
        </template>
    </div>
</template>

<script>
export default {
    data() {
        return {
            sessionsYear: [],
            selectedSession: "",
            session: ""
        };
    },
    async created() {
        let response = await axios.get(`/api/sessions/year`);
        this.sessionsYear = response.data.sessions;
        this.session = response.data.selectedSession.default_session_id;
        this.selectedSession = response.data.selectedSession;
    },
    methods: {
        async changeSession() {
            if (confirm("Are you sure you want to change academic year?")) {
                let response = await axios.put(
                    `/api/sessions/year/${this.session}`
                );
                this.toastSuccess(response.data.message);
                window.location.reload();
            } else {
                this.session = this.selectedSession.default_session_id;
            }
        }
    }
};
</script>

<style>
    select {
        width: 150px;
        line-height: 49px;
        height: 38px;
        font-size: 22px;
        outline: 0;
        margin-bottom: 15px;
    }
</style>
