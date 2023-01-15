import axios from 'axios'

export default {
    namespaced: true,
    state: {
        departments: [],
    },
    getters: {
        departments(state) {
            return state.departments
        },
    },
    mutations: {
        SET_DEPARTMENTS(state, departments) {
            state.departments = departments
        },
        SET_PAGINATION(state, pagination) {
            state.pagination = pagination;
        },
        ADD_DEPARTMENT(state, data) {
            state.departments.push(data);
        },
        UPDATE_DEPARTMENT(state, data) {
            const pos = state.departments.map((e) => e.id).indexOf(data.id);
            state.departments.splice(pos, 1, data)
        },
        REMOVE_DEPARTMENT(state, id) {
            state.departments = state.departments.filter(session => session.id !== id);
        },
    },
    actions: {
        async fetchDepartments(context) {
            try {
                const response = await axios.get('/api/departments')
                context.commit('SET_DEPARTMENTS', response.data.data)
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
    }
}
