import axios from 'axios'

export default {
    namespaced: true,
    state: {
        roles: {},
        rolesList: {},
    },
    getters: {
        roles(state) {
            return state.roles
        },
        rolesList(state) {
            return state.rolesList
        }
    },
    mutations: {
        FETCH_ROLES_WITH_PERMISSION(state, responseData) {
            state.roles = responseData
        },
        FETCH_ROLES(state, responseData) {
            state.rolesList = responseData
        }
    },
    actions: {
        fetchRolesWithPermissions(context) {
            axios.get('/api/roles')
                .then((response) => {
                    context.commit('FETCH_ROLES_WITH_PERMISSION', response.data.roles)
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        fetchRoles(context) {
            axios.get('/api/roles/list')
                .then((response) => {
                    context.commit('FETCH_ROLES', response.data)
                })
                .catch((err) => {
                    console.log(err);
                });
        }
    }
}
