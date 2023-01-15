import axios from 'axios'

export default {
    namespaced: true,
    state: {
        permissions: [],
    },
    getters: {
        permissions(state){
            return state.permissions
        },
    },
    mutations: {
        FETCH_PERMISSIONS(state, responseData){
            state.permissions = responseData
        },
    },
    actions: {
        fetchPermissions(context){
            axios.get('/api/roles/create').then((response) => {
                context.commit('FETCH_PERMISSIONS', response.data.permissions)
            })
            .catch((err) => {
              console.log(err);
            });
        },
    }
}
