<template>
    <ul class="navbar-nav" :class="listClass">
        <li class="nav-item">
            <router-link class="nav-link" :to="{ name: 'home' }">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <icon-home />
                </span>
                <span class="nav-link-title">
                    {{ $t("dashboard") }}
                </span>
            </router-link>
        </li>
        <dropdown :title="$t('academic')">
            <template v-slot:icon>
                <icon-book />
            </template>
            <router-link :to="{ name: 'student-attendance' }" class="dropdown-item">
                {{ $t("attendance") }}
            </router-link>
            <router-link :to="{ name: 'student-class-routine' }" class="dropdown-item">
                {{ $t("class_routine") }}
            </router-link>
            <router-link class="dropdown-item" :to="{ name: 'student-syllabus' }">
                {{ $t("syllabus") }}
            </router-link>
            <router-link class="dropdown-item" :to="{ name: 'student-homework' }">
                {{ $t("homework") }}
            </router-link>
            <router-link :to="{ name: 'student-subjects' }" class="dropdown-item">
                {{ $t("subject") }}
            </router-link>
        </dropdown>
        <dropdown :title="$t('exam')">
            <template v-slot:icon>
                <icon-edit-circle />
            </template>
            <router-link :to="{ name: 'student-exam-routine' }" class="dropdown-item">
                {{ $t("exam_routine") }}
            </router-link>
            <router-link :to="{ name: 'student-exam-results' }" class="dropdown-item">
                {{ $t("exam_result") }}
            </router-link>
        </dropdown>

        <li class="nav-item">
            <router-link class="nav-link" :to="{ name: 'event-calendar' }">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <icon-event />
                </span>
                <span class="nav-link-title"> {{ $t("event") }} </span>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" :to="{ name: 'student-teachers' }">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <icon-users />
                </span>
                <span class="nav-link-title"> {{ $t("teachers_list") }} </span>
            </router-link>
        </li>
        <li class="nav-item">
            <logout linkClass="nav-link" :title="false">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <icon-logout />
                </span>
                <span class="nav-link-title">
                    {{ $t("logout") }}
                </span>
            </logout>
        </li>
        <li class="nav-item ml-50 pt-5">
            <Clock :showClock="false" />
        </li>
    </ul>
</template>

<script>
    import {
        mapGetters,
        mapActions
    } from "vuex";
    import Logout from "../../../Logout";
    import Dropdown from "../../../Dropdown.vue";

    export default {
        props: ["listClass"],
        components: {
            Dropdown,
            Logout,
        },
        computed: {
            ...mapGetters({
                authenticated: "auth/authenticated",
                user: "auth/user",
                setting: "setting/setting",
            }),
        },
        methods: {
            ...mapActions({
                logoutAction: "auth/logout",
            }),
            visitWebsite() {
                window.location.href = "http://127.0.0.1:8000/";
            },
        },
    };
</script>
