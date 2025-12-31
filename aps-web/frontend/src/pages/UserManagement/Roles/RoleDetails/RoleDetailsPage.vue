<template>
    <protected-component permission-key="roles-view-details" is-page>
        <div class="bg-white p-3">
            <q-breadcrumbs>
                <q-breadcrumbs-el icon="home" to="/" />
                <q-breadcrumbs-el
                    label="User management"
                    to="/user-management"
                />
                <q-breadcrumbs-el label="Roles" to="/user-management/roles" />
                <q-breadcrumbs-el
                    :label="$route.params.name + ' role details'"
                />
            </q-breadcrumbs>
        </div>
        <div>
            <user-management-layout active="roles">
                <div class="py-4">
                    <p class="text-lg font-semibold">
                        {{ $route.params.name }} role details
                    </p>
                    <div v-if="!data" class="flex justify-center py-12">
                        <q-spinner size="3rem" color="primary" />
                    </div>
                    <div v-else class="py-1">
                        <h3 class="font-semibold">
                            {{
                                $translate(
                                    'All assigned permissions to this role',
                                )
                            }}
                        </h3>
                        <div class="px-4 pb-4 border-l">
                            <q-chip
                                v-for="(permission, index) in data.role
                                    .permissions"
                                :key="permission.permission_id"
                                size="small"
                                :label="
                                    index +
                                    '. ' +
                                    permission.permission.key
                                        .split('-')
                                        .map(
                                            text =>
                                                text[0].toUpperCase() +
                                                text.slice(1) +
                                                ' ',
                                        )
                                "
                            />
                        </div>
                        <ValidationForm
                            :validation-schema="schema"
                            @submit="handleRoleDetailsSave"
                        >
                            <Field
                                name="name"
                                :value="data.role.name"
                                v-slot="{ errorMessage, value, field }"
                            >
                                <q-input
                                    outlined
                                    :model-value="value"
                                    v-bind="field"
                                    :error="!!errorMessage"
                                    :error-message="$translate(errorMessage)"
                                    label="Role name"
                                    dense
                                />
                            </Field>
                            <div class="text-xs pb-3">
                                <p>
                                    Created by:
                                    <span class="px-2 bg-gray-200 rounded-full">
                                        {{
                                            data.role.created_by_user.first_name
                                        }}
                                    </span>
                                </p>
                                <p>
                                    Updated by:
                                    <span class="px-2 bg-gray-200 rounded-full">
                                        {{
                                            data.role.created_by_user.first_name
                                        }}
                                    </span>
                                </p>
                            </div>
                            <role-permission-groups
                                :data="data"
                                :handle-permission-clicked="
                                    handlePermissionClicked
                                "
                                :role_permissions="role_permissions"
                            />
                            <div class="my-2">
                                <q-btn
                                    type="submit"
                                    size="small"
                                    color="primary"
                                    outline
                                    icon-right="save"
                                    :loading="loading"
                                    :label="$translate('Save')"
                                />
                            </div>
                        </ValidationForm>
                    </div>
                </div>
            </user-management-layout>
        </div>
    </protected-component>
</template>
<script>
import UserManagementLayout from 'layouts/UserManagementLayout.vue'
import { api } from 'boot/axios'
import useSWRV from 'swrv'
import { appRoutes } from 'src/appRouter/routes'
import { useRoute } from 'vue-router'
import { errorHandler } from 'src/lib/errorHandler'
import RolePermissionGroups from 'pages/UserManagement/Roles/RoleDetails/RolePermissionGroupsComponent.vue'
import { Form as ValidationForm, Field } from 'vee-validate'
import * as yup from 'yup'
import ProtectedComponent from 'components/ProtectedComponent.vue'

export default {
    components: {
        ProtectedComponent,
        RolePermissionGroups,
        UserManagementLayout,
        ValidationForm,
        Field,
    },
    setup() {
        const fetcher = url =>
            api
                .get(url)
                .then(res => res.data)
                .catch(err => errorHandler(err))
        const route = useRoute()
        const { data, mutate } = useSWRV(
            appRoutes.user_management.roles.role_details.api.replace(
                '{id}',
                route.params.id,
            ),
            fetcher,
        )
        const schema = yup.object({
            name: yup.string().required('This section is required'),
        })
        return {
            data,
            schema,
            mutate,
        }
    },
    data() {
        return {
            role_permissions: [],
            role_name: null,
            loading: false,
        }
    },
    methods: {
        handlePermissionClicked(id) {
            if (this.role_permissions.includes(id)) {
                this.role_permissions = this.role_permissions.filter(
                    obj => obj !== id,
                )
            } else {
                this.role_permissions.push(id)
            }
        },
        async handleRoleDetailsSave(values, actions) {
            this.loading = true
            try {
                const result = await api.put(
                    appRoutes.user_management.roles.role_details.api.replace(
                        '{id}',
                        this.$route.params.id,
                    ),
                    {
                        name: values.name,
                        role_permissions: this.role_permissions,
                    },
                )
                this.loading = false
                if (result.data.result) {
                    this.$q.notify({
                        message: this.$translate(result.data.message),
                        color: 'green',
                    })
                    this.mutate()
                }
            } catch (e) {
                this.loading = false
                this.$q.notify({
                    message: 'Something went wrong',
                    color: 'red',
                })
                errorHandler(e, actions.setErrors)
            }
        },
    },
    watch: {
        data(newValue) {
            if (newValue) {
                this.role_permissions = newValue.role.role_permissions?.map(
                    id => id,
                )
            }
        },
    },
}
</script>
