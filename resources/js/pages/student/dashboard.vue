<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $t('dashboard') }}</h2>
                </div>
            </div>
        </div>
        <!-- Dashboard Overview  -->
        <Overview />

        <div class="row">
            <!-- About Me  -->
            <AboutMe />

            <!-- Attendance Chart -->
            <AttendanceChart />

            <!-- Upcoming Exam -->
            <div class="col-md-12 col-xl-4 col-lg-12">
                <UpcomingExam />
            </div>
        </div>

        <!-- Class Routine -->
        <ClassRoutine />

        <!-- Calendar Event -->
        <CalendarEvent />
    </div>
</template>

<script>
    import Overview from "../../components/student/dashboard/Overview.vue";
    import AboutMe from "../../components/student/dashboard/AboutMe.vue";
    import AttendanceChart from "../../components/student/dashboard/AttendanceChart.vue";
    import CalendarEvent from "../../components/event/CalendarEvent.vue";
    import ClassRoutine from "../../components/student/dashboard/ClassRoutine.vue";
    import UpcomingExam from "../../components/exam/UpcomingExam.vue";

    export default {
        components: {
            Overview,
            AboutMe,
            AttendanceChart,
            CalendarEvent,
            ClassRoutine,
            UpcomingExam,
        }
    };
</script>
