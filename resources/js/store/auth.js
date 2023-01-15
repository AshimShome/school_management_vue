import axios from 'axios'
import router from '../router'

export default {
    namespaced: true,
    state: {
        authenticated: false,
        user: null
    },

    getters: {
        authenticated (state) {
            return state.authenticated
        },
        user (state) {
            return state.user
        },
    },

    mutations: {
        SET_AUTHENTICATED (state, value) {
            state.authenticated = value
        },

        SET_USER (state, value) {
            state.user = value
        }
    },

    actions: {
        async login ({ commit, dispatch }, form) {
            await axios.get('/sanctum/csrf-cookie')
            await form.post('/login')
            
            return dispatch('authUser')
        },
        async logout ({ dispatch }) {
            await axios.post('/logout')

            return dispatch('authUser')
        },

        authUser ({ commit, dispatch }) {
            return axios.get('/api/user').then((response) => {
                commit('SET_AUTHENTICATED', true)
                commit('SET_USER', response.data)
                localStorage.setItem("auth", true);

                dispatch('rolepermission/loadUserPermissions', null, {root:true});
                
                if(router.currentRoute.name !== null){
                    router.push({ name: 'home' })
                };

            }).catch(() => {
                commit('SET_AUTHENTICATED', false)
                commit('SET_USER', null)
                localStorage.removeItem("auth");

                if(router.currentRoute.name !== 'login'){
                    router.push({ name: 'login' })
                };
            })
        },
    }
}
