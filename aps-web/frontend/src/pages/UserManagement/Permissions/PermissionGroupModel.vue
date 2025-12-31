<template>
    <q-dialog :model-value="showModel" persistent>
        <q-card style="min-width: 350px">
            <q-card-section>
                <div class="text-h6" v-if="modelType === 'permission-group'">
                    Add permission group
                </div>
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
                    <Field
                        :value="icon"
                        name="icon"
                        v-slot="{ errorMessage, value, field }"
                    >
                        <q-input
                            placeholder="Write icon name"
                            label="Icon"
                            outlined
                            dense
                            v-bind="field"
                            :model-value="value"
                            :error="!!errorMessage"
                        />
                        <a
                            href="https://fonts.google.com"
                            class="text-blue cursor-pointer underline text-xs"
                            target="_blank"
                            >Find icon here</a
                        >
                    </Field>
                </q-card-section>
                <q-card-actions align="right">
                    <q-btn
                        size="small"
                        color="red"
                        label="Close"
                        type="button"
                        icon-right="close"
                        @click="handleCloseModel"
                    />
                    <q-btn
                        size="small"
                        color="green"
                        label="Save"
                        type="submit"
                        icon-right="save"
                        :loading="loading"
                    />
                </q-card-actions>
            </ValidationForm>
        </q-card>
    </q-dialog>
</template>
<script>
import { defineComponent } from 'vue'
import { Field, Form as ValidationForm, useForm } from 'vee-validate'
import * as yup from 'yup'
import { api } from 'boot/axios'
import { errorHandler } from 'src/lib/errorHandler'
import { useQuasar } from 'quasar'

export default defineComponent({
    name: 'PermissionGroupModel',
    components: { Field, ValidationForm },
    props: [
        'showModel',
        'parentId',
        'handleCloseModel',
        'modelType',
        'name',
        'icon',
    ],
    setup() {
        const schema = yup.object({
            name: yup.string().required('This section is required'),
            icon: yup.string().nullable(),
        })
        useForm({
            initialValues: {
                name: 'This is for testing',
            },
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
        onSubmit(values, actions) {
            const url = this.name
                ? `/user-management/permission-groups/${this.parentId}`
                : '/user-management/permission-groups'
            const method = this.name ? 'PUT' : 'POST'
            const data = {
                name: values.name,
                icon: values.icon ?? null,
                permission_group_id: this.parentId,
            }
            this.loading = true
            api({
                url,
                method,
                data,
            })
                .then(res => {
                    this.loading = false
                    if (res.data.result) {
                        this.$q.notify({
                            message: res.data.message,
                            color: 'green',
                        })
                        this.handleCloseModel()
                    }
                })
                .catch(e => {
                    this.loading = false
                    errorHandler(e, actions.setErrors)
                })
        },
    },
})
</script>
