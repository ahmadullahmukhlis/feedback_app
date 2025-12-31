<template>
    <q-dialog :model-value="true" persistent>
        <q-card class="md:min-w-[800px]">
            <q-card-section>
                <h2 class="text-lg">
                    {{ $translate('Activity Log Details') }}
                </h2>
            </q-card-section>
            <q-card-section>
                <server-data
                    :from-resource="false"
                    :url="
                        appRoutes.user_management.activity_log.api.get_log.replace(
                            ':log',
                            log.id,
                        )
                    "
                    v-slot="{ data }"
                >
                    <div class="flex flex-col space-y-1">
                        <p class="text-sm">
                            <span class="font-semibold">Action type:</span>
                            {{ data?.event }}
                        </p>
                        <p class="text-sm">
                            <span class="font-semibold"> Effected on: </span>
                            {{ data?.log_name }}
                        </p>
                        <p class="text-sm">
                            <span class="font-semibold"> Date: </span>
                            {{
                                dayjs(data?.created_at).format(
                                    'YYYY-MM-DD hh:mm:ss A',
                                )
                            }}
                        </p>
                        <br />
                    </div>
                    <div v-if="data.event === 'created'">
                        <div class="overflow-x-auto">
                            <table class="w-full !text-center">
                                <thead class="border-b bg-gray-100">
                                    <tr>
                                        <th class="py-1">Field name</th>
                                        <th class="py-1">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(key, index) in Object.keys(
                                            data.properties.attributes,
                                        )"
                                        :key="index"
                                        class="border-b"
                                    >
                                        <td>{{ key.replaceAll('_', ' ') }}</td>
                                        <td>
                                            <span
                                                v-if="
                                                    key === 'created_at' ||
                                                    key === 'updated_at'
                                                "
                                            >
                                                {{
                                                    dayjs(
                                                        data.properties
                                                            .attributes[key],
                                                    ).format(
                                                        'YYYY-MM-DD hh:mm:ss A',
                                                    )
                                                }}
                                            </span>
                                            <span v-else>
                                                {{
                                                    data.properties.attributes[
                                                        key
                                                    ]
                                                }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div v-if="data.event === 'updated'">
                        <table class="border text-center w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-2">Field name</th>
                                    <th class="py-2">Old Value</th>
                                    <th class="py-2">New Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(key, index) in Object.keys(
                                        data.properties.attributes,
                                    )"
                                    :key="index"
                                    class="border-b"
                                    :class="index % 2 !== 0 && 'bg-gray-100'"
                                >
                                    <td class="w-[20%] border-r py-1">
                                        {{ key }}
                                    </td>
                                    <td
                                        class="w-[40%] border-r py-1 bg-red-500 text-white"
                                    >
                                        {{ data.properties.old[key] }}
                                    </td>
                                    <td
                                        class="w-[40%] border-r py-1 bg-green-500 text-white"
                                    >
                                        {{ data.properties.attributes[key] }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-if="data.event === 'deleted'">
                        <table class="w-full !text-center">
                            <thead class="border-b bg-gray-100">
                                <tr>
                                    <th class="py-1">Field name</th>
                                    <th class="py-1">Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(key, index) in Object.keys(
                                        data.properties.old,
                                    )"
                                    :key="index"
                                    class="border-b"
                                >
                                    <td>
                                        {{ key }}
                                    </td>
                                    <td>
                                        {{ data.properties.old[key] }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div></div>
                    </div>
                    <q-card-actions align="right">
                        <q-btn
                            v-if="data.event === 'deleted'"
                            class="my-5"
                            icon-right="refresh"
                            color="green"
                            @click="handleRestore"
                        >
                            Restore
                        </q-btn>
                        <q-btn color="red" @click="handleModal(false, null)">
                            Close
                        </q-btn>
                    </q-card-actions>
                </server-data>
            </q-card-section>
        </q-card>
    </q-dialog>
</template>

<script>
import { defineComponent } from 'vue'
import ServerData from 'components/ServerData.vue'
import { appRoutes } from 'src/appRouter/routes'
import dayjs from 'dayjs'
import { useQuasar } from 'quasar'
import { api } from 'boot/axios'
import { errorHandler } from 'src/lib/errorHandler'
import { useGeneralStore } from 'stores/generalStore'

export default defineComponent({
    name: 'ActivityLogDetails',
    components: { ServerData },
    props: ['handleModal', 'log'],
    setup() {
        const generalStore = useGeneralStore()
        return {
            appRoutes,
            dayjs,
            generalStore,
        }
    },
    methods: {
        handleRestore() {
            this.$q
                .dialog({
                    title: 'Confirm',
                    message: 'Are you sure you want to restore',
                    persistent: true,
                    cancel: true,
                })
                .onOk(async () => {
                    this.$q.loading.show()
                    try {
                        const result = await api.post(
                            appRoutes.user_management.activity_log.api.restore_log.replaceAll(
                                ':log',
                                this.log.id,
                            ),
                        )
                        if (result.data.result) {
                            this.$q.notify({
                                message: this.$translate(result.data.message),
                                color: 'green',
                            })
                            this.generalStore.revalidate('user-log-activity')
                            this.handleModal(false, null)
                        } else {
                            this.$q.notify({
                                message: this.$translate(result.data.message),
                                color: 'red',
                            })
                        }
                    } catch (e) {
                        errorHandler(e, '', this.$router)
                    } finally {
                        this.$q.loading.hide()
                    }
                })
        },
    },
})
</script>
