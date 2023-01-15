import axios from 'axios'

export default {
    namespaced: true,
    state: {
        setting: {}
    },
    getters: {
        setting(state) {
            return state.setting;
        }
    },
    mutations: {
        SET_ADMIN_SETTING(state, responseData) {
            state.setting = responseData;
        }
    },
    actions: {
        async fetchSetting(context) {
            try {
                let response = await axios.get("/api/setting");
                context.commit("SET_ADMIN_SETTING", response.data.setting);
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        }
    }
};
