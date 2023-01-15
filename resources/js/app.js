require('./bootstrap');
import Vue from 'vue';
import App from './App.vue'
import router from './router/index';
import store from './store/index';
import axios from 'axios';


// Plugins
import VueI18n from 'vue-i18n';
Vue.use(VueI18n);

import './plugins/axios.js';
import './plugins/mixins';
import './plugins/toastr.js';
import './plugins/sweetalert2.js';
import './plugins/vform.js';
import './plugins/vselect.js';
import './plugins/filter.js';
import './plugins/tippy.js';
import './plugins/vdatepicker.js';
import './plugins/typeahead.js';
import './plugins/pagetransaction.js';
import './plugins/vtooltip.js';

// Components
import './globalcomponent.js';

// Auth
function isLoggedIn() {
    return store.getters['auth/authenticated'];
}

// axios
window.axios = require('axios');
axios.defaults.withCredentials = true;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

axios.interceptors.response.use(response => {
    if (response.status === 200 || response.status === 201 || response.status === 204) {
        return Promise.resolve(response);
    } else {
        return Promise.reject(response);
    }
}, error => {
    console.log(error)
    if (error.status == 429) {
        Vue.swal({
            title: 'Too many requests',
            text: 'Too many requests, please try again later.',
            icon: 'error',
            type: 'error',
        });
    }

    if (error.status == 409) {
        Vue.swal({
            title: 'Conflict Error',
            text: error.data.errors.message || 'Conflict Error, please try again later.',
            icon: 'error',
            type: 'error',
        });
    }

    if (error.response.status) {
        switch (error.response.status) {
            case 401:
                if (router.currentRoute.name !== 'login') {
                    Vue.swal({
                        title: 'Unauthenticated',
                        text: 'You"re logged out, Please login again.',
                        icon: 'error',
                        type: 'error',
                    });

                    localStorage.removeItem("auth");
                    store.dispatch('auth/logout');
                };
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
                Vue.swal({
                    title: 'Internal Server Error',
                    text: 'Something went wrong, Please try again.',
                    icon: 'error',
                    type: 'error',
                });
                break
            default:
                Vue.swal({
                    title: 'Error',
                    text: 'Something went wrong, Please try again.',
                    icon: 'error',
                    type: 'error',
                });

        }
        return Promise.reject(error.response);
    }
});

// middleware
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (!isLoggedIn()) {
            next({
                name: 'login',
            })
        } else {
            next()
        }
    } else if (to.matched.some(record => record.meta.requiresVisitor)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (isLoggedIn()) {
            next({
                name: 'home',
            })
        } else {
            next()
        }
    } else {
        next() // make sure to always call next()!
    }
})

// initialize app
async function initializeApp() {
    const {
        data
    } = await axios.get('/api/languages');
    let app_default = await axios.get('/api/app/default');
    store.commit("SET_ALL_LANGUAGES", data);

    let default_language = app_default.data.language
    let local_language = localStorage.getItem('lang')
    let set_language = local_language ? local_language : default_language

    const i18n = new VueI18n({
        locale: set_language,
        fallbackLocale: set_language,
        messages: data,
        silentTranslationWarn: true
    });

    new Vue({
        router,
        store,
        i18n,
        render: h => h(App)
    }).$mount('#app')
}

// check auth middleware
let auth = localStorage.getItem("auth");
if (auth) {
    store.dispatch('auth/authUser').then(() => {
        initializeApp();
    });
} else {
    initializeApp();
}
