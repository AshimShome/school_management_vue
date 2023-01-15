<template>
    <ul class="navbar-nav" :class="listClass">
        <li class="nav-item">
            <router-link class="nav-link" :to="{ name: 'home' }" :class="{ active: checkRoute('home') }">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <icon-home />
                </span>
                <span class="nav-link-title"> {{ $t("dashboard") }} </span>
            </router-link>
        </li>
        <dropdown :title="$t('academic')" :active="
        checkRoute([
          'parent-student-attendance',
          'parent-student-class-routine',
          'parent-student-syllabus',
          'parent-student-homework',
          'parent-subjects',
        ])
      ">
            <template v-slot:icon>
                <icon-book />
            </template>
            <router-link :to="{ name: 'parent-student-attendance' }" class="dropdown-item"
                :class="{ active: checkRoute('parent-student-attendance') }">
                {{ $t("attendance") }}
            </router-link>
            <router-link :to="{ name: 'parent-student-class-routine' }" class="dropdown-item"
                :class="{ active: checkRoute('parent-student-class-routine') }">
                {{ $t("class_routine") }}
            </router-link>
            <router-link class="dropdown-item" :to="{ name: 'parent-student-syllabus' }"
                :class="{ active: checkRoute('parent-student-syllabus') }">
                {{ $t("syllabus") }}
            </router-link>
            <router-link class="dropdown-item" :to="{ name: 'parent-student-homework' }"
                :class="{ active: checkRoute('parent-student-homework') }">
                {{ $t("homework") }}
            </router-link>
            <router-link :to="{ name: 'parent-subjects' }" class="dropdown-item"
                :class="{ active: checkRoute('parent-subjects') }">
                {{ $t("subject") }}
            </router-link>
        </dropdown>
        <li class="nav-item">
            <router-link class="nav-link" :to="{ name: 'parent-student-fees' }"
                :class="{ active: checkRoute('parent-student-fees') }">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <icon-event />
                </span>
                <span class="nav-link-title"> {{ $t("fees") }} </span>
            </router-link>
        </li>
        <dropdown :title="$t('exam')" :active="
        checkRoute([
          'parent-student-exam-routine',
          'parent-student-exam-results',
        ])
      ">
            <template v-slot:icon>
                <icon-edit-circle />
            </template>
            <router-link :to="{ name: 'parent-student-exam-routine' }" class="dropdown-item"
                :class="{ active: checkRoute('parent-student-exam-routine') }">
                {{ $t("exam_routine") }}
            </router-link>
            <router-link :to="{ name: 'parent-student-exam-results' }" class="dropdown-item"
                :class="{ active: checkRoute('parent-student-exam-results') }">
                {{ $t("exam_result") }}
            </router-link>
        </dropdown>

        <li class="nav-item">
            <router-link class="nav-link" :to="{ name: 'event-calendar' }"
                :class="{ active: checkRoute('event-calendar') }">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <icon-event />
                </span>
                <span class="nav-link-title"> {{ $t("event") }} </span>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" :to="{ name: 'student-teachers' }"
                :class="{ active: checkRoute('student-teachers') }">
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
        <li class="text-center mt-auto">
            <Clock />
        </li>
    </ul>
</template>

<script>
    import {
        mapGetters,
        mapActions
    } from "vuex";
    import Logout from "../../../Logout.vue";
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
