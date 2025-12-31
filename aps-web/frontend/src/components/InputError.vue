<template>
    <p class="text-xs text-red-500 py-1 px-1" v-if="message">
        {{ message?.replaceAll('_', ' ') }}a
    </p>
</template>
<script>
import { defineComponent } from 'vue'

export default defineComponent({
    name: 'InputError',
    props: ['message'],
})
</script>
