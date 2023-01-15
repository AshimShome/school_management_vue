import axios from 'axios'

export default {
    namespaced: true,
    state: {
        teachers: [],
        pagination: {}
    },
    getters: {
        teachers(state) {
            return state.teachers
        },
        pagination(state) {
            return state.pagination
        },
    },
    mutations: {
        SET_TEACHERS(state, teachers) {
            state.teachers = teachers
        },
        SET_PAGINATION(state, pagination) {
            state.pagination = pagination;
        },
        ADD_TEACHER(state, data) {
            state.teachers.push(data);
        },
        UPDATE_TEACHER(state, data) {
            const pos = state.teachers.map((e) => e.id).indexOf(data.id);
            state.teachers.splice(pos, 1, data)
        },

        REMOVE_TEACHER(state, id) {
            state.teachers = state.teachers.filter(teacher => teacher.id !== id);
        },
    },
    actions: {
        async fetchTeachers(context, query) {
            try {
                let url = `/api/teachers?page=${query.page}`;
                if (query.search != 'undefined') {
                    url = `${url}&search=${query.search}`;
                }
                const response = await axios.get(url)

                context.commit('SET_TEACHERS', response.data.data)
                context.commit('SET_PAGINATION', response.data.meta)
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
    }
}
