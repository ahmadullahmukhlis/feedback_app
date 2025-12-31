<template>
    <q-expansion-item
        :expand-separator="true"
        :label="label"
        class="border"
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
                        <q-toggle
                            v-else
                            v-for="permission in permissions"
                            :key="permission.id"
                            :label="permission.name"
                            :model-value="
                                role_permissions.includes(permission.id)
                            "
                            @click="handlePermissionClicked(permission.id)"
                        />
                    </div>
                    <q-list bordered class="rounded-borders" dense>
                        <role-permission-group-recursive-groups
                            v-for="group in groups"
                            :label="group.name"
                            :key="group.id"
                            :icon="group.icon"
                            :permissions="group.permissions"
                            :groups="group.groups"
                            :handlePermissionClicked="handlePermissionClicked"
                            :role_permissions="role_permissions"
                        />
                    </q-list>
                </div>
            </q-card-section>
        </q-card>
    </q-expansion-item>
</template>
<script>
import { defineComponent } from 'vue'

export default defineComponent({
    name: 'RolePermissionGroupRecursiveGroups',
    props: [
        'label',
        'icon',
        'permissions',
        'groups',
        'handlePermissionClicked',
        'role_permissions',
    ],
})
</script>
