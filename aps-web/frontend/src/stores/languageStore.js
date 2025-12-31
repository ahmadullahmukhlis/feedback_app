import { defineStore } from 'pinia'
import { api } from 'boot/axios'
import { appRoutes } from 'src/appRouter/routes'
import { errorHandler } from 'src/lib/errorHandler'

export const useLanguageStore = defineStore('languageStore', {
    state: () => ({
        languages: [],
        selected_language: 'eng',
        loading: true,
        direction: 'ltr',
        words: [],
    }),
    getters: {
        doubleCount: state => state.counter * 2,
    },
    actions: {
        async getLanguages() {
            if (this.languages.length < 1) {
                try {
                    const result = await api.get(
                        appRoutes.configurations.languages.api,
                    )
                    this.languages.push({
                        name: 'English',
                        id: 0,
                        abbr: 'eng',
                        dir: 'ltr',
                    })
                    result.data.data.map(lang =>
                        this.languages.push({
                            name: lang.name,
                            id: lang.id,
                            abbr: lang.abbr,
                            dir: lang.direction,
                        }),
                    )
                } catch (err) {
                    errorHandler(err)
                    this.languages = [
                        {
                            name: 'English',
                            id: 0,
                        },
                    ]
                } finally {
                    this.loading = false
                }
            }
        },
        async getLanguageDictionary() {
            this.loading = true
            try {
                const result = await api.get('/language/words')
                this.words = result.data
            } finally {
                this.loading = false
            }
        },
        async setLanguage(lang, direction) {
            this.selected_language = lang
            localStorage.setItem('lang', lang)
            this.direction = direction
            localStorage.setItem('dir', direction)
            if (lang !== 'eng') {
                this.getLanguageDictionary(lang)
            } else {
                this.words = []
            }
        },
        translate(text, variables = null) {
            if (this.selected_language !== 'eng' && this.loading)
                return 'Loading...'
            if (typeof text === 'undefined' || text === null) {
                return text
            } else {
                let outputString = text.replace(/ /g, '-').toLowerCase()
                if (typeof this.words[outputString] === 'undefined') {
                    for (let key in variables) {
                        text = text.replace(`[${key}]`, variables[key])
                    }
                    return text
                } else {
                    let string = this.words[outputString]
                    for (let key in variables) {
                        string = string.replace(`[${key}]`, variables[key])
                    }
                    return string
                }
            }
        },
    },
})
