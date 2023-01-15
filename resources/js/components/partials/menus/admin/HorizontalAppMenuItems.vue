<template>
  <ul class="navbar-nav" :class="listClass">
    <li class="nav-item">
      <router-link
        class="nav-link"
        :to="{ name: 'home' }"
        :class="{ active: checkRoute('home') }"
      >
        <span class="nav-link-icon d-md-none d-lg-inline-block">
          <icon-home />
        </span>
        <span class="nav-link-title">
          {{ $t("dashboard") }}
        </span>
      </router-link>
    </li>
    <dropdown :title="$t('attendance')">
      <template v-slot:icon>
        <icon-note />
      </template>
      <router-link
        v-if="checkPermission('student-attendance-list')"
        :to="{ name: 'attendence-student' }"
        class="dropdown-item"
      >
        {{ $t("student_attendance") }}
      </router-link>
      <router-link
        v-if="checkPermission('teacher-attendance-list')"
        :to="{ name: 'attendence-teacher' }"
        class="dropdown-item"
      >
        {{ $t("teacher_attendance") }}
      </router-link>
    </dropdown>
    <dropdown :title="$t('academic')">
      <template v-slot:icon>
        <icon-book />
      </template>
      <router-link
        v-if="checkPermission('session-list')"
        :to="{ name: 'academic-session' }"
        class="dropdown-item"
      >
        {{ $t("session") }}
      </router-link>
      <router-link
        v-if="checkPermission('department-list')"
        :to="{ name: 'department' }"
        class="dropdown-item"
      >
        {{ $t("department") }}
      </router-link>
      <router-link
        v-if="checkPermission('class-routine-list')"
        :to="{ name: 'academic-routine' }"
        class="dropdown-item"
      >
        {{ $t("routine") }}
      </router-link>
      <router-link
        v-if="checkPermission('class-room-list')"
        :to="{ name: 'academic-classroom' }"
        class="dropdown-item"
      >
        {{ $t("class_room") }}
      </router-link>
      <router-link
        v-if="checkPermission('class-list')"
        :to="{ name: 'academic-class' }"
        class="dropdown-item"
      >
        {{ $t("class") }}
      </router-link>
      <router-link
        v-if="checkPermission('section-list')"
        :to="{ name: 'academic-section' }"
        class="dropdown-item"
      >
        {{ $t("section") }}
      </router-link>
      <router-link
        v-if="checkPermission('subject-list')"
        :to="{ name: 'academic-subject' }"
        class="dropdown-item"
      >
        {{ $t("subject") }}
      </router-link>
      <router-link
        :to="{ name: 'academic-syllabus' }"
        class="dropdown-item"
        v-if="checkPermission('subject-list')"
      >
        {{ $t("syllabus") }}
      </router-link>
      <router-link
        :to="{ name: 'academic-homework' }"
        class="dropdown-item"
        v-if="checkPermission('homework-list')"
      >
        {{ $t("homework") }}
      </router-link>
    </dropdown>
    <dropdown :title="$t('users')">
      <template v-slot:icon>
        <icon-users />
      </template>
      <router-link :to="{ name: 'user' }" class="dropdown-item">
        {{ $t("admin") }}
      </router-link>
      <router-link
        v-if="checkPermission('student-list')"
        :to="{ name: 'user-student' }"
        class="dropdown-item"
      >
        {{ $t("student") }}
      </router-link>
      <router-link
        v-if="checkPermission('parent-list')"
        :to="{ name: 'user-guardian' }"
        class="dropdown-item"
      >
        {{ $t("parent") }}
      </router-link>
      <router-link
        v-if="checkPermission('teacher-list')"
        :to="{ name: 'user-teacher' }"
        class="dropdown-item"
      >
        {{ $t("teacher") }}
      </router-link>
      <router-link
        v-if="checkPermission('accountant-list')"
        :to="{ name: 'user-accountant' }"
        class="dropdown-item"
      >
        {{ $t("accountant") }}
      </router-link>
    </dropdown>

        <dropdown :title="$t('exam')">
            <template v-slot:icon>
                <icon-edit-circle />
            </template>
            <router-link v-if="checkPermission('exam-list')" :to="{ name: 'exam' }" class="dropdown-item">
                {{ $t("exam_list") }}
            </router-link>
            <router-link v-if="checkPermission('exam-schedule-list')" :to="{ name: 'exam-schedule' }"
                class="dropdown-item">
                {{ $t("schedule") }}
            </router-link>
            <router-link v-if="checkPermission('exam-mark-list')" :to="{ name: 'exam-mark' }" class="dropdown-item">
                {{ $t("mark") }}
            </router-link>
            <router-link v-if="checkPermission('exam-result-rule-list')" :to="{ name: 'exam-result-rule' }"
                class="dropdown-item">
                {{ $t("result_rule") }}
            </router-link>
            <router-link v-if="checkPermission('exam-result-report')" :to="{ name: 'exam-result' }"
                class="dropdown-item">
                {{ $t("exam_result") }}
            </router-link>
            <router-link v-if="checkPermission('exam-rule-list')" :to="{ name: 'exam-result-rule' }"
                class="dropdown-item">
                {{ $t("result_rule") }}
            </router-link>
            <router-link v-if="checkPermission('exam-result-list')" :to="{ name: 'exam-result' }" class="dropdown-item">
                {{ $t("exam_result") }}
            </router-link>
            <router-link v-if="checkPermission('promotion-list')" :to="{ name: 'promotion' }" class="dropdown-item">
                {{ $t("promotion") }}
            </router-link>
        </dropdown>

        <dropdown :title="$t('report')">
            <template v-slot:icon>
                <icon-report />
            </template>
            <router-link v-if="checkPermission('student-report')" :to="{ name: 'report-student' }"
                class="dropdown-item">
                {{ $t("student") }}
            </router-link>
            <router-link v-if="checkPermission('teacher-report')" :to="{ name: 'report-teacher' }"
                class="dropdown-item">
                {{ $t("teacher") }}
            </router-link>
            <router-link v-if="checkPermission('staff-report')" :to="{ name: 'report-staff' }" class="dropdown-item">
                {{ $t("staff") }}
            </router-link>
            <router-link v-if="checkPermission('class-routine-report')" :to="{ name: 'report-class-routine' }"
                class="dropdown-item">
                {{ $t("class_routine") }}
            </router-link>
            <router-link v-if="checkPermission('exam-schedule-report')" :to="{ name: 'report-exam-routine' }"
                class="dropdown-item">
                {{ $t("exam_routine") }}
            </router-link>

            <router-link v-if="checkPermission('student-attendance-report')" :to="{ name: 'report-student-attendance' }"
                class="dropdown-item">
                {{ $t("student_attendance") }}
            </router-link>
            <router-link v-if="checkPermission('teacher-attendance-report')" :to="{ name: 'report-teacher-attendance' }"
                class="dropdown-item">
                {{ $t("teacher_attendance") }}
            </router-link>
        </dropdown>

        <dropdown :title="$t('announcement')">
            <template v-slot:icon>
                <icon-bell />
            </template>
            <router-link v-if="checkPermission('message-notification-send')" :to="{ name: 'message' }"
                class="dropdown-item">
                {{ $t("message") }}
            </router-link>
            <router-link v-if="checkPermission('calendar-list')" :to="{ name: 'calendar' }" class="dropdown-item">
                {{ $t("calendar") }}
            </router-link>
        </dropdown>
        <dropdown :title="$t('accounting')">
            <template v-slot:icon>
                <icon-calculator />
            </template>
            <router-link v-if="checkPermission('fee-type-list')" :to="{ name: 'message' }" class="dropdown-item">
                {{ $t("fee_type") }}
            </router-link>
            <router-link v-if="checkPermission('fee-list')" :to="{ name: 'message' }" class="dropdown-item">
                {{ $t("fees") }}
            </router-link>
            <router-link v-if="checkPermission('expense-type-list')" :to="{ name: 'message' }" class="dropdown-item">
                {{ $t("expense_type") }}
            </router-link>
            <router-link v-if="checkPermission('expense-list')" :to="{ name: 'message' }" class="dropdown-item">
                {{ $t("expense_list") }}
            </router-link>
        </dropdown>
        <li class="nav-item" v-if="checkPermission('role-list')">
            <router-link class="nav-link" :to="{ name: 'role' }">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <icon-lock />
                </span>
                <span class="nav-link-title">
                    {{ $t("roles") }}
                </span>
            </router-link>
        </li>

        <li class="nav-item" v-if="checkPermission('role-list')">
            <router-link class="nav-link" :to="{ name: 'setting-admin' }">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <icon-cog />
                </span>
                <span class="nav-link-title">
                    {{ $t("settings") }}
                </span>
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

        <li class="nav-item" v-if="user.original_role === 'Teacher'">
            <router-link :to="{ name: 'attendence-student' }" class="btn btn-primary">
                {{ $t("take_attendance") }}
            </router-link>
        </li>
        <li class="nav-item" v-if="user.original_role === 'Accountant'">
            <router-link :to="{ name: 'fees-allocation' }" class="btn btn-primary btn-outline">
                {{ $t("fee_allocation") }}
            </router-link>
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
