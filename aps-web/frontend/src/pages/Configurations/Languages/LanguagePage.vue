<template>
    <protected-component permission-key="languages-access" is-page>
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">
                {{ translate('List of languages') }}
            </h2>
            <protected-component permission-key="languages-create">
                <q-btn
                    color="primary"
                    size="small"
                    icon-right="add"
                    @click="handleModel(true, null)"
                >
                    {{ translate('Add new language') }}
                </q-btn>
            </protected-component>
        </div>
        <div class="mt-4">
            <server-data
                id="language"
                :url="appRoutes.configurations.languages.api"
                :from-resource="true"
            >
                <template v-slot="{ data }">
                    <q-chip
                        v-for="language in data"
                        :key="language.id"
                        :label="language.name"
                        :removable="authStore.isAllowed('languages-delete')"
                        @remove="handleRemove(language.id)"
                        :clickable="
                            authStore.isAllowed('languages-view-details')
                        "
                        @click="handleLanguageClick(language.id, language.name)"
                    />
                </template>
            </server-data>
        </div>
        <language-form-model
            :model="language.model"
            :language="language.data"
            :handle-model="handleModel"
        />
    </protected-component>
</template>
<script>
import { defineComponent } from 'vue'
import { useGeneralStore } from 'stores/generalStore'
import ProtectedComponent from 'components/ProtectedComponent.vue'
import ServerData from 'components/ServerData.vue'
import { appRoutes } from 'src/appRouter/routes'
import LanguageFormModel from 'pages/Configurations/Languages/LanguageFormModel.vue'
import { useAuthStore } from 'stores/UserManagementStores/AuthStore'
import { useQuasar } from 'quasar'
import { api } from 'boot/axios'
import { errorHandler } from 'src/lib/errorHandler'
import { useRouter } from 'vue-router'
import { useLanguageStore } from 'stores/languageStore'

export default defineComponent({
    name: 'LanguagePage',
    components: { LanguageFormModel, ServerData, ProtectedComponent },
    setup() {
        const generalStore = useGeneralStore()
        const authStore = useAuthStore()
        const q = useQuasar()
        const router = useRouter()
        const { translate } = useLanguageStore()
        return {
            generalStore,
            appRoutes,
            authStore,
            q,
            api,
            router,
            translate,
        }
    },
    mounted() {
        this.generalStore.setPageTitle('Languages')
        this.generalStore.setActivePage('configurations')
    },
    data() {
        return {
            language: {
                model: false,
                data: null,
            },
        }
    },
    methods: {
        handleModel(model, data) {
            this.language = {
                model,
                data,
            }
        },
        async handleRemove(id) {
            this.q
                .dialog({
                    title: 'Confirm',
                    message: 'Are you sure you want to remove',
                    cancel: true,
                })
                .onOk(async () => {
                    try {
                        this.q.loading.show()
                        const result = await api.delete(
                            appRoutes.configurations.languages.api + '/' + id,
                        )
                        if (result.data.result) {
                            this.generalStore.revalidate('language')
                            this.q.notify({
                                message: this.$translate(result.data.message),
                                color: 'green',
                            })
                            this.generalStore.revalidate('language')
                        } else {
                            this.q.notify({
                                message: this.$translate(result.data.message),
                                color: 'red',
                            })
                        }
                    } catch (err) {
                        errorHandler(err, '', this.router)
                    } finally {
                        this.q.loading.hide()
                    }
                })
        },
        handleLanguageClick(id, name) {
            this.router.push({
                path: this.appRoutes.configurations.languages.details.path
                    .replace(':id', id)
                    .replace(':name', name),
            })
        },
    },
})
</script>
