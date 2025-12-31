<template>
    <protected-component permission-key="language-dictionary-access">
        <div class="flex items-center justify-between">
            <p class="font-bold text-lg">
                {{
                    languageStore.translate(
                        '[language_name] Language Dictionary',
                        {
                            language_name: $route.params.name,
                        },
                    )
                }}
            </p>
            <protected-component permission-key="language-dictionary-add-word">
                <q-btn
                    color="primary"
                    size="sm"
                    icon-right="add"
                    @click="handleLanguageWordFormModel(true, null)"
                >
                    {{ languageStore.translate('Add language translations') }}
                </q-btn>
            </protected-component>
        </div>
        <datatable-component
            :url="appRoutes.configurations.languages.details.api"
            table-name="language-word"
            delete-permission-key="language-dictionary-delete-word"
            edit-permission-key="language-dictionary-edit-word"
            :on-edit="data => handleLanguageWordFormModel(true, data)"
            :filters="{
                language_id: $route.params.id,
            }"
            :columns="[
                {
                    name: 'id',
                    label: 'ID',
                },
                {
                    name: 'word',
                    label: 'Word',
                },
                {
                    name: 'translation',
                    label: 'Translation',
                },
                {
                    name: 'created_at',
                    label: 'Created At',
                },
            ]"
        />
        <language-details-form-model
            :model="language_word.model"
            :handle-language-word-form-model="handleLanguageWordFormModel"
            :language="language_word.data"
            mutate="language-word"
        />
    </protected-component>
</template>
<script>
import { defineComponent } from 'vue'
import ProtectedComponent from 'components/ProtectedComponent.vue'
import DatatableComponent from 'components/DatatableComponent.vue'
import { appRoutes } from 'src/appRouter/routes'
import LanguageDetailsFormModel from 'pages/Configurations/Languages/LanguageDetails/LanguageDetailsFormModel.vue'
import { useGeneralStore } from 'stores/generalStore'
import { useLanguageStore } from 'stores/languageStore'

export default defineComponent({
    name: 'LanguageDetailsPage',
    components: {
        LanguageDetailsFormModel,
        DatatableComponent,
        ProtectedComponent,
    },
    setup() {
        const generalStore = useGeneralStore()
        const languageStore = useLanguageStore()
        return {
            appRoutes,
            generalStore,
            languageStore,
        }
    },
    data() {
        return {
            language_word: {
                model: false,
                data: null,
            },
        }
    },
    methods: {
        handleLanguageWordFormModel(model, data) {
            this.language_word = {
                model,
                data,
            }
        },
    },
    mounted() {
        this.generalStore.setActivePage('configurations')
        this.generalStore.setPageTitle('Language details')
    },
})
</script>
