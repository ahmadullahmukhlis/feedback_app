<template>
    <protected-component permission-key="users-access" is-pages>
        <div class="bg-white p-3">
            <q-breadcrumbs>
                <q-breadcrumbs-el icon="home" to="/" />
                <q-breadcrumbs-el
                    :label="translate('User management')"
                    to="/user-management"
                />
                <q-breadcrumbs-el :label="translate('Users')" />
            </q-breadcrumbs>
        </div>
        <div>
            <user-management-layout active="login-log">
                <div class="md:px-2 py-4">
                    <div class="flex items-center justify-between">
                        <p class="text-lg font-semibold">
                            {{ translate('Login log') }}
                        </p>
                    </div>
                    <div>
                        <datatable-component
                            :url="appRoutes.user_management.login_log.api"
                            :datatable-actions="[
                                {
                                    icon: 'filter_alt',
                                    tooltip: 'Filter',
                                    forAll: true,
                                    onClick: () => {
                                        generalStore.setFilter(
                                            true,
                                            generalStore.filters.options,
                                        )
                                    },
                                },
                            ]"
                            :columns="[
                                {
                                    label: 'ID',
                                    name: 'id',
                                    sortable: true,
                                },
                                {
                                    label: 'Username',
                                    name: 'email',
                                    sortable: true,
                                },
                                {
                                    label: 'Attempted IP',
                                    name: 'ip_address',
                                    sortable: true,
                                },
                                {
                                    label: 'Was login succeed',
                                    name: 'login_succeed',
                                    sortable: true,
                                },
                                {
                                    label: 'Message',
                                    name: 'message',
                                    sortable: true,
                                },
                            ]"
                        />
                    </div>
                </div>
            </user-management-layout>
        </div>
        <login-log-filter-model v-if="generalStore.filters.model" />
    </protected-component>
</template>
<script>
import ProtectedComponent from 'components/ProtectedComponent.vue'
import UserManagementLayout from 'layouts/UserManagementLayout.vue'
import DatatableComponent from 'components/DatatableComponent.vue'
import { appRoutes } from 'src/appRouter/routes'
import { useGeneralStore } from 'stores/generalStore'
import LoginLogFilterModel from 'pages/UserManagement/LoginLog/LoginLogFilterModel.vue'
import { useLanguageStore } from 'stores/languageStore'
export default {
    components: {
        LoginLogFilterModel,
        DatatableComponent,
        UserManagementLayout,
        ProtectedComponent,
    },
    setup() {
        const generalStore = useGeneralStore()
        const { translate } = useLanguageStore()
        return {
            appRoutes,
            generalStore,
            translate,
        }
    },
    mounted() {
        this.generalStore.setActivePage('user-management')
        this.generalStore.setPageTitle('Login logs')
    },
}
</script>
