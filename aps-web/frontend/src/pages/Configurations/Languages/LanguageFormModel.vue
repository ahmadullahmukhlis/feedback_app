<template>
    <q-dialog :model-value="model" persistent dir="rtl">
        <q-card class="min-w-[300px]">
            <q-card-section>
                <p class="font-semibold text-lg">Language Form</p>
            </q-card-section>
            <ValidationFrom :validation-schema="schema" @submit="onSubmit">
                <q-card-section>
                    <Field name="name" v-slot="{ errorMessage, value, field }">
                        <q-input
                            :model-value="value"
                            dense
                            outlined
                            :error="!!errorMessage"
                            :error-message="$translate(errorMessage)"
                            v-bind="field"
                            label="Name"
                        />
                    </Field>
                    <Field name="abbr" v-slot="{ errorMessage, value, field }">
                        <q-input
                            :model-value="value"
                            dense
                            outlined
                            :error="!!errorMessage"
                            :error-message="$translate(errorMessage)"
                            v-bind="field"
                            label="Abbreviation"
                        />
                    </Field>
                    <Field
                        name="direction"
                        v-slot="{ errorMessage, value, field }"
                    >
                        <q-select
                            :model-value="value"
                            :options="['rtl', 'ltr']"
                            dense
                            outlined
                            :error="!!errorMessage"
                            :error-message="$translate(errorMessage)"
                            v-bind="field"
                            label="Abbreviation"
                        />
                    </Field>
                </q-card-section>
                <q-card-actions align="right">
                    <q-btn
                        dense
                        outline
                        color="red"
                        icon-right="close"
                        type="button"
                        @click="handleModel(false, null)"
                    >
                        Close
                    </q-btn>
                    <q-btn
                        dense
                        outline
                        color="green"
                        icon-right="save"
                        type="submit"
                        :loading="loading"
                    >
                        Save
                    </q-btn>
                </q-card-actions>
            </ValidationFrom>
        </q-card>
    </q-dialog>
</template>
<script>
import { defineComponent } from 'vue'
import { Form as ValidationFrom, Field } from 'vee-validate'
import * as yup from 'yup'
import { api } from 'boot/axios'
import { appRoutes } from 'src/appRouter/routes'
import { errorHandler } from 'src/lib/errorHandler'
import { useQuasar } from 'quasar'
import { useGeneralStore } from 'stores/generalStore'

export default defineComponent({
    components: { ValidationFrom, Field },
    name: 'LanguageFormModel',
    props: ['model', 'handleModel', 'language'],
    setup() {
        const schema = yup.object({
            name: yup.string().required('This section is required'),
            abbr: yup.string().required('This section is required'),
            direction: yup.string().required('This section is required'),
        })
        const q = useQuasar()
        const generalStore = useGeneralStore()
        return {
            schema,
            q,
            generalStore,
        }
    },
    data() {
        return {
            loading: false,
        }
    },
    methods: {
        async onSubmit(values, actions) {
            this.loading = true
            try {
                const result = await api.post(
                    appRoutes.configurations.languages.api,
                    values,
                )
                if (result.data.result) {
                    this.loading = false
                    this.q.notify({
                        message: this.$translate(result.data.message),
                        color: 'green',
                    })
                    this.handleModel()
                    this.generalStore.revalidate('language')
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
    },
})
</script>
