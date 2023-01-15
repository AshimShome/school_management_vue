<template>
    <router-link :to="{ name: routeName }" class="btn btn-primary">
        {{ $t("back") }}
    </router-link>
</template>

<script>
    export default {
        props: {
            routeName: {
                type: String,
                required: true,
            },
        },
    };
</script>
