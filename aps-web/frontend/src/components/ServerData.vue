<template>
    <div
        v-if="!data && !error && fetchData"
        class="flex items-center justify-center"
        :class="!disableDefaultHeigth && ' h-32'"
    >
        <q-spinner size="2rem" color="primary" />
    </div>
    <div v-else-if="error && fetchData" class="py-12 text-center text-red-500">
        <span v-if="error?.response?.data?.message">{{
            error?.response?.data?.message
        }}</span>
        <span v-else> {{ $translate('Something went wrong') }} </span>
    </div>
    <div v-else>
        <p
            v-if="data?.length < 1 && !ignoreNull && fetchData"
            class="py-12 text-center text-red-500"
        >
            No data found
        </p>
        <q-intersection v-else transition="fade">
            <slot :data="data" />
        </q-intersection>
    </div>
</template>
<script>
import { defineComponent, ref, watch } from 'vue'
import useSWRV from 'swrv'
import { api } from 'boot/axios'
import { errorHandler } from 'src/lib/errorHandler'
import { useRouter } from 'vue-router'
import { useGeneralStore } from 'stores/generalStore'

export default defineComponent({
    name: 'ServerData',
    props: {
        url: {
            type: String,
            default: '',
        },
        fromResource: {
            type: Boolean,
            default: true,
        },
        disableDefaultHeigth: {
            type: Boolean,
            default: false,
        },
        id: {
            type: String,
            default: null,
        },
        ignoreNull: {
            type: Boolean,
            default: false,
        },
        fetchData: {
            type: Boolean,
            default: true,
        },
        onDataReceived: {
            type: Function,
            default: undefined,
        },
    },
    setup(prop) {
        const router = useRouter()
        const fetcher = url =>
            api
                .get(url)
                .then(res => (prop.fromResource ? res.data.data : res.data))
                .catch(err => errorHandler(err, '', router))
        const {
            data: serverData,
            error,
            mutate,
        } = useSWRV(prop.url, prop.fetchData && fetcher)
        const generalStore = useGeneralStore()
        let data = ref(undefined)
        watch(
            () => generalStore.revalidateServerData,
            newValue => {
                if (newValue && newValue === prop.id) {
                    data.value = undefined
                    mutate().finally(() => {
                        generalStore.revalidate(null)
                    })
                }
            },
        )

        watch(serverData, newValue => {
            if (newValue) {
                data.value = newValue
                if (prop.onDataReceived) {
                    prop.onDataReceived(newValue)
                }
            }
        })

        return {
            serverData,
            error,
            data,
        }
    },
    mounted() {
        if (this.serverData) {
            this.data = this.serverData
        }
    },
})
</script>
