<template>
    <q-ajax-bar ref="bar" position="top" color="#a00" size="4px" skip-hijack />
    <router-view />
</template>
<script>
import { useRouter } from 'vue-router/dist/vue-router'
import { ref } from 'vue'

export default {
    setup() {
        const router = useRouter()
        const bar = ref(null)
        router.beforeEach((to, from, next) => {
            const barRef = bar.value
            barRef.start()
            next()
        })
        router.afterEach(() => {
            const barRef = bar.value
            barRef.stop()
        })
        return {
            bar,
        }
    },
}
</script>
