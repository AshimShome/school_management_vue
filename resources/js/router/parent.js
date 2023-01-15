import Home from '../pages/Home'


const routes = [{
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            title: 'Home'
        }
    },
    {
        path: 'routine',
        name: 'parent-student-class-routine',
        component: () => import('../pages/parent/classRoutine.vue'),
        meta: {
            title: 'Class Routine'
        }
    },
    {
        path: 'attendance',
        name: 'parent-student-attendance',
        component: () => import('../pages/parent/attendance.vue'),
        meta: {
            title: 'Attendance'
        }
    },
    {
        path: 'subjects',
        name: 'parent-subjects',
        component: () => import('../pages/parent/subjects.vue'),
        meta: {
            title: 'Subjects'
        }
    },
    {
        path: 'Fees',
        name: 'parent-student-fees',
        component: () => import('../pages/parent/fees.vue'),
        meta: {
            title: 'Fees'
        }
    },
    {
        path: 'exam-routine',
        name: 'parent-student-exam-routine',
        component: () => import('../pages/parent/examRoutine.vue'),
        meta: {
            title: 'Attendance'
        }
    },
    {
        path: 'exam-results',
        name: 'parent-student-exam-results',
        component: () => import('../pages/parent/results.vue'),
        meta: {
            title: 'Exam Results'
        }
    },
    {
        path: 'syllabus',
        name: 'parent-student-syllabus',
        component: () => import('../pages/parent/syllabus.vue'),
        meta: {
            title: 'Syllabus'
        }
    },
    {
        path: 'homework',
        name: 'parent-student-homework',
        component: () => import('../pages/parent/homework.vue'),
        meta: {
            title: 'Homework'
        }
    },
]

export default routes;
