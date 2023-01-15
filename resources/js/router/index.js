import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import Home from '../pages/Home'
import Login from '../pages/auth/Login'
import Register from '../pages/auth/Register'
import Email from '../pages/auth/Email'
import Reset from '../pages/auth/Reset'

// Layout File
import AuthLayout from '../layouts/AuthLayout.vue'

import StudentRoutes from './student'
import parentRoutes from './parent'

const router = new VueRouter({
    mode: 'history',
    linkActiveClass: "active-link",
    linkExactActiveClass: "nav-active",
    routes: [{
            path: '/',
            redirect: {
                name: 'home'
            }
        },
        {
            path: '/sms',
            component: () => import('../layouts/AdminLayout.vue'),
            meta: {
                requiresAuth: true
            },
            children: [
                // dashboard routes
                {
                    path: '/',
                    name: 'home',
                    component: Home,
                    meta: {
                        title: 'Home'
                    }
                },

                // profile page
                {
                    path: 'profile',
                    name: 'user-profile',
                    component: () => import('../pages/admin/user/profile.vue'),
                    meta: {
                        title: 'Profile'
                    }
                },

                // user pages
                {
                    path: 'user',
                    name: 'user',
                    component: () => import('../pages/admin/user/index.vue'),
                    meta: {
                        title: 'User List'
                    }
                },
                {
                    path: 'add/user',
                    name: 'user-add',
                    component: () => import('../pages/admin/user/add.vue'),
                    meta: {
                        title: 'Create User'
                    }
                },
                {
                    path: 'edit/:userId/user',
                    name: 'user-edit',
                    component: () => import('../pages/admin/user/edit.vue'),
                    meta: {
                        title: 'Edit User'
                    }
                },
                {
                    path: 'user/:id/view',
                    name: 'user-view',
                    component: () => import('../pages/admin/user/view.vue'),
                    meta: {
                        title: 'Admin Details'
                    }
                },
                {
                    path: 'student',
                    name: 'user-student',
                    component: () => import('../pages/admin/user/student/index.vue'),
                    meta: {
                        title: 'Student List'
                    }
                },
                {
                    path: 'student/add',
                    name: 'user-student-add',
                    component: () => import('../pages/admin/user/student/add.vue'),
                    meta: {
                        title: 'Student Create'
                    }
                },
                {
                    path: 'student/:id/edit',
                    name: 'user-student-edit',
                    component: () => import('../pages/admin/user/student/edit.vue'),
                    meta: {
                        title: 'Student Edit'
                    }
                },
                {
                    path: 'student/:id/view',
                    name: 'user-student-view',
                    component: () => import('../pages/admin/user/student/view.vue'),
                    meta: {
                        title: 'Student Details'
                    }
                },
                {
                    path: 'guardian',
                    name: 'user-guardian',
                    component: () => import('../pages/admin/user/guardian/index.vue'),
                    meta: {
                        title: 'Parent List'
                    }
                },
                {
                    path: 'guardian/add',
                    name: 'user-guardian-add',
                    component: () => import('../pages/admin/user/guardian/add.vue'),
                    meta: {
                        title: 'Parent Create'
                    }
                },
                {
                    path: 'guardian/:id/edit',
                    name: 'user-guardian-edit',
                    component: () => import('../pages/admin/user/guardian/edit.vue'),
                    meta: {
                        title: 'Parent Edit'
                    }
                },
                {
                    path: 'guardian/:id/view',
                    name: 'user-guardian-view',
                    component: () => import('../pages/admin/user/guardian/view.vue'),
                    meta: {
                        title: 'Parent Details'
                    }
                },

                {
                    path: 'accountant',
                    name: 'user-accountant',
                    component: () => import('../pages/admin/user/accountant/index.vue'),
                    meta: {
                        title: 'Accountant List'
                    }
                },
                {
                    path: 'accountant/add',
                    name: 'user-accountant-add',
                    component: () => import('../pages/admin/user/accountant/add.vue'),
                    meta: {
                        title: 'Accountant Create'
                    }
                },
                {
                    path: 'accountant/:id/edit',
                    name: 'user-accountant-edit',
                    component: () => import('../pages/admin/user/accountant/edit.vue'),
                    meta: {
                        title: 'Accountant Edit'
                    }
                },
                {
                    path: 'accountant/:id/view',
                    name: 'user-accountant-view',
                    component: () => import('../pages/admin/user/accountant/view.vue'),
                    meta: {
                        title: 'Accountant Details'
                    }
                },
                {
                    path: 'teacher',
                    name: 'user-teacher',
                    component: () => import('../pages/admin/user/teacher/index.vue'),
                    meta: {
                        title: 'Teacher List'
                    }
                },
                {
                    path: 'teacher/add',
                    name: 'user-teacher-add',
                    component: () => import('../pages/admin/user/teacher/add.vue'),
                    meta: {
                        title: 'Teacher Create'
                    }
                },
                {
                    path: 'teacher/:id/edit',
                    name: 'user-teacher-edit',
                    component: () => import('../pages/admin/user/teacher/edit.vue'),
                    meta: {
                        title: 'Teacher Edit'
                    }
                },
                {
                    path: 'teacher/:id/view',
                    name: 'user-teacher-view',
                    component: () => import('../pages/admin/user/teacher/view.vue'),
                    meta: {
                        title: 'Teacher Details'
                    }
                },
                {
                    path: 'exam',
                    name: 'exam',
                    component: () => import('../pages/admin/exam/index.vue'),
                    meta: {
                        title: 'Exams List'
                    }
                },
                {
                    path: 'exam/schedule',
                    name: 'exam-schedule',
                    component: () => import('../pages/admin/exam/schedule/index.vue'),
                    meta: {
                        title: 'Exam Schedule List'
                    }
                },
                {
                    path: 'exam/schedule/create',
                    name: 'exam-schedule-create',
                    component: () => import('../pages/admin/exam/schedule/create.vue'),
                    meta: {
                        title: 'Exam Schedule Create'
                    }
                },
                {
                    path: 'exam/schedule/:id/edit',
                    name: 'exam-schedule-edit',
                    component: () => import('../pages/admin/exam/schedule/edit.vue'),
                    meta: {
                        title: 'Exam Schedule Edit'
                    }
                },
                {
                    path: 'exam/mark',
                    name: 'exam-mark',
                    component: () => import('../pages/admin/exam/mark'),
                    meta: {
                        title: 'Exam Marks'
                    }
                },
                {
                    path: 'exam/result-rule',
                    name: 'exam-result-rule',
                    component: () => import('../pages/admin/exam/resultRule.vue'),
                    meta: {
                        title: 'Exam Result Rule'
                    }
                },
                {
                    path: 'promotion',
                    name: 'promotion',
                    component: () => import('../pages/admin/exam/promotion.vue'),
                    meta: {
                        title: 'Promotion'
                    }
                },
                {
                    path: 'report/student',
                    name: 'report-student',
                    component: () => import('../pages/admin/report/student.vue'),
                    meta: {
                        title: 'Student Report'
                    }
                },
                {
                    path: 'report/class',
                    name: 'report-class',
                    component: () => import('../pages/admin/report/classs.vue'),
                    meta: {
                        title: 'Class Report'
                    }
                },
                {
                    path: 'report/class-routine',
                    name: 'report-class-routine',
                    component: () => import('../pages/admin/report/classRoutine.vue'),
                    meta: {
                        title: 'Class Routine'
                    }
                },
                {
                    path: 'report/teacher',
                    name: 'report-teacher',
                    component: () => import('../pages/admin/report/teacher.vue'),
                    meta: {
                        title: 'Teacher Report'
                    }
                },
                {
                    path: 'report/staff',
                    name: 'report-staff',
                    component: () => import('../pages/admin/report/staff.vue'),
                    meta: {
                        title: 'Staff Report'
                    }
                },
                {
                    path: 'report/student-atttendance',
                    name: 'report-student-attendance',
                    component: () => import('../pages/admin/report/studentAttendance.vue'),
                    meta: {
                        title: 'Student Attendance'
                    }
                },
                {
                    path: 'report/teacher-atttendance',
                    name: 'report-teacher-attendance',
                    component: () => import('../pages/admin/report/teacherAttendance.vue'),
                    meta: {
                        title: 'Teacher Attendance'
                    }
                },
                {
                    path: 'report/exam-routine',
                    name: 'report-exam-routine',
                    component: () => import('../pages/admin/report/examRoutine.vue'),
                    meta: {
                        title: 'Exam Routine'
                    }
                },
                {
                    path: 'exam-result',
                    name: 'exam-result',
                    component: () => import('../pages/admin/exam/examResult.vue'),
                    meta: {
                        title: 'Exam Result'
                    }
                },

                {
                    path: 'message',
                    name: 'message',
                    component: () => import('../pages/admin/message/index'),
                    meta: {
                        title: 'Message Notification'
                    }
                },
                {
                    path: 'notifications',
                    name: 'notifications',
                    component: () => import('../pages/notification/list.vue'),
                    meta: {
                        title: 'Notification Details'
                    }
                },
                {
                    path: 'notification/:id/details',
                    name: 'notification-details',
                    component: () => import('../pages/notification/details.vue'),
                    meta: {
                        title: 'Notification Details'
                    }
                },


                // role pages
                {
                    path: 'role',
                    name: 'role',
                    component: () => import('../pages/admin/role/index.vue'),
                    meta: {
                        title: 'Role List'
                    }
                },
                {
                    path: 'add/role',
                    name: 'role-add',
                    component: () => import('../pages/admin/role/add.vue'),
                    meta: {
                        title: 'Create Role'
                    }
                },
                {
                    path: 'edit/:roleId/role',
                    name: 'role-edit',
                    component: () => import('../pages/admin/role/edit.vue'),
                    meta: {
                        title: 'Edit Role'
                    }
                },

                // attendence
                {
                    path: 'attendence/student',
                    name: 'attendence-student',
                    component: () => import('../pages/admin/attendence/student.vue'),
                    meta: {
                        title: 'Student Attendence'
                    }
                },
                {
                    path: 'attendence/teacher',
                    name: 'attendence-teacher',
                    component: () => import('../pages/admin/attendence/teacher.vue'),
                    meta: {
                        title: 'Teacher Attendence'
                    }
                },


                {
                    path: 'academic/session',
                    name: 'academic-session',
                    component: () => import('../pages/admin/academic/session.vue'),
                    meta: {
                        title: 'Session'
                    }
                },

                {
                    path: 'department',
                    name: 'department',
                    component: () => import('../pages/admin/academic/department.vue'),
                    meta: {
                        title: 'Department'
                    }
                },

                {
                    path: 'academic/homework',
                    name: 'academic-homework',
                    component: () => import('../pages/admin/academic/homework/index.vue'),
                    meta: {
                        title: 'Homework'
                    }
                },
                {
                    path: 'academic/homework/create',
                    name: 'academic-homework-create',
                    component: () => import('../pages/admin/academic/homework/create.vue'),
                    meta: {
                        title: 'Homework Create'
                    }
                },
                {
                    path: 'academic/homework/:id/edit',
                    name: 'academic-homework-edit',
                    component: () => import('../pages/admin/academic/homework/edit.vue'),
                    meta: {
                        title: 'Homework Edit'
                    }
                },

                {
                    path: 'academic/routine',
                    name: 'academic-routine',
                    component: () => import('../pages/admin/academic/routine/index.vue'),
                    meta: {
                        title: 'Routine'
                    }
                },
                {
                    path: 'academic/routine/create',
                    name: 'academic-routine-create',
                    component: () => import('../pages/admin/academic/routine/create.vue'),
                    meta: {
                        title: 'Routine Create'
                    }
                },
                {
                    path: 'academic/:id/routine',
                    name: 'academic-routine-edit',
                    component: () => import('../pages/admin/academic/routine/edit.vue'),
                    meta: {
                        title: 'Routine Edit'
                    }
                },
                {
                    path: 'academic/class',
                    name: 'academic-class',
                    component: () => import('../pages/admin/academic/class.vue'),
                    meta: {
                        title: 'Class'
                    }
                },
                {
                    path: 'academic/section',
                    name: 'academic-section',
                    component: () => import('../pages/admin/academic/section.vue'),
                    meta: {
                        title: 'Section'
                    }
                },
                {
                    path: 'academic/subject',
                    name: 'academic-subject',
                    component: () => import('../pages/admin/academic/subject.vue'),
                    meta: {
                        title: 'Subject'
                    }
                },
                {
                    path: 'academic/classroom',
                    name: 'academic-classroom',
                    component: () => import('../pages/admin/academic/classroom.vue'),
                    meta: {
                        title: 'Class Room'
                    }
                },
                {
                    path: 'academic/syllabus',
                    name: 'academic-syllabus-index',
                    component: () => import('../pages/admin/academic/syllabus/index.vue'),
                    meta: {
                        title: 'Syllabus List'
                    }
                },
                {
                    path: 'academic/syllabus/create',
                    name: 'academic-syllabus-create',
                    component: () => import('../pages/admin/academic/syllabus/create.vue'),
                    meta: {
                        title: 'Syllabus Create'
                    }
                },
                {
                    path: 'events',
                    name: 'event-calendar',
                    component: () => import('../pages/events.vue'),
                    meta: {
                        title: 'Events'
                    }
                },
                {
                    path: 'calendar',
                    name: 'calendar',
                    component: () => import('../pages/admin/calendar/index.vue'),
                    meta: {
                        title: 'Calendar'
                    }
                },

                // expense
                {
                    path: 'expense/type',
                    name: 'expense-type',
                    component: () => import('../pages/admin/expense/expensetype.vue'),
                    meta: {
                        title: 'Expense Type'
                    }
                },
                {
                    path: 'expense',
                    name: 'expense-expense-list',
                    component: () => import('../pages/admin/expense/expense-list.vue'),
                    meta: {
                        title: 'Expense List'
                    }
                },

                // Fees Management
                {
                    path: 'fees/type',
                    name: 'fees-type',
                    component: () => import('../pages/admin/fees/feestype.vue'),
                    meta: {
                        title: 'Fees Type'
                    }
                },
                {
                    path: 'fees',
                    name: 'fees-list',
                    component: () => import('../pages/admin/fees/list.vue'),
                    meta: {
                        title: 'Fees List'
                    }
                },
                {
                    path: 'fees/allocation',
                    name: 'fees-allocation',
                    component: () => import('../pages/admin/fees/allocation.vue'),
                    meta: {
                        title: 'Fees Allocation'
                    }
                },
                {
                    path: 'fees/allocation/:id/edit',
                    name: 'fees-allocation-edit',
                    component: () => import('../pages/admin/fees/edit.vue'),
                    meta: {
                        title: 'Fees Allocation Edit'
                    }
                },

                // setting
                {
                    path: "admin/setting/",
                    component: () => import("../pages/admin/setting/adminLayout.vue"),
                    meta: {
                        title: "Admin Setting"
                    },
                    children: [{
                            path: "/",
                            name: "setting-admin",
                            component: () => import("../pages/admin/setting/admin/index.vue"),
                            meta: {
                                title: "Admin Setting"
                            },
                        },
                        {
                            path: "system",
                            name: "setting-admin-system",
                            component: () => import("../pages/admin/setting/admin/system.vue"),
                            meta: {
                                title: "System Setting"
                            },
                        },
                        {
                            path: "theme",
                            name: "setting-admin-theme",
                            component: () => import("../pages/admin/setting/admin/theme.vue"),
                            meta: {
                                title: "Theme Setting"
                            },
                        },
                        {
                            path: "mail",
                            name: "setting-admin-mail",
                            component: () => import("../pages/admin/setting/admin/mail.vue"),
                            meta: {
                                title: "Mail Setting"
                            },
                        },
                        {
                            path: "payment",
                            name: "setting-admin-payment",
                            component: () => import("../pages/admin/setting/admin/payment.vue"),
                            meta: {
                                title: "Payment Setting"
                            },
                        },
                        // language
                        {
                            path: "language",
                            name: "setting-admin-language",
                            component: () => import("../pages/admin/setting/admin/language/index.vue"),
                            meta: {
                                title: "Language Setting"
                            }
                        },
                        // language add
                        {
                            path: "language/add",
                            name: "setting-language-add",
                            component: () => import("../pages/admin/setting/admin/language/add.vue"),
                            meta: {
                                title: "Add Language"
                            }
                        },
                        // language edit
                        {
                            path: "language/edit/:slug",
                            name: "setting-language-edit",
                            component: () => import("../pages/admin/setting/admin/language/edit.vue"),
                            meta: {
                                title: "Edit Language"
                            }
                        },
                    ]
                },
                {
                    path: "website/setting/",
                    component: () => import("../pages/admin/setting/websiteLayout.vue"),
                    meta: {
                        title: "Website Setting"
                    },
                    children: [
                        {
                            path: "home",
                            name: "setting-website-home",
                            component: () => import("../pages/admin/setting/website/home.vue"),
                            meta: {
                                title: "Home Setting"
                            },
                        },
                    ]
                }
            ]
        },
        {
            path: '/student',
            component: () => import('../layouts/AdminLayout.vue'),
            meta: {
                requiresAuth: true
            },
            children: StudentRoutes
        },
        {
            path: '/parent',
            component: () => import('../layouts/AdminLayout.vue'),
            meta: {
                requiresAuth: true
            },
            children: parentRoutes
        },
        {
            path: '/auth',
            component: AuthLayout,
            meta: {
                requiresVisitor: true
            },
            children: [{
                    path: 'login',
                    name: 'login',
                    component: Login,
                    meta: {
                        title: 'Login'
                    }
                },
                {
                    path: 'register',
                    name: 'register',
                    component: Register,
                    meta: {
                        title: 'Register'
                    }
                },
                {
                    path: "password/reset",
                    name: "password.request",
                    component: Email,
                    meta: {
                        title: "Password Request"
                    }
                },
                {
                    path: "password/reset/:token",
                    name: "password.reset",
                    component: Reset,
                    meta: {
                        title: "Password Reset"
                    }
                }
            ]
        },

        // Error Pages
        {
            path: '*',
            name: '404',
            component: () => import('../pages/errors/404.vue'),
            meta: {
                title: '404'
            }
        },
        {
            path: '*',
            name: '401',
            component: () => import('../pages/errors/401.vue'),
            meta: {
                title: '401'
            }
        },
    ],
});

export default router;
