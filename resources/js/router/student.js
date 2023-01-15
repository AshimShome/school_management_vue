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
        name: 'student-class-routine',
        component: () => import('../pages/student/classRoutine.vue'),
        meta: {
            title: 'Class Routine'
        }
    },

    {
        path: 'attendance',
        name: 'student-attendance',
        component: () => import('../pages/student/attendance.vue'),
        meta: {
            title: 'Attendance'
        }
    },
    {
        path: 'exam-routine',
        name: 'student-exam-routine',
        component: () => import('../pages/student/examRoutine.vue'),
        meta: {
            title: 'Exam Routine'
        }
    },
    {
        path: 'exam-results',
        name: 'student-exam-results',
        component: () => import('../pages/student/results.vue'),
        meta: {
            title: 'Exam Results'
        }
    },
    {
        path: 'syllabus',
        name: 'student-syllabus',
        component: () => import('../pages/student/syllabus.vue'),
        meta: {
            title: 'Syllabus'
        }
    },
    {
        path: 'homework',
        name: 'student-homework',
        component: () => import('../pages/student/homework.vue'),
        meta: {
            title: 'Homework'
        }
    },
    {
        path: 'subjects',
        name: 'student-subjects',
        component: () => import('../pages/student/subjects.vue'),
        meta: {
            title: 'Subjects'
        }
    },
    {
        path: 'teachers',
        name: 'student-teachers',
        component: () => import('../pages/student/teachers.vue'),
        meta: {
            title: 'Teachers'
        }
    }
]

export default routes;
