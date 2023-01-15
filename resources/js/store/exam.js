import axios from 'axios'

export default {
    namespaced: true,
    state: {
        exams: [],
        examList: [],
        upcomingExams: [],
        pagination: {}
    },
    getters: {
        exams(state) {
            return state.exams
        },
        examList(state) {
            return state.examList
        },
        pagination(state) {
            return state.pagination
        },
        upcomingExams(state) {
            return state.upcomingExams
        },
    },
    mutations: {
        SET_EXAMS(state, exams) {
            state.exams = exams
        },
        SET_EXAMS_LIST(state, exams) {
            state.examList = exams
        },
        SET_PAGINATION(state, pagination) {
            state.pagination = pagination;
        },
        ADD_EXAM(state, data) {
            state.exams.push(data);
        },
        UPDATE_EXAM(state, data) {
            state.exams.splice(state.exams.indexOf(data.id), 1, data)
        },
        REMOVE_EXAM(state, id) {
            state.exams = state.exams.filter(exam => exam.id !== id);
        },
        SET_UPCOMING_EXAMS(state, data) {
            state.upcomingExams = data;
        },
    },
    actions: {
        async fetchExams(context, query) {
            try {
                let url = `/api/exams?page=${query.page}`;
                if (query.search != 'undefined') {
                    url = `${url}&search=${query.search}`;
                }

                const response = await axios.get(url)
                context.commit('SET_EXAMS', response.data.data)
                context.commit('SET_PAGINATION', response.data.meta)
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async fetchExamsList(context) {
            try {
                const response = await axios.get('/api/exams/list')
                context.commit('SET_EXAMS_LIST', response.data)
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async fetchUpcomingExams(context) {
            try {
                const response = await axios.get('/api/exams/upcoming-exams')
                context.commit('SET_UPCOMING_EXAMS', response.data.data)
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        }
    }
}
