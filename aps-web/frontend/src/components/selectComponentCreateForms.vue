<template>
    <div>Test</div>
</template>
<script>
export default {
    props: ['id', 'modal', 'handleAddClick', 'from'],
    components: {},
    methods: {
        handleClose() {
            this.handleAddClick(false, null)
        },
    },
}
</script>
