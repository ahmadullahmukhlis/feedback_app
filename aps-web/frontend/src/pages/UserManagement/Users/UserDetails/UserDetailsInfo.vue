<template>
    <div v-if="!data && !error" class="flex items-center justify-center h-64">
        <q-spinner size="2rem" color="primary" />
    </div>
    <div v-else-if="error" class="text-center text-red-500 py-12">
        {{ translate('Something went wrong') }}
    </div>
    <div v-else class="mt-5 grid grid-cols-2 gap-3 max-w-2xl mx-auto">
        <div
            class="relative w-[110px] h-[110px] overflow-hidden rounded-full shadow-lg col-span-2 mx-auto"
        >
            <q-img :src="data.image" width="100%" />
        </div>
        <q-input
            :model-value="data.first_name"
            :label="translate('First name')"
            disable
            outlined
            dense
        />
        <q-input
            :model-value="data.last_name"
            :label="translate('Last name')"
            disable
            outlined
            dense
        />
        <q-input
            :model-value="data.email"
            :label="translate('Email')"
            disable
            outlined
            dense
            class="col-span-2"
        />
        <div class="p-2 border rounded-lg border-gray-300 col-span-2">
            <div v-if="data.roles.length > 0">
                <p class="font-semibold">{{ translate('Roles') }}</p>
                <q-chip
                    v-for="role in data.roles"
                    :label="role.name"
                    :key="role.id"
                    outline
                    disable
                />
            </div>
            <p v-else class="text-center text-red-500 text-sm">
                {{ translate('No role is assigned for this user') }}
            </p>
        </div>
        <q-toggle
            :model-value="data.is_active"
            :label="translate('Is active')"
            disable
        />
    </div>
</template>
<script>
import { defineComponent } from 'vue'
import useSWRV from 'swrv'
import { appRoutes } from 'src/appRouter/routes'
import { useRoute, useRouter } from 'vue-router'
import { api } from 'boot/axios'
import { errorHandler } from 'src/lib/errorHandler'
import { useLanguageStore } from 'stores/languageStore'

export default defineComponent({
    name: 'UserDetailsInfo',
    setup() {
        const route = useRoute()
        const router = useRouter()
        const fetcher = url =>
            api
                .get(url)
                .then(res => res.data.data)
                .catch(err => errorHandler(err, '', router))
        const { data, error } = useSWRV(
            appRoutes.user_management.users.api + '/' + route.params.id,
            fetcher,
        )
        const { translate } = useLanguageStore()
        return {
            data,
            error,
            translate,
        }
    },
})
</script>
