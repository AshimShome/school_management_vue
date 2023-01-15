<template>
    <div>
        <admin-dashboard listClass="pt-lg-3"
                         v-if="userType == 'admin' && userRole != 'Student' && userType != 'guardian' && userRole != 'Teacher' && userRole != 'Accountant'" />
        <students-dashboard listClass="pt-lg-3" v-if="userType == 'student' && userRole == 'Student'" />
        <parents-dashboard listClass="pt-lg-3" v-if="userType == 'guardian' && userRole == 'Guardian'" />
        <teachers-dashboard listClass="pt-lg-3" v-if="userType == 'staff' && userRole == 'Teacher'" />
        <accountants-dashboard listClass="pt-lg-3" v-if="userType == 'staff' && userRole == 'Accountant'" />
    </div>
</template>

<script>
    export default {
        components: {
            AdminDashboard: () => import("./admin/dashboard.vue"),
            StudentsDashboard: () => import("./student/dashboard.vue"),
            ParentsDashboard: () => import("./parent/dashboard.vue"),
            TeachersDashboard: () => import("./teacher/dashboard.vue"),
            AccountantsDashboard: () => import("./accountant/dashboard.vue"),
        },
        computed: {
            user() {
                return this.$store.getters["auth/user"];
            },
            userType() {
                return this.user.role;
            }
        },
    };
</script>
