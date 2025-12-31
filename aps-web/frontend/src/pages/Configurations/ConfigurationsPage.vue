<template>
    <div class="flex items-center justify-center text-center w-full h-[60vh]">
        <h3 class="text-xl font-semibold">Configuration page</h3>
    </div>
</template>
<script>
import { defineComponent } from 'vue'
import { useGeneralStore } from 'stores/generalStore'

export default defineComponent({
    name: 'ConfigurationPage',
    setup() {
        const generalStore = useGeneralStore()
        return {
            generalStore,
        }
    },
    mounted() {
        this.generalStore.setPageTitle('Configurations')
        this.generalStore.setActivePage('configurations')
    },
})
</script>
