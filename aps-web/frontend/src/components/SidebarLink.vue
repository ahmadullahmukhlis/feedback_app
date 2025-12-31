<template>
    <q-item
        :active="active"
        class="mr-2 rounded-br-full rounded-tr-full"
        active-class="bg-gradient-to-r from-teal-400 to-indigo-500 shadow-lg text-white "
        :to="to"
        clickable
        v-ripple
    >
        <q-item-section avatar>
            <q-icon :name="icon" />
        </q-item-section>
        <q-item-section class="-ml-4"> {{ name }} </q-item-section>
    </q-item>
</template>
<script>
import { defineComponent } from 'vue'
import { useGeneralStore } from 'stores/generalStore'

export default defineComponent({
    name: 'SidebarLink',
    props: ['active', 'name', 'icon', 'to'],
    setup() {
        const generalStore = useGeneralStore()
        return {
            generalStore,
        }
    },
})
</script>
