<template>
    <a :class="linkClass" href="javascript:void(0)" @click.prevent="logout">
        <slot />
        <span v-if="title">{{ $t('logout') }}</span>
    </a>
</template>

<script>
import { mapActions } from 'vuex'
export default {
    props: {
        title: {
            type: Boolean,
            required: false,
            default: true,
        },
        linkClass: {
            type: String,
            required: false,
            default: '',
        }
    },
    methods: {
        ...mapActions({
            logoutAction: 'auth/logout'
        }),
        logout () {
            this.logoutAction()
        },
    }
}
</script>

<style>

</style>
