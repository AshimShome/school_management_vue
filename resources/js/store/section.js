import axios from 'axios'

export default {
    namespaced: true,
    state: {
        sections: []
    },
    getters: {
        sections(state) {
            return state.sections
        },
    },
    mutations: {
        FETCH_SECTIONS(state, responseData) {
            state.sections = responseData
        },
        ADD_SECTION(state, data) {
            state.sections.push(data)
        },
        UPDATE_SECTION(state, data) {
            state.sections.splice(state.sections.indexOf(data.id), 1, data)
        },
        REMOVE_SECTION(state, id) {
            state.sections = state.sections.filter(item => item.id !== id);
        }
    },
    actions: {
        async fetchSection(context) {
            try {
                let response = await axios.get('/api/sections')
                context.commit('FETCH_SECTIONS', response.data.sections)
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(err);
            }
        },
    }
}
