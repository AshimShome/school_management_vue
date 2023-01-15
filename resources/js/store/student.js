import axios from 'axios'

export default {
    namespaced: true,
    state: {
        students: [],
        pagination: {}
    },
    getters: {
        students(state) {
            return state.students
        },
        pagination(state) {
            return state.pagination
        },
    },
    mutations: {
        SET_STUDENTS(state, students) {
            state.students = students
        },
        SET_PAGINATION(state, pagination) {
            state.pagination = pagination;
        },
        ADD_STUDENT(state, data) {
            state.students.push(data)
        },
        UPDATE_STUDENT(state, data) {
            state.students.splice(state.students.indexOf(data.id), 1, data)
        },
        REMOVE_STUDENT(state, id) {
            state.students = state.students.filter(item => item.id !== id);
        },
    },
    actions: {
        async fetchStudents(context, query) {
            try {
                let url = `/api/students?page=${query.page}`;
                if (query.search != 'undefined') {
                    url = `${url}&search=${query.search}`;
                }
                const response = await axios.get(url)

                context.commit('SET_STUDENTS', response.data.data)
                context.commit('SET_PAGINATION', response.data.meta)
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
    }
}
