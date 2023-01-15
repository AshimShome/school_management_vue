import axios from 'axios'

export default {
    namespaced: true,
    state: {
        sessions: [],
    },
    getters: {
        sessions(state) {
            return state.sessions
        },
    },
    mutations: {
        SET_SESSIONS(state, sessions) {
            state.sessions = sessions
        },
        SET_PAGINATION(state, pagination) {
            state.pagination = pagination;
        },
        ADD_SESSION(state, data) {
            state.sessions.push(data);
        },
        UPDATE_SESSION(state, data) {
            // state.sessions.splice(state.sessions.indexOf(data.id), 1, data)
            const pos = state.sessions.map((e) => e.id).indexOf(data.id);
            state.sessions.splice(pos, 1, data)
        },
        REMOVE_SESSION(state, id) {
            state.sessions = state.sessions.filter(session => session.id !== id);
        },
    },
    actions: {
        async fetchSessions(context) {
            try {
                const response = await axios.get('/api/sessions')
                context.commit('SET_SESSIONS', response.data.data)
                //    console.log(response);
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
    }
}
