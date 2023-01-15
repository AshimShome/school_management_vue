import axios from 'axios'

export default {
    namespaced: true,
    state: {
        schedules: [],
        pagination: {}
    },
    getters: {
        schedules(state) {
            return state.schedules
        },
        pagination(state) {
            return state.pagination
        },
    },
    mutations: {
        SET_SCHEDULES(state, schedules) {
            state.schedules = schedules
        },
        SET_PAGINATION(state, pagination) {
            state.pagination = pagination;
        },
        ADD_SCHEDULE(state, data) {
            state.schedules.push(data);
        },
        UPDATE_SCHEDULE(state, data) {
            const pos = state.schedules.map((e) => e.id).indexOf(data.id);
            state.schedules.splice(pos, 1, data)
        },
        REMOVE_SCHEDULE(state, id) {
            state.schedules = state.schedules.filter(exam => exam.id !== id);
        },
    },
    actions: {
        async fetchExamSchedules(context, exam) {
            try {
                const response = await axios.get(`/api/exams/${exam}/schedules`)
                context.commit('SET_SCHEDULES', response.data.data)
                context.commit('SET_PAGINATION', response.data.meta)
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async removeSchedule(context, data) {
            try {
                const response = await axios.delete(`/api/exams/${data.exam_id}/schedules/${data.schedule_id}`);
                context.commit('REMOVE_SCHEDULE', data.schedule_id);
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error)
            }
        }
    }
}
