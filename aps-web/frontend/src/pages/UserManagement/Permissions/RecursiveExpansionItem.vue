<template>
    <q-expansion-item
        :expand-separator="expandSeparator"
        :label="label"
        class="border-b"
        :icon="icon"
    >
        <q-card>
            <q-card-section>
                <div class="pl-4 border-l">
                    <p class="font-bold">Permissions</p>
                    <div class="px-5 py-3">
                        <p
                            v-if="permissions?.length < 1"
                            class="text-red-500 py-5 py-4 text-center"
                        >
                            There is no permission
                        </p>
                        <q-chip
                            v-else
                            v-for="permission in permissions"
                            :key="permission.id"
                            :label="permission.name"
                            clickable
                            removable
                            @remove="handlePermissionDelete(permission.id)"
                            @click="copyPermissionKey($event, permission.key)"
                        >
                            <q-tooltip>{{ permission.key }}</q-tooltip>
                        </q-chip>
                        <q-btn
                            size="sm"
                            dense
                            round
                            color="primary"
                            @click="handleAddNewPermission(id)"
                        >
                            <q-icon name="add" />
                            <q-tooltip>Add new permission</q-tooltip>
                        </q-btn>
                    </div>
                </div>
                <q-list
                    v-if="childes.length > 0"
                    bordered
                    class="rounded-borders my-5"
                    dense
                >
                    <Container @drop="onDrop">
                        <Draggable v-for="child in childes" :key="child.id">
                            <recursive-expansion-item
                                :id="child.id"
                                :expand-separator="expandSeparator"
                                :label="child.name"
                                :permissions-title="child.permissionsTitle"
                                :permissions="child.permissions"
                                :children="child.groups"
                                :deleteGroup="deleteGroup"
                                :handle-permission-group-model-open="
                                    handlePermissionGroupModelOpen
                                "
                                :icon="child.icon"
                                :handleAddNewPermission="handleAddNewPermission"
                                :permission-group="child"
                                :handle-permission-delete="
                                    handlePermissionDelete
                                "
                                :copy-permission-key="copyPermissionKey"
                            />
                        </Draggable>
                    </Container>
                </q-list>
                <div class="flex items-center space-x-1">
                    <q-btn
                        size="sm"
                        round
                        color="warning"
                        @click="
                            handlePermissionGroupModelOpen(
                                id,
                                'permission-group',
                                label,
                                icon,
                            )
                        "
                    >
                        <q-icon name="edit" />
                        <q-tooltip>Edit permission group name</q-tooltip>
                    </q-btn>
                    <q-btn size="sm" round color="red" @click="deleteGroup(id)">
                        <q-icon name="delete" />
                        <q-tooltip>Delete permission group</q-tooltip>
                    </q-btn>
                    <q-btn
                        size="sm"
                        round
                        color="primary"
                        @click="
                            handlePermissionGroupModelOpen(
                                id,
                                'permission-group',
                                null,
                                null,
                            )
                        "
                    >
                        <q-icon name="add" />
                        <q-tooltip>Add new permission group</q-tooltip>
                    </q-btn>
                </div>
            </q-card-section>
        </q-card>
    </q-expansion-item>
</template>

<script>
import { Container, Draggable } from 'vue3-smooth-dnd'
import { api } from 'boot/axios'
import { appRoutes } from 'src/appRouter/routes'
export default {
    components: { Container, Draggable },
    name: 'RecursiveExpansionItem',
    props: [
        'expandSeparator',
        'children',
        'permissionsTitle',
        'permissions',
        'id',
        'deleteGroup',
        'handlePermissionGroupModelOpen',
        'label',
        'icon',
        'handleAddNewPermission',
        'PermissionGroup',
        'handlePermissionDelete',
        'copyPermissionKey',
    ],
    methods: {
        applyDrag(arr, dragResult) {
            const { removedIndex, addedIndex, payload } = dragResult
            api.post(
                appRoutes.user_management.permission.permission_group_api +
                    '/update-order',
                {
                    parent_id: this.id,
                    removedIndex,
                    addedIndex,
                },
            )
            if (removedIndex === null && addedIndex === null) return arr
            const result = [...arr]
            let itemToAdd = payload

            if (removedIndex !== null) {
                itemToAdd = result.splice(removedIndex, 1)[0]
            }
            if (addedIndex !== null) {
                result.splice(addedIndex, 0, itemToAdd)
            }
            return result
        },
        onDrop(dropResult) {
            this.childes = this.applyDrag(this.childes, dropResult)
        },
    },
    data() {
        return {
            childes: [],
        }
    },
    mounted() {
        this.childes = this.children
    },
    watch: {
        children(newValue) {
            this.childes = newValue
        },
    },
}
</script>
