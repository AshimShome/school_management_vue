import Vue from 'vue';
import dayjs from 'dayjs';
import 'dayjs/locale/en';
import LocalizedFormat from 'dayjs/plugin/localizedFormat';
import RelativeTime from 'dayjs/plugin/relativeTime';
import axios from 'axios';

dayjs.extend(LocalizedFormat);
dayjs.extend(RelativeTime);

Vue.prototype.$dayjs = dayjs;

const mixin = {
    methods: {
        formateDate(date, format = 'MMMM D, YYYY') {
            return dayjs(date).format(format);
        },
        timeFromNow(date) {
            return dayjs(date).fromNow();
        },
        checkRoute(routesName) {
            let type = typeof routesName;
            let currentRoute = this.$route.name;

            if (type === 'string') {
                return currentRoute === routesName;
            } else {
                const found = routesName.find(route => route == currentRoute);
                return found ? true : false
            }
        },
        checkPermission(permissions) {
            let permission = this.$store.getters['rolepermission/userHasPermission'](permissions);
            return permission;
        },
        hasPermisssion(permissions) {
            let hasPermission = this.$store.getters["rolepermission/userHasPermission"](permissions);
            if (!hasPermission) {
                this.$router.push({
                    name: "401"
                });
            }
        },

        // toastr notification
        toastSuccess(message = 'Data save Successfully!') {
            this.$toast.success({
                title: 'Success',
                message: message
            });
        },
        toastWarning(message = 'Something Went Wrong!') {
            this.$toast.warn({
                title: 'Warning',
                message: message
            })
        },
        toastError(message = 'Something Went Wrong!') {
            this.$toast.error({
                title: 'Sorry',
                message: message
            })
        },
        redirect(routeName) {
            this.$router.push({
                name: routeName
            });
        },
        redirectPath(url) {
            this.$router.push({
                path: url
            });
        },
        appCurrency(amount){
            return this.appSetting.currency_sign +' '+ amount;
        }
    },
    computed: {
        authenticateUser() {
            return this.$store.getters['auth/user']
        },
        userRole(){
            return this.authenticateUser.original_role
        },
        appSetting(){
            return this.$store.getters['setting/setting']
        }
    },
    filters: {
        replace(st, rep, repWith) {
            const result = st.split(rep).join(repWith);
            return result;
        }
    }
}

Vue.mixin(mixin)
