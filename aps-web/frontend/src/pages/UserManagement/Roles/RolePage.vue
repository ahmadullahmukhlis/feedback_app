<template>
    <div class="bg-white p-3">
        <q-breadcrumbs>
            <q-breadcrumbs-el icon="home" to="/" />
            <q-breadcrumbs-el
                :label="translate('User management')"
                to="/user-management"
            />
            <q-breadcrumbs-el :label="translate('Roles')" />
        </q-breadcrumbs>
    </div>
    <div>
        <UserManagementLayout active="roles">
            <div class="md:px-3 py-4">
                <div class="flex items-center justify-between">
                    <p class="font-semibold text-lg">
                        {{ translate('Roles list') }}
                    </p>
                    <protected-component permission-key="roles-create">
                        <q-btn
                            color="primary"
                            size="small"
                            icon-right="add"
                            @click="handleModelOpen"
                        >
                            {{ translate('Add new role') }}
                        </q-btn>
                    </protected-component>
                </div>
                <div class="py-12 flex justify-center" v-if="!data">
                    <q-spinner size="3rem" color="primary" />
                </div>
                <div v-else>
                    <p
                        v-if="data.length < 1"
                        class="text-red-500 text-center py-12"
                    >
                        {{ translate('Not role found') }}
                    </p>
                    <div v-else class="py-3">
                        <q-chip
                            v-for="role in data"
                            :key="role.id"
                            :label="translate(role.name)"
                            :removable="authStore.isAllowed('roles-delete')"
                            :clickable="
                                authStore.isAllowed('roles-view-details')
                            "
                            @remove="handleDeleteRole(role.id)"
                            @click="handleRoleClick(role.id, role.name)"
                        />
                    </div>
                </div>
            </div>
        </UserManagementLayout>
    </div>
    <role-form-model
        :mutate="mutate"
        :model="model"
        :handle-model-close="handleModelClose"
    />
</template>
<script>
import { defineComponent } from 'vue'
import UserManagementLayout from 'layouts/UserManagementLayout.vue'
import { useGeneralStore } from 'stores/generalStore'
import ProtectedComponent from 'components/ProtectedComponent.vue'
import RoleFormModel from 'pages/UserManagement/Roles/RoleFormModel.vue'
import useSWRV from 'swrv'
import { api } from 'boot/axios'
import { appRoutes } from 'src/appRouter/routes'
import { useQuasar } from 'quasar'
import { errorHandler } from 'src/lib/errorHandler'
import { useRoute } from 'vue-router/dist/vue-router'
import { useAuthStore } from 'stores/UserManagementStores/AuthStore'
import { useLanguageStore } from 'stores/languageStore'

export default defineComponent({
    name: 'RolePage',
    components: { RoleFormModel, ProtectedComponent, UserManagementLayout },
    setup() {
        const router = useRoute()
        const generalStore = useGeneralStore()
        const authStore = useAuthStore()
        const fetcher = url =>
            api
                .get(url)
                .then(res => res.data.data)
                .catch(err => errorHandler(err, '', router))
        const { data, mutate } = useSWRV(
            appRoutes.user_management.roles.api,
            fetcher,
        )
        const { translate } = useLanguageStore()
        return {
            authStore,
            generalStore,
            data,
            mutate,
            router,
            translate,
        }
    },
    mounted() {
        this.generalStore.setPageTitle('Roles page')
        this.generalStore.setActivePage('user-management')
    },
    data() {
        return {
            model: false,
        }
    },
    methods: {
        handleModelOpen() {
            this.model = true
        },
        handleModelClose() {
            this.model = false
        },
        handleDeleteRole(id) {
            this.$q
                .dialog({
                    title: 'Confirm',
                    message: 'Are you sure you want to delete',
                    cancel: true,
                })
                .onOk(async () => {
                    this.$q.loading.show()
                    try {
                        const result = await api.delete(
                            appRoutes.user_management.roles.api + '/' + id,
                        )
                        if (result.data.result) {
                            await this.mutate()
                            this.$q.loading.hide()
                            this.$q.notify({
                                message: this.$translate(result.data.message),
                                color: 'green',
                            })
                        } else {
                            this.$q.loading.hide()
                            this.$q.notify({
                                message: this.$translate(result.data.message),
                                color: 'red',
                            })
                        }
                    } catch (e) {
                        errorHandler(e)
                        this.$q.loading.hide()
                    }
                })
        },
        handleRoleClick(id, name) {
            this.$router.push(
                appRoutes.user_management.roles.role_details.path
                    .replace('{id}', id)
                    .replace('{name}', name),
            )
        },
    },
})
</script>
