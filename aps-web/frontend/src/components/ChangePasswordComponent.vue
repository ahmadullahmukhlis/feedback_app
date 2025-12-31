<template>
    <!-- notice dialogRef here -->
    <ValidationForm :validation-schema="schema" @submit="onSubmit">
        <q-dialog no-backdrop-dismiss ref="dialogRef" @hide="onDialogHide">
            <q-card class="q-dialog-plugin">
                <q-card-section>
                    <p class="text-2xl py-3 pb-5 text-center">
                        Please change your password
                    </p>
                    <Field
                        name="old_password"
                        v-slot="{ errorMessage, value, field }"
                    >
                        <q-input
                            type="password"
                            label="Old password"
                            :model-value="value"
                            v-bind="field"
                            :error-message="errorMessage?.replace('_', ' ')"
                            :error="!!errorMessage"
                            outlined
                            dense
                        />
                    </Field>
                    <Field
                        name="new_password"
                        v-slot="{ errorMessage, value, field }"
                    >
                        <q-input
                            type="password"
                            label="New password"
                            :model-value="value"
                            v-bind="field"
                            :error-message="errorMessage?.replace('_', ' ')"
                            :error="!!errorMessage"
                            outlined
                            dense
                        />
                    </Field>
                    <Field
                        name="confirm_password"
                        v-slot="{ errorMessage, value, field }"
                    >
                        <q-input
                            type="password"
                            label="Confirm password"
                            :model-value="value"
                            v-bind="field"
                            :error-message="errorMessage?.replace('_', ' ')"
                            :error="!!errorMessage"
                            outlined
                            dense
                        />
                    </Field>
                </q-card-section>
                <q-card-actions align="right">
                    <q-btn
                        :loading="loading"
                        color="green"
                        label="Save"
                        type="submit"
                        icon-right="save"
                    />
                    <q-btn
                        @click="onCancelClick"
                        v-if="showCloseButton"
                        :loading="loading"
                        color="red"
                        label="Close"
                        type="button"
                        icon-right="close"
                    />
                </q-card-actions>
            </q-card>
        </q-dialog>
    </ValidationForm>
</template>

<script>
import { useDialogPluginComponent, useQuasar } from 'quasar'
import { Form as ValidationForm, Field } from 'vee-validate'
import * as yup from 'yup'
import { useAuthStore } from 'stores/UserManagementStores/AuthStore'
import { errorHandler } from 'src/lib/errorHandler'
import { useLanguageStore } from 'stores/languageStore'

export default {
    props: ['showCloseButton'],
    emits: [...useDialogPluginComponent.emits],
    components: {
        ValidationForm,
        Field,
    },
    setup(props) {
        const { dialogRef, onDialogHide, onDialogOK, onDialogCancel } =
            useDialogPluginComponent()
        const schema = yup.object({
            old_password: yup.string().required('This section is required'),
            new_password: yup.string().required('This section is required'),
            confirm_password: yup.string().required('This section is required'),
        })
        const authStore = useAuthStore()
        const q = useQuasar()
        const { translate } = useLanguageStore()
        return {
            dialogRef,
            onDialogHide,
            onCancelClick: onDialogCancel,
            schema,
            onDialogOK,
            authStore,
            q,
            showClose: props.showCloseButton,
        }
    },
    methods: {
        async onSubmit(values, actions) {
            try {
                this.loading = true
                const result = await this.authStore.changePassword(
                    values.old_password,
                    values.new_password,
                    values.confirm_password,
                )
                this.loading = false
                if (result.data.result) {
                    this.$q.notify({
                        message: this.tra,
                        color: 'green',
                    })
                    this.onDialogOK()
                } else {
                    this.$q.notify({
                        message: 'Something went wrong',
                        color: 'red',
                    })
                }
            } catch (e) {
                this.loading = false
                errorHandler(e, actions.setErrors)
            }
        },
    },
    data() {
        return {
            loading: false,
        }
    },
}
</script>
