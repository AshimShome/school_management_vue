<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t('notification') }}</h2>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex justify-content-start align-items-center">
                    <div class="sender-img">
                        <img alt="Sender Image" :src="notification.sender.image" />
                    </div>
                    <div class="ml-20">
                        <h3 class="text-purple mb-0 font-weight-bold">
                            {{ notification.sender.name }}
                        </h3>
                        <small class="text-muted">{{ timeFromNow(created_at) }}</small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h2 class="text-primary">
                    {{ notification.subject }}
                </h2>
                <p v-html="notification.body" />
            </div>
        </div>
    </div>
</template>


<style scoped>
    .card .card-header a {
        background-color: #f0f2f3;
    }

    .card .card-header a:hover {
        background-color: #d7d7d7;
    }

    .card .card-body p {
        letter-spacing: 1px;
        font-size: 20px;
        line-height: 1.5;
        text-align: justify;
    }

    .sender-img{
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
    }
</style>

<script>
    export default {
        data() {
            return {
                notification: "",
                created_at: '',
            };
        },
        async created() {
            let response = await axios.get(
                `/api/notifications/get-notification/${this.$route.params.id}`
            );

            this.notification = response.data.data;
            this.created_at = response.data.created_at;
        },
    };
</script>
