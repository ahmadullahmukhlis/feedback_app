<template>
    <protected-component permission-key="user-management-access" is-page>
        <div class="bg-white p-3">
            <q-breadcrumbs>
                <q-breadcrumbs-el icon="home" to="/" />
                <q-breadcrumbs-el label="User Management" />
            </q-breadcrumbs>
        </div>
        <div>
            <UserManagementLayout>
                <div class="py-32 text-center">
                    <p class="text-xl md:text-2xl">
                        {{ $translate('Welcome to user management section') }}
                    </p>
                </div>
            </UserManagementLayout>
        </div>
    </protected-component>
</template>
<script>
import { defineComponent } from 'vue'
import { useGeneralStore } from 'stores/generalStore'
import UserManagementLayout from 'layouts/UserManagementLayout.vue'
import ProtectedComponent from 'components/ProtectedComponent.vue'

export default defineComponent({
    name: 'UserManagementIndex',
    components: { ProtectedComponent, UserManagementLayout },
    setup() {
        const generalStore = useGeneralStore()
        return {
            generalStore,
        }
    },
    mounted() {
        this.generalStore.setActivePage('user-management')
        this.generalStore.setPageTitle('User management')
    },
})
</script>
