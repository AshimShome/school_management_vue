import axios from 'axios'

export default {
    namespaced: true,
    state: {
        users: {},
    },
    getters: {
        users(state){
            return state.users
        }
    },
    mutations: {
        FETCH_USERS(state, responseData){
            state.users = responseData
        },
    },
    actions: {
        fetchUsers(context){
            axios.get('/api/users').then((response) => {
                context.commit('FETCH_USERS', response.data.users)
            }).catch((err) => {
              console.log(err);
            });
        }
    }
}
