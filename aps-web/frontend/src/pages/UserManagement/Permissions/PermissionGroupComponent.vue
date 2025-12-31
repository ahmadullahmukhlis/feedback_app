<template>
    <Container @drop="onDrop">
        <Draggable v-for="permission_group in data" :key="permission_group.id">
            <recursive-expansion-item
                :expand-separator="true"
                :label="permission_group.name"
                :permissions-title="permissionsTitle"
                :permissions="permission_group.permissions"
                :permission-group="permission_group"
                :children="permission_group.groups"
                :id="permission_group.id"
                :deleteGroup="deleteGroup"
                :icon="permission_group.icon"
                :handle-permission-group-model-open="
                    handlePermissionGroupModelOpen
                "
                :handleAddNewPermission="handleAddNewPermission"
                :handle-permission-delete="handlePermissionDelete"
                :copy-permission-key="copyPermissionKey"
            />
        </Draggable>
    </Container>
</template>

<script>
import RecursiveExpansionItem from 'pages/UserManagement/Permissions/RecursiveExpansionItem.vue'
import { useQuasar } from 'quasar'
import { api } from 'boot/axios'
import { errorHandler } from 'src/lib/errorHandler'
import { appRoutes } from 'src/appRouter/routes'
import { Container, Draggable } from 'vue3-smooth-dnd'
import { useLanguageStore } from 'stores/languageStore'

export default {
    components: {
        RecursiveExpansionItem,
        Container,
        Draggable,
    },
    setup() {
        const q = useQuasar()
        const { translate } = useLanguageStore()
        return {
            q,
            translate,
        }
    },
    props: [
        'data',
        'mutate',
        'handlePermissionGroupModelOpen',
        'handleAddNewPermission',
        'onDrop',
    ],
    methods: {
        async handlePermissionDelete(permissionId) {
            this.q
                .dialog({
                    title: 'Confirm',
                    message: this.translate('Are you sure you want to delete'),
                    cancel: true,
                })
                .onOk(async () => {
                    this.q.loading.show()
                    try {
                        const result = await api.delete(
                            appRoutes.user_management.permission.api +
                                '/' +
                                permissionId,
                        )
                        if (result.data.result) {
                            await this.mutate()
                            this.q.loading.hide()
                            this.q.notify({
                                message: this.translate(result.data.message),
                                color: 'green',
                            })
                        } else {
                            this.q.loading.hide()
                            this.q.notify({
                                message: this.translate(result.data.message),
                                color: 'red',
                            })
                        }
                    } catch (e) {
                        errorHandler(e)
                        this.q.loading.hide()
                    }
                })
            // Implement the delete permission logic
        },
        copyPermissionKey(event, key) {
            navigator.clipboard.writeText(key)
            this.q.notify({
                message: 'Text copied to clipboard',
                color: 'green',
            })
            // Implement the copy permission key logic
        },
        deleteGroup(id) {
            this.q
                .dialog({
                    title: 'Confirm',
                    message: 'Do you really want to delete',
                    persistent: true,
                    cancel: true,
                })
                .onOk(() => {
                    this.q.loading.show()
                    api.delete(`user-management/permission-groups/${id}`)
                        .then(async res => {
                            if (res.data.result) {
                                await this.mutate()
                                this.q.loading.hide()
                                this.q.notify({
                                    message: res.data.message,
                                    color: 'green',
                                })
                            } else {
                                this.q.notify({
                                    message: res.data.message,
                                    color: 'red',
                                })
                                this.q.loading.hide()
                            }
                        })
                        .catch(err => {
                            this.q.loading.hide()
                            errorHandler(err)
                        })
                })
            // Implement deleting group logic
        },
    },
}
</script>
