<template>
    <div class="btn-list me-1">
        <select class="form-select" @change="onChange($event)" v-if="langs">
            <option v-for="(lang, i) in langs" :key="`lang-${i}`" :value="i" :selected="i == selectedLanguage">
                {{ i.toUpperCase() }}
            </option>
        </select>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    name: 'SwitchLocale',
    data() {
        return {
            selectedLanguage: ''
        }
    },
    computed: {
        ...mapGetters({
            langs: "getAllLocales",
        })
    },
    methods: {
        onChange(event) {
            let locale = event.target.value;
            this.switchLocale(locale);
        },
        switchLocale(locale) {
            if (this.$i18n.locale !== locale) {
                this.$i18n.locale = locale;
            }

            this.selectedLanguage = locale;
            localStorage.setItem('lang', locale)
        }
    },
    async mounted(){
        let app_default = await axios.get('/api/app/default');
        let default_language = app_default.data.language
        let local_language = localStorage.getItem('lang')
        let code = local_language ? local_language:default_language

        this.$i18n.locale = code
        this.selectedLanguage = code;

        // let code = localStorage.getItem('lang') || 'en';
        // this.$i18n.locale = code
        // this.selectedLanguage = code;
    }
}
</script>

<style>
select {
    width: 150px;
    line-height: 49px;
    height: 38px;
    font-size: 22px;
    outline: 0;
    margin-bottom: 15px;
}
</style>
