<template>
    <q-dialog :model-value="true" persistent>
        <q-card class="md:min-w-[500px]">
            <q-card-section>
                <p class="font-semibold text-lg">
                    {{ translate('User form') }}
                </p>
            </q-card-section>
            <ValidationFrom :validation-schema="schema" @submit="onSubmit">
                <q-card-section v-if="!full_page_loading">
                    <Field name="image" v-slot="{ errorMessage, field }">
                        <ProfileImageSelector
                            :error-message="$translate(errorMessage)"
                            :default="server_user && server_user.image"
                            :on-change="data => field.onChange(data)"
                        />
                    </Field>
                    <div class="mt-4 grid grid-cols-2 gap-x-2">
                        <Field
                            name="first_name"
                            :value="server_user && server_user.first_name"
                            v-slot="{ errorMessage, value, field }"
                        >
                            <q-input
                                :model-value="value"
                                dense
                                outlined
                                v-bind="field"
                                :label="translate('First name')"
                                :error="!!errorMessage"
                                :error-message="
                                    errorMessage?.replaceAll('_', ' ')
                                "
                            />
                        </Field>
                        <Field
                            name="last_name"
                            :value="server_user && server_user.last_name"
                            v-slot="{ errorMessage, value, field }"
                        >
                            <q-input
                                :model-value="value"
                                dense
                                outlined
                                v-bind="field"
                                :label="translate('Last name')"
                                :error="!!errorMessage"
                                :error-message="
                                    errorMessage?.replaceAll('_', ' ')
                                "
                            />
                        </Field>
                        <div class="col-span-2">
                            <Field
                                :value="server_user && server_user.email"
                                name="email"
                                v-slot="{ errorMessage, value, field }"
                            >
                                <q-input
                                    :model-value="value"
                                    dense
                                    outlined
                                    v-bind="field"
                                    :label="translate('Email or username')"
                                    :error="!!errorMessage"
                                    :error-message="
                                        errorMessage?.replaceAll('_', ' ')
                                    "
                                />
                            </Field>
                        </div>
                        <Field
                            name="password"
                            v-slot="{ errorMessage, value, field }"
                        >
                            <q-input
                                :model-value="value"
                                dense
                                outlined
                                v-bind="field"
                                :label="translate('Password')"
                                type="password"
                                :error="!!errorMessage"
                                :error-message="
                                    errorMessage?.replaceAll('_', ' ')
                                "
                            />
                        </Field>
                        <Field
                            name="confirm_password"
                            v-slot="{ errorMessage, value, field }"
                        >
                            <q-input
                                :model-value="value"
                                dense
                                outlined
                                v-bind="field"
                                :label="translate('Confirm password')"
                                type="password"
                                :error="!!errorMessage"
                                :error-message="
                                    errorMessage?.replaceAll('_', ' ')
                                "
                            />
                        </Field>
                        <div class="col-span-2">
                            <Field
                                name="roles"
                                :value="server_user && server_user.roles"
                                v-slot="{ errorMessage, field }"
                            >
                                <select-component
                                    :url="
                                        appRoutes.user_management.roles.api +
                                        '?fetch_all'
                                    "
                                    :multiple="true"
                                    :default-value="
                                        server_user && server_user.roles
                                    "
                                    :on-change="
                                        data => {
                                            field.onChange(
                                                data.length < 1 ? [] : data,
                                            )
                                        }
                                    "
                                    :error-message="$translate(errorMessage)"
                                    :label="translate('Roles')"
                                    option-label="name"
                                    option-value="id"
                                />
                            </Field>
                            <Field
                                v-if="user"
                                name="is_active"
                                v-slot="{ field }"
                                :value="server_user && server_user.is_active"
                            >
                                <q-toggle
                                    v-model="is_active"
                                    @update:model-value="
                                        value => field.onChange(value)
                                    "
                                    :label="translate('Is active')"
                                />
                            </Field>
                        </div>
                    </div>
                </q-card-section>
                <q-card-section v-else>
                    <div class="flex items-center justify-center">
                        <q-spinner size="3rem" color="primary" />
                    </div>
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
import SelectComponent from 'components/SelectComponent.vue'
import ProfileImageSelector from 'components/ProfileImageSelector.vue'
import { useGeneralStore } from 'stores/generalStore'
import { useLanguageStore } from 'stores/languageStore'

export default defineComponent({
    components: {
        ProfileImageSelector,
        SelectComponent,
        ValidationFrom,
        Field,
    },
    name: 'UserFormModel',
    props: ['model', 'handleModelClose', 'mutate', 'user'],
    setup(props) {
        const schema = yup.object({
            image: yup.mixed().when('user', (_, schema) => {
                if (!props.user) {
                    return schema.required('This section is required')
                }
            }),
            first_name: yup.string().required('This section is required'),
            is_active: yup
                .boolean()
                .required('This section is required')
                .default(true),
            last_name: yup.string().required('This section is required'),
            email: yup.string().required('This section is required'),
            password: yup.string().when('user', (_, schema) => {
                if (!props.user) {
                    return schema.required('This section is required')
                }
            }),
            confirm_password: yup.string().when('user', (_, schema) => {
                if (!props.user) {
                    return schema
                        .required('This section is required')
                        .oneOf(
                            [yup.ref('password'), null],
                            'Passwords must match',
                        )
                }
            }),
            roles: yup.array().required('This section is required').min(1),
        })
        const q = useQuasar()
        const generalStore = useGeneralStore()
        const { translate } = useLanguageStore()
        return {
            schema,
            q,
            appRoutes,
            generalStore,
            translate,
        }
    },
    data() {
        return {
            loading: false,
            profile: null,
            full_page_loading: false,
            server_user: null,
            is_active: true,
        }
    },
    methods: {
        async onSubmit(values, actions) {
            const formData = new FormData()
            for (let key in values) {
                if (key === 'roles') {
                    formData.append(key, JSON.stringify(values[key]))
                } else {
                    formData.append(key, values[key] ?? '')
                }
            }
            this.loading = true
            try {
                const url = this.user
                    ? appRoutes.user_management.users.api +
                      '/' +
                      this.user.id +
                      '?_method=PUT'
                    : appRoutes.user_management.users.api
                const method = 'POST'
                const result = await api({
                    url,
                    method,
                    data: formData,
                })
                if (result.data.result) {
                    this.loading = false
                    this.q.notify({
                        message: this.$translate(result.data.message),
                        color: 'green',
                    })
                    this.handleModelClose()
                    this.generalStore.revalidate('users')
                    this.generalStore.setUpdateId(result.data?.update_id)
                } else {
                    this.loading = false
                    this.q.notify({
                        message: this.$translate(result.data.message),
                        color: 'red',
                    })
                }
            } catch (e) {
                this.loading = false
                errorHandler(e, actions.setErrors)
            }
        },
    },
    async mounted() {
        if (this.user) {
            this.full_page_loading = true
            try {
                const user = await api.get(
                    appRoutes.user_management.users.api + '/' + this.user.id,
                )
                this.server_user = user.data.data
                this.is_active = user.data.data.is_active
            } catch (e) {
                errorHandler(e, _, this.$router)
            } finally {
                this.full_page_loading = false
            }
        }
    },
})
</script>
