<template>
    <ul class="navbar-nav" :class="listClass">
        <li class="nav-item">
            <router-link class="nav-link" :class="{ active: checkRoute('home') }" :to="{ name: 'home' }">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <icon-home />
                </span>
                <span class="nav-link-title"> {{ $t("dashboard") }} </span>
            </router-link>
        </li>

    <dropdown
      :title="$t('attendance')"
      :active="checkRoute(['attendence-student', 'attendence-teacher'])"
      v-if="
        checkPermission('student-attendance-list') ||
        checkPermission('teacher-attendance-list')
      ">
            <template v-slot:icon>
                <icon-note />
            </template>
            <router-link :to="{ name: 'attendence-student' }" class="dropdown-item"
                :class="{ active: $route.name == 'attendence-student' }"
                v-if="checkPermission('student-attendance-list')">
                {{ $t("student_attendance") }}
            </router-link>
            <router-link :to="{ name: 'attendence-teacher' }" class="dropdown-item"
                :class="{ active: $route.name == 'attendence-teacher' }"
                v-if="checkPermission('teacher-attendance-list')">
                {{ $t("teacher_attendance") }}
            </router-link>
        </dropdown>

        <dropdown :title="$t('academic')" :active="
        checkRoute([
          'academic-session',
          'department',
          'academic-routine',
          'academic-routine-create',
          'academic-routine-edit',
          'academic-class',
          'academic-section',
          'academic-classroom',
          'academic-subject',
          'academic-syllabus-index',
          'academic-syllabus-create',
          'academic-homework',
          'academic-homework-create',
          'academic-homework-edit',
        ])
      " v-if="
        checkPermission('session-list') ||
        checkPermission('department-list') ||
        checkPermission('routine-list') ||
        checkPermission('class-room-list') ||
        checkPermission('class-list') ||
        checkPermission('section-list') ||
        checkPermission('subject-list') ||
        checkPermission('syllabus-list') ||
        checkPermission('homework-list')
      ">
            <template v-slot:icon>
                <icon-book />
            </template>
            <router-link :to="{ name: 'academic-session' }" class="dropdown-item"
                :class="{ active: checkRoute('academic-session') }" v-if="checkPermission('session-list')">
                {{ $t("session") }}
            </router-link>
            <router-link :to="{ name: 'department' }" class="dropdown-item"
                :class="{ active: checkRoute('department') }" v-if="checkPermission('department-list')">
                {{ $t("department") }}
            </router-link>
            <router-link :to="{ name: 'academic-routine' }" class="dropdown-item" :class="{
          active: checkRoute([
            'academic-routine',
            'academic-routine-create',
            'academic-routine-edit',
          ]),
        }" v-if="checkPermission('routine-list')">
                {{ $t("routine") }}
            </router-link>
            <router-link :to="{ name: 'academic-classroom' }" class="dropdown-item"
                :class="{ active: checkRoute('academic-classroom') }" v-if="checkPermission('class-room-list')">
                {{ $t("class_room") }}
            </router-link>
            <router-link :to="{ name: 'academic-class' }" class="dropdown-item"
                :class="{ active: checkRoute('academic-class') }" v-if="checkPermission('class-list')">
                {{ $t("class") }}
            </router-link>
            <router-link :to="{ name: 'academic-section' }" class="dropdown-item"
                :class="{ active: checkRoute('academic-section') }" v-if="checkPermission('section-list')">
                {{ $t("section") }}
            </router-link>
            <router-link :to="{ name: 'academic-subject' }" class="dropdown-item"
                :class="{ active: checkRoute('academic-subject') }" v-if="checkPermission('subject-list')">
                {{ $t("subject") }}
            </router-link>
            <router-link :to="{ name: 'academic-syllabus-index' }" class="dropdown-item" :class="{
          active: checkRoute([
            'academic-syllabus-index',
            'academic-syllabus-create',
            'academic-syllabus-edit',
          ]),
        }" v-if="checkPermission('syllabus-list')">
                {{ $t("syllabus") }}
            </router-link>
            <router-link :to="{ name: 'academic-homework' }" class="dropdown-item" :class="{
          active: checkRoute([
            'academic-homework',
            'academic-homework-create',
            'academic-homework-edit',
          ]),
        }" v-if="checkPermission('homework-list')">
                {{ $t("homework") }}
            </router-link>
        </dropdown>

        <dropdown :title="$t('users')" :active="
        checkRoute([
          'user',
          'user-add',
          'user-edit',
          'user-view',
          'user-student',
          'user-student-add',
          'user-student-edit',
          'user-guardian',
          'user-guardian-add',
          'user-guardian-edit',
          'user-guardian-view',
          'user-teacher',
          'user-teacher-add',
          'user-teacher-edit',
          'user-accountant',
          'user-accountant-add',
          'user-accountant-edit',
          'user-accountant-view',
          'user-student-view',
          'user-teacher-view',
        ])
      " v-if="
        checkPermission('user-list') ||
        checkPermission('user-create') ||
        checkPermission('user-edit') ||
        checkPermission('user-view') ||
        checkPermission('student-list') ||
        checkPermission('student-create') ||
        checkPermission('student-edit') ||
        checkPermission('student-view') ||
        checkPermission('parent-list') ||
        checkPermission('parent-create') ||
        checkPermission('parent-edit') ||
        checkPermission('parent-view') ||
        checkPermission('teacher-list') ||
        checkPermission('teacher-create') ||
        checkPermission('teacher-edit') ||
        checkPermission('teacher-view') ||
        checkPermission('accountant-list') ||
        checkPermission('accountant-create') ||
        checkPermission('accountant-edit') ||
        checkPermission('accountant-view') ||
        checkPermission('accountant-view')
      ">
            <template v-slot:icon>
                <icon-users />
            </template>
            <router-link :to="{ name: 'user' }" class="dropdown-item" :class="{
          active: checkRoute(['user', 'user-add', 'user-edit', 'user-view']),
        }" v-if="checkPermission('user-list')">
                {{ $t("admin") }}
            </router-link>
            <router-link :to="{ name: 'user-student' }" class="dropdown-item" :class="{
          active: checkRoute([
            'user-student',
            'user-student-add',
            'user-student-edit',
            'user-student-view',
          ]),
        }" v-if="checkPermission('student-list')">
                {{ $t("student") }}
            </router-link>
            <router-link :to="{ name: 'user-guardian' }" class="dropdown-item" :class="{
          active: checkRoute([
            'user-guardian',
            'user-guardian-add',
            'user-guardian-edit',
            'user-guardian-view',
          ]),
        }" v-if="checkPermission('parent-list')">
                {{ $t("parent") }}
            </router-link>
            <router-link :to="{ name: 'user-teacher' }" class="dropdown-item" :class="{
          active: checkRoute([
            'user-teacher',
            'user-teacher-add',
            'user-teacher-edit',
            'user-teacher-view',
          ]),
        }" v-if="checkPermission('teacher-list')">
                {{ $t("teacher") }}
            </router-link>
            <router-link :to="{ name: 'user-accountant' }" class="dropdown-item" :class="{
          active: checkRoute([
            'user-accountant',
            'user-accountant-add',
            'user-accountant-edit',
            'user-accountant-view',
          ]),
        }" v-if="checkPermission('accountant-list')">
                {{ $t("accountant") }}
            </router-link>
        </dropdown>

        <dropdown :title="$t('exam')" :active="
        checkRoute([
          'exam',
          'exam-schedule',
          'exam-schedule-create',
          'exam-schedule-edit',
          'exam-mark',
          'exam-result-rule',
          'exam-result',
          'promotion',
        ])
      " v-if="
        checkPermission('exam-list') ||
        checkPermission('exam-schedule-list') ||
        checkPermission('exam-mark-list') ||
        checkPermission('exam-rule-list') ||
        checkPermission('exam-result-list') ||
        checkPermission('promotion-list')
      ">
            <template v-slot:icon>
                <icon-edit-circle />
            </template>
            <router-link :to="{ name: 'exam' }" class="dropdown-item" :class="{ active: checkRoute(['exam']) }"
                v-if="checkPermission('exam-list')">
                {{ $t("exam_list") }}
            </router-link>
            <router-link :to="{ name: 'exam-schedule' }" class="dropdown-item" :class="{
          active: checkRoute([
            'exam-schedule',
            'exam-schedule-create',
            'exam-schedule-edit',
          ]),
        }" v-if="checkPermission('exam-schedule-list')">
                {{ $t("schedule") }}
            </router-link>
            <router-link :to="{ name: 'exam-mark' }" class="dropdown-item" :class="{ active: checkRoute('exam-mark') }"
                v-if="checkPermission('exam-mark-list')">
                {{ $t("mark") }}
            </router-link>
            <router-link :to="{ name: 'exam-result-rule' }" class="dropdown-item"
                :class="{ active: checkRoute('exam-result-rule') }" v-if="checkPermission('exam-rule-list')">
                {{ $t("result_rule") }}
            </router-link>
            <router-link :to="{ name: 'exam-result' }" class="dropdown-item"
                :class="{ active: checkRoute('exam-result') }" v-if="checkPermission('exam-result-list')">
                {{ $t("exam_result") }}
            </router-link>
            <router-link :to="{ name: 'promotion' }" class="dropdown-item" :class="{ active: checkRoute('promotion') }"
                v-if="checkPermission('promotion-list')">
                {{ $t("promotion") }}
            </router-link>
        </dropdown>

        <dropdown :title="$t('report')" :active="
        checkRoute([
          'report-student',
          'report-class-routine',
          'report-staff',
          'report-student-attendance',
          'report-teacher-attendance',
          'report-exam-routine',
          'report-teacher',
        ])
      " v-if="
        checkPermission('student-report') ||
        checkPermission('teacher-report') ||
        checkPermission('staff-report') ||
        checkPermission('class-routine-report') ||
        checkPermission('student-attendance-report') ||
        checkPermission('teacher-attendance-report') ||
        checkPermission('exam-schedule-report')
      ">
            <template v-slot:icon>
                <icon-report />
            </template>
            <router-link :to="{ name: 'report-student' }" :class="{ active: checkRoute('report-student') }"
                class="dropdown-item" v-if="checkPermission('student-report')">
                {{ $t("student") }}
            </router-link>
            <router-link :class="{ active: checkRoute('report-teacher') }" :to="{ name: 'report-teacher' }"
                class="dropdown-item" v-if="checkPermission('teacher-report')">
                {{ $t("teacher") }}
            </router-link>
            <router-link :class="{ active: checkRoute('report-staff') }" :to="{ name: 'report-staff' }"
                class="dropdown-item" v-if="checkPermission('staff-report')">
                {{ $t("staff") }}
            </router-link>
            <router-link :class="{ active: checkRoute('report-class-routine') }" :to="{ name: 'report-class-routine' }"
                class="dropdown-item" v-if="checkPermission('class-routine-report')">
                {{ $t("class_routine") }}
            </router-link>
            <router-link :class="{ active: checkRoute('report-exam-routine') }" :to="{ name: 'report-exam-routine' }"
                class="dropdown-item" v-if="checkPermission('exam-schedule-report')">
                {{ $t("exam_routine") }}
            </router-link>
            <router-link :class="{ active: checkRoute('report-student-attendance') }"
                :to="{ name: 'report-student-attendance' }" class="dropdown-item"
                v-if="checkPermission('student-attendance-report')">
                {{ $t("student_attendance") }}
            </router-link>
            <router-link :class="{ active: checkRoute('report-teacher-attendance') }"
                :to="{ name: 'report-teacher-attendance' }" class="dropdown-item"
                v-if="checkPermission('teacher-attendance-report')">
                {{ $t("teacher_attendance") }}
            </router-link>
        </dropdown>

        <dropdown :title="$t('announcement')" :active="checkRoute(['message', 'calendar'])" v-if="
        checkPermission('calendar-list') ||
        checkPermission('message-notification-send')
      ">
            <template v-slot:icon>
                <icon-bell />
            </template>
            <router-link :to="{ name: 'message' }" class="dropdown-item" :class="{ active: checkRoute('message') }"
                v-if="checkPermission('message-notification-send')">
                {{ $t("message") }}
            </router-link>
            <router-link :to="{ name: 'calendar' }" :class="{ active: checkRoute('calendar') }" class="dropdown-item"
                v-if="checkPermission('calendar-list')">
                {{ $t("calendar") }}
            </router-link>
        </dropdown>

        <dropdown :title="$t('accounting')" :active="
        checkRoute([
          'fees-type',
          'fees-list',
          'fees-allocation',
          'expense-type',
          'expense-expense-list',
        ])
      " v-if="
        checkPermission('fee-type-list') ||
        checkPermission('fee-list') ||
        checkPermission('expense-type-list') ||
        checkPermission('expense-list')
      ">
            <template v-slot:icon>
                <icon-calculator />
            </template>
            <router-link :to="{ name: 'fees-type' }" class="dropdown-item" :class="{ active: checkRoute('fees-type') }"
                v-if="checkPermission('fee-type-list')">
                {{ $t("fee_type") }}
            </router-link>
            <router-link :to="{ name: 'fees-list' }" class="dropdown-item"
                :class="{ active: checkRoute(['fees-list', 'fees-allocation']) }" v-if="checkPermission('fee-list')">
                {{ $t("fees") }}
            </router-link>
            <router-link :to="{ name: 'expense-type' }" class="dropdown-item"
                :class="{ active: checkRoute('expense-type') }" v-if="checkPermission('expense-type-list')">
                {{ $t("expense_type") }}
            </router-link>
            <router-link :to="{ name: 'expense-expense-list' }" class="dropdown-item"
                :class="{ active: checkRoute('expense-expense-list') }" v-if="checkPermission('expense-list')">
                {{ $t("expense_list") }}
            </router-link>
        </dropdown>

        <li class="nav-item" setting-list>
            <router-link v-if="checkPermission('role-list')" class="nav-link" :to="{ name: 'role' }"
                :class="{ active: checkRoute('role') }">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <icon-lock />
                </span>
                <span class="nav-link-title">
                    {{ $t("roles") }}
                </span>
            </router-link>
        </li>

        <li class="nav-item">
            <router-link v-if="checkPermission('setting-list')" class="nav-link" :to="{ name: 'setting-admin' }" :class="{
          active: checkRoute([
            'setting-admin',
            'setting-admin-theme',
            'setting-admin-mail',
            'setting-admin-payment',
            'setting-admin-language',
            'setting-language-add',
            'setting-language-edit',
          ]),
        }">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <icon-cog />
                </span>
                <span class="nav-link-title"> {{ $t("settings") }} </span>
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

        <li class="text-center mt-3" v-if="user.original_role === 'Teacher'">
            <router-link :to="{ name: 'attendence-student' }" class="btn btn-primary">
                {{ $t("take_attendance") }}
            </router-link>
        </li>

        <li class="text-center mt-3" v-if="user.original_role === 'Accountant'">
            <router-link :to="{ name: 'fees-allocation' }" class="btn btn-primary btn-outline">
                {{ $t("fee_allocation") }}
            </router-link>
        </li>
        <li class="text-center mt-3">
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
