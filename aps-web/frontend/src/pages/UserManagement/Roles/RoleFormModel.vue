<template>
    <q-dialog :model-value="model" persistent>
        <q-card class="min-w-[300px]">
            <q-card-section>
                <p class="font-semibold text-lg">
                    {{ $translate('Role Form') }}
                </p>
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
                </q-card-section>
                <q-card-actions align="right">
                    <q-btn
                        dense
                        outline
                        color="red"
                        icon-right="close"
                        type="button"
                        @click="handleModelClose"
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

export default defineComponent({
    components: { ValidationFrom, Field },
    name: 'RoleFormModel',
    props: ['model', 'handleModelClose', 'mutate'],
    setup() {
        const schema = yup.object({
            name: yup.string().required('This section is required'),
        })
        const q = useQuasar()
        return {
            schema,
            q,
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
                    appRoutes.user_management.roles.api,
                    values,
                )
                if (result.data.result) {
                    await this.mutate()
                    this.loading = false
                    this.q.notify({
                        message: this.$translate(result.data.message),
                        color: 'green',
                    })
                    this.handleModelClose()
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
