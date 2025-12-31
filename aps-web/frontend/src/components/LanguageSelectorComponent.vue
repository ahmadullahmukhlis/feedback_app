<template>
    <q-btn
        :loading="languageStore.loading"
        icon="language"
        size="small"
        flat
        round
    >
        <q-menu transition-show="flip-right" transition-hide="flip-left">
            <q-list dense>
                <q-item
                    v-for="language in languageStore.languages"
                    :key="language.id"
                    :focused="languageStore.selected_language === language.abbr"
                    clickable
                    v-close-popup
                    @click="
                        languageStore.setLanguage(language.abbr, language.dir)
                    "
                >
                    <q-item-section>{{ language.name }}</q-item-section>
                </q-item>
            </q-list>
        </q-menu>
        <q-tooltip> {{ $translate('Languages') }} </q-tooltip>
    </q-btn>
</template>
<script>
import { defineComponent } from 'vue'
import { useLanguageStore } from 'stores/languageStore'

export default defineComponent({
    name: 'LanguageSelectorComponent',
    setup() {
        const languageStore = useLanguageStore()
        return {
            languageStore,
        }
    },
    mounted() {
        this.languageStore.getLanguages()
    },
})
</script>
