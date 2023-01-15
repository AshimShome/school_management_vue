<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $t("upcoming_exams") }}</h3>
        </div>
        <div class="card-body pb">
            <Loader v-if="loading"/>
            <div class="items" v-else>
                <div v-for="(exam, index) in exams" :key="exam.id">
                    <div class="item d-flex justify-content-between">
                        <div class="item_left">
                            <h3 class="text-primary">{{ exam.name }}</h3>
                            <p class="text-lead">
                                {{ exam.start_date }} - {{ exam.end_date }}
                            </p>
                        </div>
                        <div class="item_right">
                            <span class="badge bg-danger">{{ exam.days_left }} {{ $t("days_left") }}</span>
                        </div>
                    </div>
                    <hr v-if="index + 1 != exams.length" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                loading: false
            };
        },
        async created() {
            this.loading = true;
            await this.$store.dispatch("exam/fetchUpcomingExams");
            this.loading = false;
        },
        computed: {
            exams() {
                return this.$store.getters["exam/upcomingExams"];
            }
        },
    };
</script>

<style scoped>
    hr {
        margin: 0 0 16px 0;
    }

    h3 {
        margin-bottom: 0;
    }

    .pb {
        padding-bottom: 40px;
    }
</style>
