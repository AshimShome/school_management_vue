<template>
    <div>
        <!-- Overview  -->
        <Overview />

        <div class="row mt-3">
            <!-- My Kids Card -->
            <KidsInfo />

            <!-- Attendance Chart -->
            <div class="col-md-6 col-lg-6 col-xl-4">
                <AttendanceChart/>
            </div>

            <div class="col-md-12 col-lg-12 col-xl-4 mt-3 mt-lg-0">
                <!-- Due Fees -->
                <DueFeesCard />

                <!-- Upcoming Exams -->
                <!-- <UpcomingExam /> -->
            </div>
        </div>

        <!-- Class Routine -->
        <AttendanceRoutine />

        <!-- Calendar Event -->
        <CalendarEvent />
    </div>
</template>

<script>
    import Overview from '../../components/parent/dashboard/Overview.vue'
    import KidsInfo from '../../components/parent/dashboard/KidsInfo.vue'
    import AttendanceChart from '../../components/parent/dashboard/AttendanceChart.vue'
    import AttendanceRoutine from '../../components/parent/dashboard/ClassRoutine.vue'
    import CalendarEvent from "../../components/event/CalendarEvent.vue";
    import UpcomingExam from "../../components/exam/UpcomingExam.vue";
    import DueFeesCard from "../../components/parent/dashboard/DueFeesCard.vue";

    export default {
        components: {
            Overview,
            KidsInfo,
            AttendanceRoutine,
            CalendarEvent,
            AttendanceChart,
            UpcomingExam,
            DueFeesCard
        }
    };
</script>

<style scoped>
    p {
        margin-bottom: 0.5rem;
    }

    .header {
        position: sticky;
        top: 0;
    }

    hr {
        margin: 0 0 16px 0;
    }

    h3 {
        margin-bottom: 0;
    }

    .header-hr {
        margin: 0;
    }
</style>
