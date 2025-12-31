<template>
    <datatable-component
        :url="
            appRoutes.user_management.activity_log.api.user_log.replace(
                ':id',
                route.params.id,
            )
        "
        table-name="user-log-activity"
        :datatable-actions="[
            {
                icon: 'visibility',
                tooltip: 'View options',
                show_on_select: true,
                permission_key: 'log-activity-view-details',
                onClick: data => {
                    handleModal(true, data)
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
    <activity-log-details
        v-if="log_details.model"
        :handle-modal="handleModal"
        :log="log_details.log"
    />
</template>
<script>
import { defineComponent } from 'vue'
import { useRoute, useRouter } from 'vue-router/dist/vue-router'
import { appRoutes } from 'src/appRouter/routes'
import DatatableComponent from 'components/DatatableComponent.vue'
import ActivityLogDetails from 'components/ActivityLogDetails.vue'

export default defineComponent({
    name: 'UserDetailActivityLogs',
    components: { ActivityLogDetails, DatatableComponent },
    setup() {
        const route = useRoute()
        const router = useRouter()
        return {
            route,
            router,
            appRoutes,
        }
    },
    data() {
        return {
            log_details: {
                model: false,
                log: null,
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
    },
})
</script>
