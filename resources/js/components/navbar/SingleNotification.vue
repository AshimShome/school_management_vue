<template>
    <div class="list-group-item cursor-pointer d-flex justify-content-between"
        :style="{ 'background-color': !notification.read_at ? '#c9c9c9' : '' }">
        <div class="row align-items-center" v-if="notification.data" @click="notificationDetails(notification.id)">
            <div class="col-auto">
                <span class="avatar" :style="{
            'background-image': 'url(' + notification.data.sender.image + ')',
          }"></span>
            </div>
            <div class="col text-truncate">
                <span class="text-body d-block">{{
          notification.data.sender.name
        }}</span>
                <span class="d-block text-muted text-truncate mt-n1" v-html="notification.data.subject" />
                <small class="text-muted text-secondary opacity-75">{{
          timeFromNow(notification.created_at)
        }}</small>
            </div>
        </div>

        <a href="#" @click="markReadUnread(notification.id)">
            <span v-if="notification.read_at">{{ $t("mark_as_unread") }}</span>
            <span v-else>{{ $t("mark_as_read") }}</span>
        </a>
    </div>
</template>

<script>
    export default {
        props: {
            notification: {
                type: Object,
                required: true,
            },
        },
        methods: {
            notificationDetails(notificationId) {
                this.markRead(notificationId);
                this.$emit("close-notification");
                this.$router.push({
                    name: "notification-details",
                    params: {
                        id: notificationId,
                    },
                });
            },
            markReadUnread(notificationId) {
                this.$store.dispatch(
                    "notification/markToggleNotification",
                    notificationId
                );

                if (this.notification.read_at) {
                    this.notification.read_at = "";
                } else {
                    this.notification.read_at = "Read";
                }
            },
            markRead(notificationId) {
                this.$store.dispatch("notification/markReadNotification", notificationId);
                this.notification.read_at = "Read";
            },
        },
    };
</script>
