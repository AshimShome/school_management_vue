<template>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3>
                {{ $t('notifications') }}
                <span class="badge badge-pill bg-danger" v-if="unread">{{ unread }}</span>
            </h3>
            <div>
                <a @click="markallread" href="#" class="text-underline mr-10">
                    {{ $t('mark_all_as_read') }}
                </a>
                <span @click="fetchNewNotification()">
                    <icon-sync />
                </span>
            </div>
        </div>
        <div class="card-body">
            <template v-if="notifications && notifications.length">
                <div class="notification_item" v-for="(notification,index) in notifications" :key="notification.id">
                    <div class="d-flex justify-content-start align-items-center mb">
                        <h2 class="text-purple">{{ notification.data.sender.name }}</h2>
                        <small>{{ timeFromNow(notification.created_at) }}</small>
                    </div>
                    <h3>{{ notification.data.subject }}</h3>
                    <p class="text-muted" v-html="notification.data.body" />
                    <hr v-if="index+1 != notifications.length" />
                </div>
            </template>
            <div class="text-center my-4" v-else>
                <icon-big-bell />
                <h3 class="mt-3">{{ $t('no_notifications_found') }}!</h3>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        mapGetters
    } from "vuex";

    export default {
        created() {
            this.$store.dispatch("notification/fetchNotifications");
        },
        computed: {
            ...mapGetters({
                notifications: "notification/getNotifications",
                unread: "notification/getUnreadNotifications",
            }),
        },
        methods: {
            fetchNewNotification() {
                this.$store.dispatch("notification/fetchNotifications");
            },
            async markallread() {
                if (this.notifications.length) {
                    this.$store.dispatch("notification/markAllReadNotifications");
                    this.$store.commit("notification/SET_NOTIFICATIONS_READ");
                }
            },
        },
    }
</script>

<style scoped>
    .card-header svg {
        width: 30px;
        cursor: pointer;
    }

    .notification_item .mb {
        margin-bottom: 10px;
    }

    .notification_item h2 {
        font-weight: 900;
        margin-bottom: 0;
    }

    .notification_item small {
        margin-left: 15px;
        margin-top: 2px;
    }

    .notification_item hr {
        margin: 1rem 0;
    }
</style>
