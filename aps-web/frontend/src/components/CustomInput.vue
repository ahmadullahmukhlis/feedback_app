<template>
    <input type="text" v-model="custom" />
</template>
<script setup>
import { ref, watch } from 'vue'

let custom = ref('')
watch(
    () => custom.value,
    value => {
        console.log(value)
    },
)
</script>
