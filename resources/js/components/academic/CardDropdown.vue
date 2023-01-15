<template>
    <div class="dots dropdown" v-on-clickaway="closeDropdown">
        <a @click="toggleDots" href="javascript:void(0)" class="link-secondary" data-bs-toggle="dropdown"
            aria-expanded="false">
            <!-- Download SVG icon from http://tabler-icons.io/i/dots -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="28" height="28" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <circle cx="5" cy="12" r="1"></circle>
                <circle cx="12" cy="12" r="1"></circle>
                <circle cx="19" cy="12" r="1"></circle>
            </svg>
        </a>
        <div class="dropdown-menu dropdown-menu-end right-100" :class="{ show: showDots }">
            <a class="dropdown-item" href="javascript:void(0)" @click="editData" v-if="canEdit">
                {{ $t("edit") }}
            </a>
            <a class="dropdown-item" href="javascript:void(0)" @click="deleteData" v-if="canDelete">
                {{ $t("delete") }}
            </a>
        </div>
    </div>
</template>

<script>
    import {
        mixin as clickaway
    } from "vue-clickaway";

    export default {
        mixins: [clickaway],
        props: {
            data: {
                type: Object,
                required: true,
            },
            canEdit: {
                type: Boolean,
                default: false,
            },
            canDelete: {
                type: Boolean,
                default: false,
            },
        },
        data() {
            return {
                showDots: false,
            };
        },
        methods: {
            toggleDots() {
                this.showDots = !this.showDots;
            },
            closeDropdown() {
                this.showDots = false;
            },
            editData() {
                this.$emit("edit-data", this.data);
            },
            deleteData() {
                this.$emit("delete-data", this.data.id);
            },
        },
    };
</script>

<style scoped>
    .dropdown-menu-end {
        right: 100%;
    }
    .user-card {
        position: relative;
    }

    .dots {
        position: absolute;
        top: 5px;
        right: 10px;
    }
</style>
