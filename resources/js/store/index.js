import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import auth from './auth'
import user from './user'
import role from './role'
import permission from './permission'
import rolepermission from './rolepermission'
import setting from './setting'
import section from './section'
import session from './session'
import classs from './class'
import subject from './subject'
import student from './student'
import parent from './parent'
import teacher from './teacher'
import accountant from './accountant'
import exam from './exam'
import examschedule from './examschedule'
import examResultRule from './examResultRule'
import classRoutine from './classRoutine'
import calendar from './calendar'
import department from './department'
import fee from './fee'
import expense from './expense'
import notification from './notification'
import homework from './homework'

Vue.use(Vuex)

const store = new Vuex.Store({
    modules: {
        auth,
        user,
        role,
        permission,
        rolepermission,
        section,
        setting,
        session,
        classs,
        subject,
        student,
        parent,
        teacher,
        accountant,
        exam,
        examschedule,
        examResultRule,
        classRoutine,
        calendar,
        department,
        fee,
        expense,
        notification,
        homework
    },
    state: {
        userPermissions: [],
        darkMode: JSON.parse(localStorage.getItem('toggleDarkMode')) === true ? true : false,
        languageList: [],
    },
    getters: {
        getUserPermissions(state) {
            return state.userPermissions
        },
        userHasPermission: (state) => (name) => {
            let hasPermission = state.userPermissions.find(permission => permission.name === name);
            return hasPermission ? true : false;
        },
        getMode(state) {
            return state.darkMode
        },
        getAllLocales(state) {
            return state.languageList;
        },
        getLanguageList(state) {
            return state.languageList;
        }
    },
    actions: {
        async loadLanguageList({
            commit
        }) {
            try {
                const {
                    data
                } = await axios.get('/api/languages');

                commit("SET_ALL_LANGUAGES", data);
            } catch (error) {
                this.toastError(error.response.data.message);
                // mixin.toastError();
            }
        },
    },
    mutations: {
        USER_PERMISSIONS(state, data) {
            state.userPermissions = data
        },
        SET_DARK_MODE(state) {
            state.darkMode = !state.darkMode

            if (state.darkMode) {
                document.body.classList.add('theme-dark')
            } else {
                document.body.classList.remove('theme-dark')
            }

            localStorage.setItem('toggleDarkMode', state.darkMode);
        },
        SET_ALL_LANGUAGES(state, data) {
            state.languageList = data;
        },
    }
});

export default store;
