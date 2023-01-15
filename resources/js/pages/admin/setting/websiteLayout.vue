<template>
    <div>
        <div class="page-header d-print-none">
             <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t('website_setting') }}</h2>
                </div>
            </div>
        </div>
        <div class="row row-deck row-cards justify-content-center">
            <div class="col-12">
                <div class="card">
                    <ul class="nav nav-tabs" data-bs-toggle="tabs">
                        <li class="nav-item">
                            <router-link :to="{ name:'setting-website' }" class="nav-link" data-bs-toggle="tab">
                                {{ $t('website') }}</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name:'setting-website-home' }" class="nav-link" data-bs-toggle="tab">
                                {{ $t('home') }}</router-link>
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

<style>
    .nav-tabs .nav-link.nav-active {
        color: #232e3c;
        background: transparent;
        border-color: transparent;
        border-bottom-color: #206bc4;
    }
</style>
