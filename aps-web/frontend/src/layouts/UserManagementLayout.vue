<template>
    <q-intersection transition="jump-right">
        <q-page>
            <div class="p-2 md:p-4">
                <h2 class="text-lg font-bold">
                    {{ $translate('User management') }}
                </h2>
                <q-card>
                    <q-card-section class="mt-2">
                        <div class="flex items-center border-b">
                            <protected-component
                                v-for="link in [
                                    {
                                        path: '/user-management/users',
                                        permission_key: 'users-access',
                                        name: 'users',
                                        label: translate('Users'),
                                        icon: 'people',
                                    },
                                    {
                                        path: '/user-management/activity-log',
                                        permission_key: 'activity-log-access',
                                        name: 'activity-log',
                                        label: translate('Activity Log'),
                                        icon: 'directions_run',
                                    },
                                    {
                                        path: '/user-management/login-log',
                                        permission_key: 'login-log-access',
                                        name: 'login-log',
                                        label: translate('Login log'),
                                        icon: 'article',
                                    },
                                    {
                                        path: '/user-management/roles',
                                        permission_key: 'roles-access',
                                        name: 'roles',
                                        label: translate('Roles'),
                                        icon: 'settings_accessibility',
                                    },
                                ]"
                                :permission-key="link.permission_key"
                                :key="link.name"
                            >
                                <router-link :to="link.path">
                                    <div
                                        class="flex items-center cursor-pointer py-1 px-3 pb-2"
                                        :class="
                                            active === link.name
                                                ? 'text-blue-500 border-b-2 border-blue-500'
                                                : ''
                                        "
                                    >
                                        <q-icon
                                            class="px-1"
                                            :name="link.icon"
                                            size="xs"
                                        />
                                        <p>{{ link.label }}</p>
                                    </div>
                                </router-link>
                            </protected-component>
                            <protected-component :only-admin="true">
                                <router-link to="/user-management/permissions">
                                    <div
                                        class="flex items-center space-x-1 cursor-pointer py-1 px-3 pb-2"
                                        :class="
                                            active === 'permissions'
                                                ? 'text-blue-500 border-b-2 border-blue-500'
                                                : ''
                                        "
                                    >
                                        <q-icon name="lock_open" size="xs" />
                                        <p>{{ translate('Permission') }}</p>
                                    </div>
                                </router-link>
                            </protected-component>
                        </div>
                        <slot />
                    </q-card-section>
                </q-card>
            </div>
        </q-page>
    </q-intersection>
</template>
<script>
import { defineComponent } from 'vue'
import ProtectedComponent from 'components/ProtectedComponent.vue'
import { useLanguageStore } from 'stores/languageStore'

export default defineComponent({
    name: 'UserManagementLayout',
    components: { ProtectedComponent },
    props: ['active'],
    setup() {
        const { translate } = useLanguageStore()
        return {
            translate,
        }
    },
})
</script>
