<template>
    <q-img v-if="imgSrc" :src="imgSrc" />
</template>

<script>
export default {
    props: {
        file: File,
    },
    data() {
        return {
            imgSrc: null,
        }
    },
    mounted() {
        this.fileToBase64(this.file).then(base64 => {
            this.imgSrc = base64
        })
    },
    methods: {
        fileToBase64(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader()
                reader.readAsDataURL(file)
                reader.onload = () => resolve(reader.result)
                reader.onerror = error => reject(error)
            })
        },
    },
}
</script>
