import axios from 'axios'

export default {
    namespaced: true,

    state: {
        homeworks: [],
    },

    mutations: {
        SET_HOMEWORKS(state, homeworks) {
            state.homeworks = homeworks
        },
    },

    actions: {
        async fetchHomeworks(context) {
            try {
                const response = await axios.get('/api/homeworks')
                context.commit('SET_HOMEWORKS', response.data.data)
                // console.log(response);
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
    }

}
