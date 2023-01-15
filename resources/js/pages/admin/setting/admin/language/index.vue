<template>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">{{ $t('language')+' '+$t('list') }}</h4>
            <div>
                <router-link :to="{ name: 'setting-language-add' }" class="btn btn-primary">
                    {{ $t('add')+' '+$t('language') }}</router-link>
            </div>
        </div>
        <div class="card-body border-bottom py-3">
            <loader v-if="loading" />
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>{{ $t('language')+' '+$t('name') }}</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(language, index) in languageList" :key="index">
                            <td class="text-muted">
                                {{ index }}
                            </td>
                            <td>
                                <router-link :to="{ name: 'setting-language-edit', params: { slug: index }}"
                                    class="btn btn-info text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-edit m-0" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"></path>
                                        <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"></path>
                                        <line x1="16" y1="5" x2="19" y2="8"></line>
                                    </svg>
                                </router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            loading: false
        };
    },

    computed: {
        ...mapGetters({
            languageList: "getAllLocales"
        })
    }
};
</script>

<style scoped>
    @media (max-width: 420px) {
        .btn-info {
            font-size: 10px;
            padding: 2px 5px;
        }
        .card-title {
            font-size: 15px;
        }
        .btn-primary {
            font-size: 8px;
            padding: 3px 7px;
        }
    }
</style>
