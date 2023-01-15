import Vue from 'vue';
import axios from 'axios';
// axios
// axios.defaults.baseURL = 'http://127.0.0.1:8000'
// axios.defaults.headers['Accept-Language'] = lang;
// document.documentElement.lang = lang;
Vue.config.productionTip = false

axios.interceptors.response.use(response => {
    if (response.status === 200 || response.status === 201 || response.status === 204) {
        return Promise.resolve(response);
    } else {
        return Promise.reject(response);
    }
}, error => {
    if (error.response.status) {
        switch (error.response.status) {
            case 401:
                localStorage.removeItem("auth");
                break;
            case 404:
                router.push({
                    name: '404'
                });
                break;
            case 422:
                return Promise.reject(error);
                break;
            case 500:
                Vue.$toast.error('Something went wrong, Please try again.', {
                    position: 'top-right',
                    duration: 3000,
                });
                break
        }
        return Promise.reject(error.response);
    }
});
