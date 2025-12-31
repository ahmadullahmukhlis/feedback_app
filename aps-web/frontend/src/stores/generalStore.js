import { defineStore } from 'pinia'
import { useLanguageStore } from 'stores/languageStore'
import { api } from 'boot/axios'
import { appRoutes } from 'src/appRouter/routes'

export const useGeneralStore = defineStore('GeneralStore', {
    state: () => ({
        change_password: false,
        active_page: null,
        page_title: null,
        btn_loading: false,
        full_page_loading: false,
        table: null,
        revalidateServerData: null,
        filters: {
            model: false,
            options: {},
        },
        update_id: 0,
        event_message: null,
        newUpdatePushed: false,
        store_settings: null,
        print_page: false,
        created_id: 0,
    }),
    actions: {
        setActivePage(value) {
            this.active_page = value
        },
        setPageTitle(value) {
            const { translate } = useLanguageStore()
            this.page_title = translate(value)
        },
        setLoading(value, type = 'btn') {
            if (value) {
                if (type === 'btn') {
                    this.btn_loading = true
                } else {
                    this.full_page_loading = true
                }
            } else {
                this.btn_loading = false
                this.full_page_loading = false
            }
        },
        revalidate(table, created_id = 0) {
            this.table = table
            this.revalidateServerData = table
            this.created_id = created_id
        },
        setFilter(model, options) {
            this.filters = {
                model,
                options,
            }
        },
        setUpdateId(id) {
            this.update_id = id
        },
        setEventMessage(message) {
            this.event_message = message
        },
        setNewUpdatedPushed(status) {
            this.newUpdatePushed = status
        },
        async getStoreSettings() {
            try {
                const result = await api.get(
                    appRoutes.configurations.systemConfiguration
                        .softwareConfiguration.api,
                )
                this.store_settings = result.data.data
            } catch (err) {}
        },
        setProducts() {
            console.log(this.event_message)
        },
        setPrintPage(condition) {
            this.print_page = condition
        },
    },
})
