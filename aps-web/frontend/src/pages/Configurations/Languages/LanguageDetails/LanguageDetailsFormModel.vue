<template>
    <q-dialog :model-value="model" persistent>
        <q-card class="min-w-[500px]">
            <q-card-section>
                <p class="font-semibold text-lg">
                    {{ $translate('Language details') }}
                </p>
            </q-card-section>
            <ValidationFrom
                :validation-schema="schema"
                @submit="onSubmit"
                v-slot="test"
            >
                <q-card-section>
                    <Field
                        name="word"
                        :value="language?.word"
                        v-slot="{ errorMessage, value, field }"
                    >
                        <q-input
                            :model-value="value"
                            dense
                            autofocus
                            outlined
                            :error="!!errorMessage"
                            :error-message="$translate(errorMessage)"
                            v-bind="field"
                            label="Word"
                        >
                        </q-input>
                    </Field>
                    <Field
                        :value="language?.translation"
                        name="translation"
                        v-slot="{ errorMessage, value, field }"
                    >
                        <q-input
                            :model-value="value"
                            dense
                            outlined
                            :error="!!errorMessage"
                            :error-message="$translate(errorMessage)"
                            v-bind="field"
                            label="Translation"
                            @keyup.ctrl.enter="handleSubmit(test)"
                            :dir="dir"
                            @keypress="event => checkDir(event.target)"
                        />
                    </Field>
                </q-card-section>
                <q-card-actions align="right">
                    <q-btn
                        dense
                        outline
                        color="green"
                        icon-right="save"
                        type="submit"
                        :loading="loading"
                        ref="formRef"
                    >
                        {{ $translate('Save') }}
                    </q-btn>
                    <q-btn
                        dense
                        outline
                        color="red"
                        icon-right="close"
                        type="button"
                        @click="handleLanguageWordFormModel(false, null)"
                    >
                        {{ $t('Close') }}
                    </q-btn>
                </q-card-actions>
            </ValidationFrom>
        </q-card>
    </q-dialog>
</template>
<script>
import { defineComponent, ref } from 'vue'
import { Form as ValidationFrom, Field } from 'vee-validate'
import * as yup from 'yup'
import { api } from 'boot/axios'
import { appRoutes } from 'src/appRouter/routes'
import { errorHandler } from 'src/lib/errorHandler'
import { useQuasar } from 'quasar'
import { useRoute } from 'vue-router'
import { useGeneralStore } from 'stores/generalStore'
import { detectLanguage } from 'src/lib/helpers'
import { useLanguageStore } from 'stores/languageStore'

export default defineComponent({
    components: { ValidationFrom, Field },
    name: 'LanguageDetailsFormModel',
    props: ['model', 'handleLanguageWordFormModel', 'mutate', 'language'],
    setup() {
        const schema = yup.object({
            word: yup.string().required('This section is required'),
            translation: yup.string().required('This section is required'),
        })
        const q = useQuasar()
        const route = useRoute()
        const generalStore = useGeneralStore()
        const languageStore = useLanguageStore()
        const formRef = ref()
        return {
            schema,
            q,
            route,
            generalStore,
            detectLanguage,
            languageStore,
            formRef,
        }
    },
    data() {
        return {
            loading: false,
            dir: 'ltr',
        }
    },
    methods: {
        handleSubmit(data) {
            data.submitForm()
        },
        async onSubmit(values, actions) {
            this.loading = true
            try {
                const url = this.language
                    ? appRoutes.configurations.languages.details.api +
                      '/' +
                      this.language.id
                    : appRoutes.configurations.languages.details.api
                const method = this.language ? 'PUT' : 'POST'
                const data = {
                    ...values,
                    language_id: this.route.params.id,
                    id: this.language ? this.language.id : 0,
                }
                const result = await api({
                    url,
                    method,
                    data,
                })

                if (result.data.result) {
                    this.generalStore.revalidate(this.mutate)
                    this.loading = false
                    this.q.notify({
                        message: this.$translate(result.data.message),
                        color: 'green',
                    })
                    console.log(actions.resetForm())
                    // this.handleLanguageWordFormModel(false, null)
                    this.languageStore.getLanguageDictionary()
                } else {
                    this.loading = false
                    this.q.notify({
                        message: this.$translate(result.data.message),
                        color: 'red',
                    })
                }
            } catch (e) {
                errorHandler(e, actions.setErrors)
                this.loading = false
            }
        },
        checkDir(value) {
            this.dir = this.detectLanguage(value.value)
        },
    },
})
</script>
