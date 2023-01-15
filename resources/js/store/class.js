import axios from 'axios'

export default {
    namespaced: true,
    state: {
        classes: [],
        classrooms: []
    },
    getters: {
        classes(state) {
            return state.classes
        },
        classrooms(state) {
            return state.classrooms
        },
    },
    mutations: {
        FETCH_CLASSES(state, responseData) {
            state.classes = responseData
        },
        FETCH_CLASSROOMS(state, responseData) {
            state.classrooms = responseData
        },
        ADD_CLASSROOM(state, data) {
            state.classrooms.push(data)
        },
        UPDATE_CLASSROOM(state, data) {
            state.classrooms.splice(state.classrooms.indexOf(data.id), 1, data)
        },
        REMOVE_CLASSROOM(state, id) {
            state.classrooms = state.classrooms.filter(item => item.id !== id);
        },
        async REMOVE_CLASS(state, id) {
            state.classes = state.classes.filter(item => item.id !== id);
        }
    },
    actions: {
        async fetchClasses(context) {
            try {
                let response = await axios.get('/api/classes')
                context.commit('FETCH_CLASSES', response.data.classes)
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(err);
            }
        },
        async fetchClassrooms(context) {
            try {
                let response = await axios.get('/api/classrooms')
                context.commit('FETCH_CLASSROOMS', response.data.classrooms)
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(err);
            }
        },
        async removeClass(context, id) {
            try {
                const response = await axios.delete(`/api/classes/${id}`)
                context.commit('REMOVE_CLASS', id);
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error)
            }
        }
    }
}
