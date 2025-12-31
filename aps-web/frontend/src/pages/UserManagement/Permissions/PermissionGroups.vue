<template>
    <div class="q-pa-md q-gutter-sm">
        <q-list bordered class="rounded-borders" dense>
            <PermissionGroupComponent
                :handle-permission-group-model-open="
                    handlePermissionGroupModelOpen
                "
                :data="data"
                :mutate="mutate"
                :handleAddNewPermission="handleAddNewPermission"
                :on-drop="onDrop"
            />
        </q-list>
    </div>
</template>
<script>
import { defineComponent, ref } from 'vue'
import { useQuasar } from 'quasar'
import PermissionGroupComponent from 'pages/UserManagement/Permissions/PermissionGroupComponent.vue'
export default defineComponent({
    components: { PermissionGroupComponent },
    props: [
        'data',
        'mutate',
        'handlePermissionGroupModelOpen',
        'handleAddNewPermission',
        'onDrop',
    ],
})
</script>
