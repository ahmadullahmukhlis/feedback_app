<template>
    <div></div>
</template>
<script>
import { watch } from 'vue'

export default {
    props: ['formValues', 'onValuesChanges'],
    setup(props) {
        watch(props.formValues, newValue => {
            if (typeof props.onValuesChanges === 'function') {
                props.onValuesChanges(newValue)
            }
        })
    },
}
</script>
