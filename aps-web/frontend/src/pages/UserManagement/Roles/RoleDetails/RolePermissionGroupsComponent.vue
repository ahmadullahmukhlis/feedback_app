<template>
    <role-permission-group-recursive-groups
        v-for="group in data.permission_groups"
        :key="group.id"
        :label="group.name"
        :icon="group.icon"
        :permissions="group.permissions"
        :groups="group.groups"
        :handlePermissionClicked="handlePermissionClicked"
        :role_permissions="role_permissions"
    />
</template>
<script>
import { defineComponent } from 'vue'
import RolePermissionGroupRecursiveGroups from 'pages/UserManagement/Roles/RoleDetails/RolePermissionGroupRecursiveGroups.vue'

export default defineComponent({
    name: 'RolePermissionGroups',
    components: { RolePermissionGroupRecursiveGroups },
    props: ['data', 'role_permissions', 'handlePermissionClicked'],
})
</script>
