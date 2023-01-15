<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $t('event_calendar') }}</h3>
                </div>
                <div class="card-body">
                    <div class="col-12">
                        <Fullcalendar :plugins="calendarPlugins" :events="events" :header="{
            right: 'prev today next'
        }" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Fullcalendar from "@fullcalendar/vue";
    import dayGridPlugin from "@fullcalendar/daygrid";
    import timeGridPlugin from "@fullcalendar/timegrid";
    import listPlugin from "@fullcalendar/list";
    import interactionPlugin from "@fullcalendar/interaction";

    export default {
        components: {
            Fullcalendar,
        },
        data() {
            return {
                calendarPlugins: [
                    dayGridPlugin,
                    interactionPlugin,
                    timeGridPlugin,
                    listPlugin
                ],
            }
        },
        methods: {
            async loadData() {
                await this.$store.dispatch("calendar/fetchEvents")
            }
        },
        computed: {
            events() {
                return this.$store.getters['calendar/events'];
            }
        },
        created() {
            this.loadData();
        }
    }
</script>

<style lang="css">
    @import "~@fullcalendar/core/main.css";
    @import "~@fullcalendar/daygrid/main.css";
</style>
