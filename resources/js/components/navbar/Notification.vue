<template>
    <div class="nav-item dropdown d-none d-md-flex me-3" v-on-clickaway="hideNotification">
        <a @click="openNotification" href="#" class="nav-link px-0 show me-2" data-bs-toggle="dropdown" tabindex="-1"
            aria-label="Show notifications" aria-expanded="true">
            <icon-bell :stroke="notification ? '#206bc4' : 'currentColor'" />
            <span class="badge bg-red" v-if="unread">{{ unread }}</span>
        </a>
        <div id="notificationArea" class="dropdown-menu dropdown-menu-end dropdown-menu-card notification-min-width"
            :class="{ show: notification }" data-bs-popper="none">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title">{{ $t('notifications') }}</h3>
                    <a @click="markallread" href="#" class="text-underline">{{
            $t("mark_all_as_read")
          }}</a>
                </div>
                <div class="list-group list-group-flush list-group-hoverable overflow-auto notification-max-height"
                    v-if="notifications && notifications.length">
                    <!-- Single Notification  -->
                    <SingleNotification v-for="notification in notifications" :key="notification.id"
                        :notification="notification" @close-notification="notification = false" />
                </div>
                <div class="text-center my-4" v-else>
                    <icon-big-bell />
                    <h3 class="mt-3">{{ $t("no_notifications_found") }}!</h3>
                </div>
                <div class="card-footer text-center">
                    <router-link :to="{ name: 'notifications' }" class="text-underline">
                        {{ $t("view_all_notifications") }}
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

.notification-max-height {
    max-height: 400px
}
.notification-min-width {
    min-width: 400px
}
</style>

<script>
import { mapGetters } from "vuex";
import { mixin as clickaway } from "vue-clickaway";
import SingleNotification from "./SingleNotification.vue";

export default {
    mixins: [clickaway],
    components: {
        SingleNotification
    },
    data() {
        return {
            notification: false
        };
    },
    mounted() {
        this.$store.dispatch("notification/fetchUnreadNotifications");
    },
    computed: {
        ...mapGetters({
            notifications: "notification/getNotifications",
            unread: "notification/getUnreadNotifications"
        })
    },
    methods: {
        async openNotification() {
            if (this.notification) {
                this.closeNotification();
            } else {
                this.notification = true;
                this.$store.dispatch("notification/fetchNotifications");
            }
        },
        async markallread() {
            if (this.notifications.length) {
                this.$store.dispatch("notification/markAllReadNotifications");
                this.$store.commit("notification/SET_NOTIFICATIONS_READ");
            }
        },
        closeNotification() {
            this.notification = false;
        },
        hideNotification() {
            this.notification = false;
        }
    }
};
</script>
