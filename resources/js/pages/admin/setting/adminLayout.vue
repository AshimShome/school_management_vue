<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t('admin_setting') }}</h2>
                </div>
            </div>
        </div>
        <div class="row row-deck row-cards justify-content-center">
            <div class="col-12">
                <div class="card">
                    <ul class="nav nav-tabs flex-column flex-md-row" data-bs-toggle="tabs">
                        <li class="nav-item">
                            <router-link :to="{ name:'setting-admin' }" class="nav-link" data-bs-toggle="tab">
                                {{ $t('basic') }}</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name:'setting-admin-system' }" class="nav-link" data-bs-toggle="tab">
                                {{ $t('system') }}</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name:'setting-admin-theme' }" class="nav-link" data-bs-toggle="tab">
                                {{ $t('theme') }}</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name:'setting-admin-mail' }" class="nav-link" data-bs-toggle="tab">
                                {{ $t('mail') }}</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name:'setting-admin-payment' }" class="nav-link" data-bs-toggle="tab">
                                {{ $t('payment') }}</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                            :to="{ name:'setting-admin-language' }"
                            data-bs-toggle="tab"
                            class="nav-link"
                            :class="{ active: checkRoute([ 'setting-language-add', 'setting-language-edit']) }">
                                {{ $t('language') }}
                            </router-link>
                        </li>
                    </ul>
                    <div class="card-body">
                        <vue-page-transition name="fade">
                            <router-view />
                        </vue-page-transition>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
            this.hasPermisssion('setting-list')
        }
    }
</script>

<style>
    .nav-tabs .nav-link.nav-active {
        color: #232e3c;
        background: transparent;
        border-color: transparent;
        border-bottom-color: #206bc4;
    }
</style>
