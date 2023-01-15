import axios from 'axios'

export default {
    namespaced: true,
    state: {
        accountants: [],
        pagination: {}
    },
    getters: {
        accountants(state) {
            return state.accountants
        },
        pagination(state) {
            return state.pagination
        },
    },
    mutations: {
        SET_ACCOUNTANTS(state, accountants) {
            state.accountants = accountants
        },
        SET_PAGINATION(state, pagination) {
            state.pagination = pagination;
        },
        ADD_ACCOUNTANT(state, data) {
            state.accountants.push(data);
        },
        UPDATE_ACCOUNTANT(state, data) {
            const pos = state.accountants.map((e) => e.id).indexOf(data.id);
            state.accountants.splice(pos, 1, data)
        },

        REMOVE_ACCOUNTANT(state, id) {
            state.accountants = state.accountants.filter(accountant => accountant.id !== id);
        },
    },
    actions: {
        async fetchAccountants(context, query) {
            try {
                let url = `/api/accountants?page=${query.page}`;
                if (query.search != 'undefined') {
                    url = `${url}&search=${query.search}`;
                }
                const response = await axios.get(url)

                context.commit('SET_ACCOUNTANTS', response.data.data)
                context.commit('SET_PAGINATION', response.data.meta)
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
    }
}
