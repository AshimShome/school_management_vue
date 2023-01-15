<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t("message") }}</h2>
                </div>
            </div>
        </div>
        <div class="row row-cards mt-2">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ $t("message_notification") }}</div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-xl-6">
                            <form @submit.prevent="sendMessage" autocomplete="off">
                                <div class="row">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="user_type">{{ $t("recipient") }}</label>
                                        <select id="user_type" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('user_type') }"
                                            v-model="form.user_type">
                                            <option value="" disabled selected>
                                                {{ $t("select_recipient") }}
                                            </option>
                                            <option v-for="role in roles" :key="role.id" :value="role.id">
                                                {{ role.name }}
                                            </option>
                                        </select>
                                        <has-error :form="form" field="user_type"></has-error>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="title">{{ $t("title") }}
                                        </label>
                                        <input id="title" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('title') }" v-model="form.title" />
                                        <has-error :form="form" field="title"></has-error>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="message">{{ $t("message") }}</label>
                                        <textarea id="message" rows="8" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('message') }"
                                            v-model="form.message"></textarea>
                                        <has-error :form="form" field="message"></has-error>
                                    </div>
                                    <div class="form-group mb-3">
                                        <button type="submit" :disabled="sendButtonDisabled" class="btn btn-primary">
                                            {{ $t("send") }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
            form: new Form({
                user_type: "",
                title: "",
                message: ""
            }),
            roles: []
        };
    },
    computed: {
        sendButtonDisabled() {
            return (
                this.form.user_type == "" ||
                this.form.title == "" ||
                this.form.message == ""
            );
        }
    },
    methods: {
        reset() {
            this.isModalShow = false;
            this.form.reset();
            this.form.clear();
        },
        async sendMessage() {
            try {
                const response = await this.form.post(`/api/messages`);
                this.reset();
                this.toastSuccess(response.data.message);
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async getRoles() {
            try {
                const response = await axios.get(`/api/messages/get-roles`);
                console.log(response);
                this.roles = response.data.roles;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        }
    },
    async created() {
        await this.hasPermisssion("message-notification-send");
        this.getRoles();
    },
    mounted() {}
};
</script>
