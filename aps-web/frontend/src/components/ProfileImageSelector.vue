<template>
    <div
        @click="handleClick"
        class="w-24 h-24 border mx-auto rounded-full shadow cursor-pointer overflow-hidden"
        :class="`${errorMessage && '!border-red-500'} ${
            typeof className !== 'undefined' ? '-mt-0' : '-mt-10'
        }`"
    >
        <img class="w-full" :src="profile" v-if="profile" />
    </div>
    <p class="text-red-500 text-center text-xs">{{ errorMessage }}</p>
    <input
        type="file"
        accept="image/*"
        @change="handleChange"
        ref="inputRef"
        class="hidden"
    />
</template>
<script>
import { defineComponent, ref } from 'vue'

export default defineComponent({
    name: 'ProfileImageSelector',
    props: ['onChange', 'errorMessage', 'default', 'className'],
    setup() {
        const inputRef = ref(null)
        return {
            inputRef,
        }
    },
    data() {
        return {
            profile: null,
        }
    },
    methods: {
        handleClick() {
            this.inputRef.click()
        },
        handleChange(e) {
            const reader = new FileReader()
            if (e.target.files[0]) {
                reader.readAsDataURL(e.target.files[0])
            }
            reader.onload = readerEvent => {
                this.profile = readerEvent.target.result
            }
            this.onChange(e.target.files[0])
        },
    },
    mounted() {
        if (this.default) {
            this.profile = this.default
        }
    },
})
</script>
