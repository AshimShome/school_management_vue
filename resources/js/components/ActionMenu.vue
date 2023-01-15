<template>
    <div class="dots dropdown" v-on-clickaway="hideActionMenu">
        <a href="#" @click.prevent="show_action_menu = !show_action_menu" class="link-secondary"
            data-bs-toggle="dropdown" aria-expanded="false">
            <!-- Download SVG icon from http://tabler-icons.io/i/dots -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="28" height="28" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <circle cx="5" cy="12" r="1"></circle>
                <circle cx="12" cy="12" r="1"></circle>
                <circle cx="19" cy="12" r="1"></circle>
            </svg>
        </a>
        <div class="dropdown-menu dropdown-menu-start " :class="{ show: show_action_menu }">
            <a class="dropdown-item" href="" @click.prevent="editItem"> {{ $t("edit") }} </a>
            <a class="dropdown-item" href="" @click.prevent="deleteItem"> {{ $t("delete") }} </a>
        </div>
        <DeleteModal :isShow="isDeleteModalShow" @close-modal="toggleDeleteModal" @delete-data="deleteData" />
    </div>
</template>

<script>
    import {
        mixin as clickaway
    } from 'vue-clickaway';
    import DeleteModal from './modal/DeleteModal.vue';
    export default {
        mixins: [clickaway],
        components: {
            DeleteModal
        },
        data() {
            return {
                show_action_menu: false,
                isDeleteModalShow: false,
            }
        },
        methods: {
            hideActionMenu() {
                this.show_action_menu = false;
            },
            editItem() {
                this.$emit('edit-item');
            },
            deleteItem() {
                this.isDeleteModalShow = true;
            },
            deleteData() {
                this.isDeleteModalShow = false;
                this.$emit('delete-item');
            },
            toggleDeleteModal() {
                this.isDeleteModalShow = false;
                this.show_action_menu = false;
            }
        }
    };
</script>

<style lang="scss" scoped>
    .dropdown-menu {
        right: 0;
    }
</style>
