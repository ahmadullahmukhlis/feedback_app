<template>
    <q-dialog :model-value="permissionModel" persistent>
        <q-card class="w-[300px]">
            <q-card-section>
                <h2 class="text-xl">
                    {{ $translate('Add permission to group') }}
                </h2>
            </q-card-section>
            <ValidationForm :validation-schema="schema" @submit="onSubmit">
                <q-card-section>
                    <Field
                        name="name"
                        v-slot="{ errorMessage, value, field }"
                        :value="name"
                    >
                        <q-input
                            label="Name"
                            outlined
                            dense
                            v-bind="field"
                            :model-value="value"
                            :error-message="errorMessage?.replace('_', ' ')"
                            :error="!!errorMessage"
                        />
                    </Field>
                </q-card-section>
                <q-card-actions align="right">
                    <q-btn
                        size="small"
                        dense
                        color="red"
                        type="button"
                        icon-right="close"
                        :loading="loading"
                        @click="handleModelClose"
                    >
                        {{ $translate('Close') }}
                    </q-btn>
                    <q-btn
                        size="small"
                        dense
                        color="green"
                        type="submit"
                        icon-right="save"
                        :loading="loading"
                    >
                        {{ $translate('Save') }}
                    </q-btn>
                </q-card-actions>
            </ValidationForm>
        </q-card>
    </q-dialog>
</template>
<script>
import { defineComponent, useTransitionState } from 'vue'
import { Form as ValidationForm, Field } from 'vee-validate'
import * as yup from 'yup'
import { api } from 'boot/axios'
import { appRoutes } from 'src/appRouter/routes'
import { errorHandler } from 'src/lib/errorHandler'
import { useQuasar } from 'quasar'
export default defineComponent({
    name: 'PermissionFormModel',
    components: { ValidationForm, Field },
    props: [
        'permissionModel',
        'permissionGroupId',
        'handleModelClose',
        'mutate',
    ],
    setup() {
        const schema = yup.object({
            name: yup.string().required('This section is required'),
        })
        const q = useQuasar()
        const { translate } = useTransitionState()
        return {
            schema,
            q,
            translate,
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
                    appRoutes.user_management.permission.api,
                    {
                        name: values?.name,
                        permission_group_id: this.permissionGroupId,
                    },
                )
                if (result.data.result) {
                    await this.mutate()
                    this.q.notify({
                        message: this.translate(result.data.message),
                        color: 'green',
                    })
                    this.loading = false
                    this.handleModelClose()
                } else {
                    this.q.notify({
                        message: this.translate(result.data.message),
                        color: 'red',
                    })
                    this.handleModelClose()
                    this.loading = false
                }
            } catch (e) {
                errorHandler(e, actions.setErrors)
                this.loading = false
            }
        },
    },
})
</script>
