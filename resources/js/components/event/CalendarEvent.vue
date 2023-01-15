<template>
    <div class="row mt-3">
        <div class="col-xl-9 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $t("event_calendar") }}</h3>
                </div>
                <div class="card-body card-body-scrollable">
                    <Fullcalendar
                        :plugins="calendarPlugins"
                        :events="events"
                        :header="{ right: 'prev today next' }"
                    />
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-12 col-md-12 mt-lg-3 mt-md-3 mt-lg-0 mt-xl-0">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $t("upcoming_events") }}</h3>
                </div>
                <div class="card-body card-body-scrollable">
                    <Loader v-if="loading" />
                    <template v-else>
                        <div
                            class="items"
                            v-if="upcomingevents && upcomingevents.length"
                        >
                            <div
                                v-for="(event, index) in upcomingevents"
                                :key="event.id"
                            >
                                <div
                                    class="item d-flex justify-content-between"
                                >
                                    <div class="item_left">
                                        <h3 class="text-primary">
                                            {{ event.title }}
                                        </h3>
                                        <p class="text-lead">
                                            {{ event.start_date }} -
                                            {{ event.end_date }}
                                        </p>
                                    </div>
                                    <div class="item_right">
                                        <span class="badge bg-danger"
                                            >{{ event.days_left }}
                                            {{ $t("days_left") }}</span
                                        >
                                    </div>
                                </div>
                                <hr
                                    v-if="index + 1 != upcomingevents.length"
                                    class="my-1"
                                />
                            </div>
                        </div>
                        <div class="text-center my-5" v-else>
                            <h3>{{ $t("nothing_found") }}</h3>
                        </div>
                    </template>
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
        Fullcalendar
    },
    data() {
        return {
            calendarPlugins: [
                dayGridPlugin,
                interactionPlugin,
                timeGridPlugin,
                listPlugin
            ],

            upcomingevents: [],
            loading: false
        };
    },
    methods: {
        async loadData() {
            await this.$store.dispatch("calendar/fetchEvents");
            let response = await axios.get("/api/calendars/upcoming-events");
            this.upcomingevents = response.data.data;
        }
    },
    computed: {
        events() {
            return this.$store.getters["calendar/events"];
        }
    },
    async created() {
        this.loading = true;
        await this.loadData();
        this.loading = false;
    }
};
</script>

<style lang="css">
@import "~@fullcalendar/core/main.css";
@import "~@fullcalendar/daygrid/main.css";

@media (max-width: 425px) {
    .fc-left h2 {
        font-size: 17px;
    }
    .fc-button {
        font-size: 8px;
    }
}
</style>
