import axios from 'axios'

export default {
    namespaced: true,
    state: {
        userPermissions: [],
        permissionLoaded: false,
    },
    getters: {
        userHasPermission: (state) => (permissions) => {
            let hasPermission = state.userPermissions.find(permission => permission.name === permissions);
            return hasPermission ? true : false;
        },
        getPermissionLoadingStatus(state){
            return state.permissionLoaded;
        }
    },
    mutations: {
        USER_PERMISSIONS (state, value) {
            state.userPermissions = value
        },
        SET_PERMISSION_LOAD_STATUS(state, value){
            state.permissionLoaded = value;
        }
    },
    actions: {
        loadUserPermissions(context){
            axios.get('/api/role/wise/permissions')
            .then((response) => {
                context.commit('USER_PERMISSIONS', response.data.roleWisePermissions)

                setTimeout(() => {
                    context.commit('SET_PERMISSION_LOAD_STATUS', true);
                }, 1500);
            })
            .catch((err) => {
                console.log(err);
            });
        }
    }
}
