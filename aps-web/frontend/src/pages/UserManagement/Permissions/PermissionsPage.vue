<template>
    <div class="bg-white p-3">
        <q-breadcrumbs>
            <q-breadcrumbs-el icon="home" to="/" />
            <q-breadcrumbs-el label="User management" to="/user-management" />
            <q-breadcrumbs-el label="Permissions" />
        </q-breadcrumbs>
    </div>
    <div class="p-4">
        <UserManagementLayout active="permissions">
            <div class="flex justify-between mb-4 items-center mt-5">
                <p class="text-lg font-semibold px-4">
                    List of all permission groups
                </p>
                <q-btn
                    @click="
                        handlePermissionGroupModelOpen(
                            0,
                            'permission-group',
                            null,
                        )
                    "
                    color="primary"
                    icon-right="add"
                    size="small"
                >
                    Add new permission group
                </q-btn>
            </div>
            <div
                v-if="!data && !error"
                class="p-12 flex items-center justify-center"
            >
                <q-spinner size="2rem" color="primary" />
            </div>
            <p
                v-else-if="data.length < 1"
                class="text-red-600 text-center py-12"
            >
                No permission group found
            </p>
            <PermissionGroup
                :handle-permission-group-model-open="
                    handlePermissionGroupModelOpen
                "
                v-else
                :mutate="mutate"
                :data="data"
                :handleAddNewPermission="handleAddNewPermission"
                :on-drop="onDrop"
            />
        </UserManagementLayout>
    </div>
    <PermissionGroupModel
        :parent-id="permissionGroupParentId"
        :show-model="permissionGroupModel"
        :handle-close-model="handleModelClose"
        :model-type="type"
        :name="name"
        :icon="icon"
    />
    <PermissionFormModel
        :permission-group-id="permissionGroupParentId"
        :permission-model="showPermissionModelForm"
        :handle-model-close="handleModelClose"
        :mutate="mutate"
    />
</template>
<script>
import { defineComponent } from 'vue'
import UserManagementLayout from 'layouts/UserManagementLayout.vue'
import { useGeneralStore } from 'stores/generalStore'
import PermissionGroup from 'pages/UserManagement/Permissions/PermissionGroups.vue'
import { api } from 'boot/axios'
import useSWRV from 'swrv'
import PermissionGroupModel from 'pages/UserManagement/Permissions/PermissionGroupModel.vue'
import PermissionFormModel from 'pages/UserManagement/Permissions/PermissionFormModel.vue'
import { appRoutes } from 'src/appRouter/routes'
import { useRouter } from 'vue-router'

export default defineComponent({
    name: 'PermissionsPage',
    components: {
        PermissionFormModel,
        PermissionGroup,
        UserManagementLayout,
        PermissionGroupModel,
    },
    setup() {
        const generalStore = useGeneralStore()
        const router = useRouter()
        const fetchPermissionGroups = url => {
            return api.get(url).then(res => res.data.data)
        }
        const { data, error, mutate } = useSWRV(
            '/user-management/permission-groups',
            fetchPermissionGroups,
        )
        return {
            generalStore,
            data,
            error,
            mutate,
        }
    },
    mounted() {
        this.generalStore.setPageTitle('Permissions page')
        this.generalStore.setActivePage('user-management')
    },
    data() {
        return {
            permissionGroupParentId: 0,
            permissionGroupModel: false,
            type: 'permissionGroup',
            name: null,
            showPermissionModelForm: false,
            icon: null,
        }
    },
    methods: {
        handlePermissionGroupModelOpen(parentId, type, name, icon) {
            this.permissionGroupParentId = parentId
            this.permissionGroupModel = true
            this.type = type
            this.name = name
            this.icon = icon
        },
        handleModelClose() {
            this.permissionGroupParentId = 0
            this.permissionGroupModel = false
            this.showPermissionModelForm = false
            this.mutate()
        },
        handleAddNewPermission(permissionGroup) {
            this.permissionGroupParentId = permissionGroup
            this.showPermissionModelForm = true
        },
        applyDrag(arr, dragResult) {
            const { removedIndex, addedIndex, payload } = dragResult
            api.post(
                appRoutes.user_management.permission.permission_group_api +
                    '/update-order',
                {
                    parent_id: 0,
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
            this.data = this.applyDrag(this.data, dropResult)
        },
    },
})
</script>
