import axios from 'axios'

export default {
    namespaced: true,
    state: {
        feesTypes: []
    },
    getters: {
        feesType(state) {
            return state.feesTypes
        },
    },
    mutations: {
        FETCH_FEES_TYPE(state, responseData) {
            state.feesTypes = responseData
        },
        ADD_FEE_TYPE(state, data) {
            state.feesTypes.push(data)
        },
        UPDATE_FEE_TYPE(state, data) {
            const pos = state.feesTypes.map((e) => e.id).indexOf(data.id);
            state.feesTypes.splice(pos, 1, data)
        },
        REMOVE_FEE_TYPE(state, id) {
            state.feesTypes = state.feesTypes.filter(item => item.id !== id);
        }
    },
    actions: {
        async fetchFeesType(context) {
            try {
                let response = await axios.get('/api/feetypes')
                context.commit('FETCH_FEES_TYPE', response.data.feestype)
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(err);
            }
        },
    }
}
