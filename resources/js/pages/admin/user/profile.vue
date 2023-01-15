<template>
    <div>
        <AdminProfile v-if="authenticateUser.role == 'admin'"/>
        <StudentProfile v-else-if="authenticateUser.role == 'student'"/>
        <StaffProfile v-else-if="authenticateUser.role == 'staff'"/>
        <ParentProfile v-else-if="authenticateUser.role == 'guardian'"/>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import AdminProfile from "../../../components/profile/AdminProfile.vue";
import StudentProfile from "../../../components/profile/StudentProfile.vue";
import StaffProfile from "../../../components/profile/StaffProfile.vue";
import ParentProfile from "../../../components/profile/ParentProfile.vue";

export default {
    components: {
        AdminProfile,
        StudentProfile,
        StaffProfile,
        ParentProfile
    },
    data() {
        return {
            passwordForm: new Form({
                oldPassword: "",
                newPassword: ""
            })
        };
    },
    methods: {
        passwordUpdate() {
            this.passwordForm
                .put(`/api/user/password/update/${this.user.id}`)
                .then(response => {
                    let responseType = response.data.success;

                    if (responseType) {
                        this.passwordForm.reset();
                        this.$store.dispatch("auth/authUser");
                        this.toastSuccess(response.data.message);
                    } else {
                        this.toastError();
                    }
                });
        }
    },
    computed: {
        ...mapGetters({
            user: "auth/user"
        })
    }
};
</script>
