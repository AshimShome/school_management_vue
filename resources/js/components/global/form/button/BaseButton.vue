<template>
    <button :disabled="isDisabled" :type="nativeType" class="btn" :class="[
        {'btn-block': block},
        `btn-${type}`,
        `btn-${size}`,
        classes
    ]">
        <span>
            <icon-loading v-if="loading" />
            <icon-check v-else />
        </span>
        <slot />
    </button>
</template>

<script>
    export default {
        name: 'base-button',
        props: {
            type: {
                type: String,
                default: 'primary'
            },
            classes: {
                type: String,
                default: '',
            },
            nativeType: {
                type: String,
                default: 'submit'
            },
            loading: {
                type: Boolean,
                default: false
            },
            block: {
                type: Boolean,
                default: false
            },
            size: {
                type: String,
                default: 'md'
            },
            disabled: {
                type: Boolean,
                default: false
            }
        },
        computed: {
            isDisabled() {
                return this.disabled || this.loading;
            }
        }
    };
</script>

<style></style>
