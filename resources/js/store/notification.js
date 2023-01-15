export default {
    namespaced: true,
    state: {
        notifications: {},
        unread: 0,
    },
    getters: {
        getNotifications(state) {
            return state.notifications
        },
        getUnreadNotifications(state) {
            return state.unread
        },
    },
    mutations: {
        FETCH_NOTIFICATIONS(state, responseData) {
            state.notifications = responseData
        },
        FETCH_UNREAD_NOTIFICATIONS(state, responseData) {
            state.unread = responseData
        },
        async SET_NOTIFICATIONS_READ(state){
            state.unread = 0
            let updateNotifications = await state.notifications.map(notification => {
                notification.read_at = "Read"
            })

            state.notifications = updateNotifications
        }
    },
    actions: {
        async fetchNotifications(context) {
            let response = await axios.get('/api/notifications');
            context.commit('FETCH_NOTIFICATIONS', response.data)
        },
        async markAllReadNotifications() {
            await axios.post('/api/notifications/markallread')
        },
        async fetchUnreadNotifications(context) {
            let response = await axios.get('/api/notifications/unread-count');
            context.commit('FETCH_UNREAD_NOTIFICATIONS', response.data)
        },
        async markToggleNotification(context, notificationId) {
            await axios.put(`/api/notifications/mark-toggle/${notificationId}`);
            context.dispatch('fetchUnreadNotifications')
        },
        async markReadNotification(context, notificationId) {
            await axios.put(`/api/notifications/mark-read/${notificationId}`);
            context.dispatch('fetchUnreadNotifications')
        }
    }
}
