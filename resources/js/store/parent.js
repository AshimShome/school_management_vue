import axios from 'axios'

export default {
    namespaced: true,
    state: {
        guardians: [],
        pagination: {},
        childs: [],
    },
    getters: {
        guardians(state) {
            return state.guardians
        },
        pagination(state) {
            return state.pagination
        },
        getChilds(state) {
            return state.childs
        },
    },
    mutations: {
        SET_GUARDIANS(state, guardians) {
            state.guardians = guardians
        },
        SET_PAGINATION(state, pagination) {
            state.pagination = pagination;
        },
        ADD_GUARDIAN(state, data) {
            state.guardians.push(data);
        },
        UPDATE_GUARDIAN(state, data) {
            const pos = state.guardians.map((e) => e.id).indexOf(data.id);
            state.guardians.splice(pos, 1, data)
        },
        REMOVE_GUARDIAN(state, id) {
            state.guardians = state.guardians.filter(guardian => guardian.id !== id);
        },
        SET_CHILDRENS(state, data) {
            state.childs = data;
        },

    },
    actions: {
        async fetchGuardians(context, query) {
            try {
                let url = `/api/guardians?page=${query.page}`;
                if (query.search != 'undefined') {
                    url = `${url}&search=${query.search}`;
                }
                const response = await axios.get(url)

                context.commit('SET_GUARDIANS', response.data.data)
                context.commit('SET_PAGINATION', response.data.meta)
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async fetchChilds(context) {
            if (context.state.childs.length > 0) {
                return;
            }

            let response = await axios.get('/api/parent/students');
            context.commit('SET_CHILDRENS', response.data.data)
        }
    }
}
