<template>
    <transition name="fade">
        <div v-if="isShow" class="modal modal-blur fade show modal-hidee"
            id="modal-danger" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content" v-on-clickaway="closeModal">
                    <button @click="closeModal" type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                    <div class="modal-status bg-danger"></div>
                    <div class="modal-body text-center py-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 9v2m0 4v.01" />
                            <path
                                d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" />
                            </svg>
                        <h3>{{ $t('are_you_sure') }}</h3>
                        <div class="text-muted">{{ $t('delete_message') }}</div>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100">
                            <div class="row">
                                <div class="col">
                                    <button @click="closeModal" class="btn btn-white w-100" data-bs-dismiss="modal">
                                        {{ $t('cancel') }}
                                    </button>
                                </div>
                                <div class="col">
                                    <button @click="deleteData" class="btn btn-danger w-100" data-bs-dismiss="modal">
                                        {{ $t('delete') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    import {
        mixin as clickaway
    } from 'vue-clickaway';

    export default {
        mixins: [clickaway],
        props: {
            isShow: {
                type: Boolean,
                default: false,
                required: false
            }
        },
        methods: {
            closeModal() {
                this.$emit('close-modal')
            },
            deleteData() {
                this.$emit('delete-data')
            }
        }
    }
</script>

<style>
    .fade-enter-active,
    .fade-leave-active {
        transition: opacity .3s
    }

    .fade-enter,
    .fade-leave-active {
        opacity: 0
    }
</style>
