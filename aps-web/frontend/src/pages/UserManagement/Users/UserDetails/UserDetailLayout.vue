<template>
    <div class="p-2 mt-3">
        <div class="flex items-center space-x-5 text-sm">
            <router-link
                :to="
                    appRoutes.user_management.users.details.path
                        .replace(':id', route.params.id)
                        .replace(':active', 'info')
                "
            >
                <div
                    class="flex items-center space-x-1 pb-2 rtl:mx-2"
                    :class="
                        route.params.active === 'info' &&
                        'border-blue-600 border-b-2 text-blue-600'
                    "
                >
                    <q-icon name="info" class="text-lg px-1" />
                    <div>{{ translate('User info') }}</div>
                </div>
            </router-link>
            <protected-component permission-key="log-activity-access">
                <router-link
                    :to="
                        appRoutes.user_management.users.details.path
                            .replace(':id', route.params.id)
                            .replace(':active', 'activity-log')
                    "
                >
                    <div
                        class="flex items-center pb-2 rtl:mx-2"
                        :class="
                            route.params.active === 'activity-log' &&
                            'border-blue-600 border-b-2 text-blue-600'
                        "
                    >
                        <q-icon name="directions_run" class="text-lg px-1" />
                        <div>{{ translate('User log activity') }}</div>
                    </div>
                </router-link>
            </protected-component>
        </div>
        <div class="mt-5">
            <slot />
        </div>
    </div>
</template>
<script>
import { defineComponent, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { appRoutes } from 'src/appRouter/routes'
import ProtectedComponent from 'components/ProtectedComponent.vue'
import { useLanguageStore } from 'stores/languageStore'

export default defineComponent({
    name: 'UserDetailsLayout',
    components: { ProtectedComponent },
    setup() {
        const route = useRoute()
        const router = useRouter()
        const { translate } = useLanguageStore()
        watch(
            () => route.params,
            newValue => {
                if (!['info', 'activity-log'].includes(newValue.active)) {
                    router.push({ path: '/404' })
                }
            },
        )
        return {
            route,
            router,
            appRoutes,
            translate,
        }
    },
})
</script>
