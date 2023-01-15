<template>
    <li class="nav-item dropdown" :class="sidebarDropdown || active ? 'active' : ''" v-on-clickaway="closeDropdown">
        <a @click.prevent="sidebarDropdown = !sidebarDropdown" :class="{'show': sidebarDropdown || active}"
            class="nav-link dropdown-toggle" href="javascript:void(0)" data-bs-toggle="dropdown" role="button"
            aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <slot name="icon" />
            </span>
            <span class="nav-link-title">
                {{ $t(title) }}
            </span>
        </a>
        <div :class="{ 'show': sidebarDropdown || active }" class="dropdown-menu">
            <div class="dropdown-menu-columns">
                <div class="dropdown-menu-column">
                    <slot />
                </div>
            </div>
        </div>
    </li>
</template>

<script>
    import {
        mixin as clickaway
    } from 'vue-clickaway';

    export default {
        mixins: [clickaway],
        props: {
            title: {
                type: String,
                required: true,
            },
            active: {
                type: Boolean,
                default: false,
            }
        },
        data() {
            return {
                sidebarDropdown: false,
            }
        },
        methods: {
            closeDropdown() {
                this.sidebarDropdown = false;
            }
        }
    }
</script>

<style lang='scss' scoped>
    .nav-item.dropdown .nav-link::after {
        transition: all .3s linear;
    }

    .nav-item.dropdown.active {
        .nav-link::after {
            transform: rotate(135deg);
        }
    }
</style>
