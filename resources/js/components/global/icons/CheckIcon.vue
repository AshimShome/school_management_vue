<template>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        :width="width"
        :height="height"
        stroke-width="2"
        :stroke="stroke"
        viewBox="0 0 24 24"
        fill="none"
        stroke-linecap="round"
        stroke-linejoin="round"
        class="icon icon-tabler icon-tabler-check me-0"
    >
        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
        <path d="M5 12l5 5l10 -10"></path>
    </svg>
</template>

<script>
    export default {
        props:{
            stroke: {
                type: String,
                default: 'currentColor',
            },
            width: {
                type: Number,
                default: 24
            },
            height: {
                type: Number,
                default: 24
            },
        },
        mounted(){

        }
    }
</script>

<style lang="scss" scoped>

</style>
