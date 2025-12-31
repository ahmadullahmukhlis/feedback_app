<template>
    <protected-component permission-key="backup-access" is-page>
        <div class="flex items-center justify-between">
            <h2 class="text-xl">{{ $translate('List of backups') }}</h2>
            <protected-component permission-key="backup-run-backup">
                <q-btn :loading="loading" color="primary" @click="runBackup">
                    <template v-slot:loading>
                        <q-spinner-facebook />
                    </template>
                    {{ $translate('Run Backup') }}
                </q-btn>
            </protected-component>
        </div>
        <datatable-component
            :url="appRoutes.configurations.backup.index_api"
            table-name="backup_table"
            :datatable-actions="[
                {
                    icon: 'download',
                    tooltip: 'Download backups',
                    show_on_select: true,
                    permission_key: 'backup-download-backup',
                    onClick: data => {
                        downloadBackup(data.path)
                    },
                },
                {
                    icon: 'refresh',
                    tooltip: 'Restore backup',
                    show_on_select: true,
                    permission_key: 'backup-restore-backup',
                    onClick: data => {
                        restoreBackup(data.path)
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
                    name: 'user',
                    label: 'Backup by',
                    sortable: true,
                },
                {
                    name: 'name',
                    label: 'Backup name',
                    sortable: true,
                },
                {
                    name: 'path',
                    label: 'Path',
                    sortable: true,
                },
                {
                    name: 'size',
                    label: 'Size',
                    sortable: true,
                },
                {
                    name: 'created_at',
                    label: 'Backup created at',
                    sortable: true,
                },
            ]"
        />
    </protected-component>
</template>
<script>
import { defineComponent } from 'vue'
import { api } from 'boot/axios'
import { appRoutes } from 'src/appRouter/routes'
import DatatableComponent from 'components/DatatableComponent.vue'
import ProtectedComponent from 'components/ProtectedComponent.vue'

export default defineComponent({
    name: 'BackupsPage',
    components: { ProtectedComponent, DatatableComponent },
    setup() {
        return {
            appRoutes,
        }
    },
    data() {
        return {
            loading: false,
            loadingMessage: this.$translate(
                'Please wait restoring started and it will take some tikes',
            ),
        }
    },
    mounted() {
        this.$echo
            .private('applicationChannel')
            .listen('BackupRestoringEvent', message => {
                this.$q.loading.show({
                    message: message.message,
                })
            })
            .subscribe()

        this.$generalStore.setActivePage('user-management')
        this.$generalStore.setPageTitle('Backup')
    },
    methods: {
        async runBackup() {
            this.loading = true
            try {
                const result = await api.get(
                    this.appRoutes.configurations.backup.api,
                )
                if (result.data.result) {
                    this.$q.notify({
                        message: this.$translate(result.data.message),
                        color: 'green',
                    })
                }
            } catch (err) {
                this.$q.notify({
                    message: 'Something went wrong',
                    color: 'red',
                })
            } finally {
                this.loading = false
            }
        },
        downloadBackup(path) {
            window.open(path, '_blank')
        },
        restoreBackup(path) {
            this.$q
                .dialog({
                    title: this.$translate('Confirm'),
                    message: this.$translate(
                        'Are you sure you want to restore',
                    ),
                    cancel: true,
                })
                .onOk(async () => {
                    this.$q.loading.show({
                        message: this.loadingMessage,
                    })
                    try {
                        const result = await api.post(
                            appRoutes.configurations.backup.index_api,
                            {
                                path: path,
                            },
                        )
                        if (!result.data.result) {
                            this.$q.notify({
                                message: this.$translate(result.data.message),
                                color: 'red',
                            })
                        }
                    } catch (e) {
                    } finally {
                        this.$q.loading.hide()
                        this.$q.notify({
                            message: this.$translate(
                                'Backup restored successfully. Now the system uses ' +
                                    path +
                                    ' backup',
                            ),
                            color: 'green',
                        })
                        this.$generalStore.setNewUpdatedPushed(true)
                    }
                })
        },
    },
})
</script>
