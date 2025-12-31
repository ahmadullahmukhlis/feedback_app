<template>
    <q-layout>
        <div class="p-4">
            <h2 class="text-xl font-semibold">
                {{ translate('Application configurations') }}
            </h2>
            <div class="my-4">
                <q-card>
                    <q-card-section>
                        <div class="flex items-center border-b">
                            <protected-component
                                v-for="link in [
                                    {
                                        permission: 'languages-access',
                                        to: '/configurations/languages',
                                        name: 'languages',
                                        icon: 'language',
                                        label: 'Languages',
                                    },
                                    {
                                        permission: 'backup-access',
                                        to: '/configurations/backups',
                                        name: 'backups',
                                        icon: 'settings_backup_restore',
                                        label: 'Backups',
                                    },
                                ]"
                                :permission-key="link.permission"
                                :key="link.to"
                            >
                                <router-link :to="link.to">
                                    <div
                                        class="flex items-center cursor-pointer py-1 px-3 pb-2"
                                        :class="
                                            $route.meta.active === link.name
                                                ? 'text-blue-500 border-b-2 border-blue-500'
                                                : ''
                                        "
                                    >
                                        <q-icon :name="link.icon" size="xs" />
                                        <p class="px-2">
                                            {{ translate(link.label) }}
                                        </p>
                                    </div>
                                </router-link>
                            </protected-component>
                        </div>
                        <div class="px-2 py-4">
                            <router-view />
                        </div>
                    </q-card-section>
                </q-card>
            </div>
        </div>
    </q-layout>
</template>
<script>
import { defineComponent } from 'vue'
import ProtectedComponent from 'components/ProtectedComponent.vue'
import { useLanguageStore } from 'stores/languageStore'

export default defineComponent({
    name: 'ConfigurationLayout',
    components: { ProtectedComponent },
    setup() {
        const { translate } = useLanguageStore()
        return {
            translate,
        }
    },
})
</script>
