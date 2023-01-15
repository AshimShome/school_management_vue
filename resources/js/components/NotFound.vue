<template>
    <div class="empty">
        <div class="empty-img">
            <img :src="notFound" height="128" alt="not found" />
        </div>
        <p class="empty-title">{{ $t("no_results_found") }}</p>
        <p class="empty-subtitle text-muted">
            {{ $t("there_is_no") }} {{ word }} {{ $t("found_in_this_page") }}.
        </p>
        <div class="empty-action" v-if="route && btnShow">
            <router-link :to="{ name: route }" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                {{ $t("add_your_first") }} {{ word }}
            </router-link>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                notFound: "/images/not-found.svg",
            };
        },
        props: {
            word: {
                type: String,
                default: "user",
                required: false,
            },
            route: {
                type: String,
                required: false,
            },
            btnShow: {
                type: Boolean,
                required: false,
                default: true,
            },
        },
    };
</script>
