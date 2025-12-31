<template>
    <protected-component permission-key="activity-log-access" is-pages>
        <div class="bg-white p-3">
            <q-breadcrumbs>
                <q-breadcrumbs-el icon="home" to="/" />
                <q-breadcrumbs-el
                    :label="translate('User management')"
                    to="/user-management"
                />
                <q-breadcrumbs-el :label="translate('Activity logs')" />
            </q-breadcrumbs>
        </div>
        <div>
            <user-management-layout active="activity-log">
                <div class="md:px-2 py-4">
                    <div class="flex items-center justify-between">
                        <p class="text-lg font-semibold">
                            {{ translate('Users activity log') }}
                        </p>
                    </div>
                    <div>
                        <datatable-component
                            :url="
                                appRoutes.user_management.activity_log.api.index
                            "
                            table-name="user-log-activity"
                            :filters="filter.filters"
                            :datatable-actions="[
                                {
                                    icon: 'visibility',
                                    tooltip: 'View options',
                                    show_on_select: true,
                                    permission_key: 'activity-log-view-details',
                                    onClick: data => {
                                        handleModal(true, data)
                                    },
                                },
                                {
                                    icon: 'filter_alt',
                                    tooltip: 'Filter',
                                    forAll: true,
                                    onClick: () => {
                                        handleFilterModel(true, filter.filters)
                                    },
                                },
                            ]"
                            :columns="[
                                {
                                    name: 'id',
                                    label: 'ID',
                                    sortable: true,
                                },
                                {
                                    name: 'causer.first_name',
                                    label: 'Performed By',
                                },
                                {
                                    label: 'Module class',
                                    name: 'subject_type',
                                },
                                {
                                    label: 'Event',
                                    name: 'description',
                                    sortable: true,
                                },
                                {
                                    label: 'Performed on',
                                    name: 'created_at',
                                    sortable: true,
                                },
                            ]"
                        />
                    </div>
                </div>
            </user-management-layout>
        </div>
        <activity-log-details
            v-if="log_details.model"
            :handle-modal="handleModal"
            :log="log_details.log"
        />
        <activity-log-filter-model
            v-if="filter.model"
            :filters="filter.filters"
            :handle-modal="handleFilterModel"
        />
    </protected-component>
</template>
<script>
import ProtectedComponent from 'components/ProtectedComponent.vue'
import UserManagementLayout from 'layouts/UserManagementLayout.vue'
import DatatableComponent from 'components/DatatableComponent.vue'
import { appRoutes } from 'src/appRouter/routes'
import ActivityLogDetails from 'components/ActivityLogDetails.vue'
import ActivityLogFilterModel from 'pages/UserManagement/ActivityLog/ActivityLogFilterModel.vue'
import { useGeneralStore } from 'stores/generalStore'
import { useLanguageStore } from 'stores/languageStore'
export default {
    components: {
        ActivityLogFilterModel,
        ActivityLogDetails,
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
    data() {
        return {
            log_details: {
                model: false,
                log: null,
            },
            filter: {
                model: false,
                filters: {},
            },
        }
    },
    methods: {
        handleModal(open, log) {
            this.log_details = {
                model: open,
                log: log,
            }
        },
        handleFilterModel(open, filters) {
            this.filter = {
                model: open,
                filters,
            }
        },
    },
    mounted() {
        this.generalStore.setPageTitle('Activity logs')
        this.generalStore.setActivePage('user-management')
    },
}
</script>
