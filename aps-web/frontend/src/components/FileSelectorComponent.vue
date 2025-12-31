<template>
    <q-file
        outlined
        :model-value="value"
        @update:model-value="file => formField.onChange(file)"
        dense
        :label="$translate(field.label)"
        :accept="`${field.accept}`"
        @rejected="onRejected"
        :error="!!errorMessage"
        :error-message="errorMessage"
        :hint="field?.hint"
        :clearable="field?.clearable ?? true"
        @change="event => onFileUpload(event.target.files)"
        :disable="disabled ?? false"
    >
        <template v-slot:prepend>
            <q-icon name="attach_file" />
        </template>
        <template v-slot:append>
            <q-btn
                v-if="
                    (field.accept?.includes('image') && value) ||
                    typeof field?.photo_url !== 'undefined'
                "
                flat
                round
                icon="visibility"
                size="sm"
            >
                <q-menu>
                    <q-card class="w-[400px]">
                        <q-card-section>
                            <template v-if="value">
                                <file-image-component :file="value" />
                            </template>
                            <template v-else>
                                <q-img
                                    :src="field?.photo_url"
                                    v-if="field?.photo_url"
                                    class="w-full"
                                />
                            </template>
                        </q-card-section>
                    </q-card>
                </q-menu>
            </q-btn>
            <q-btn
                v-if="typeof field?.download_url !== 'undefined'"
                icon="download"
                size="sm"
                round
                flat
                :href="field?.download_url"
                target="_blank"
            />
            <q-btn
                v-if="scanable && !disabled"
                icon="document_scanner"
                flat
                round
                size="sm"
                color="primary"
                @click="handleScan"
            />
        </template>
    </q-file>
</template>
<script>
import FileImageComponent from 'components/FileImageComponent.vue'
import 'src/assets/scanner.js'
import { base64ToFile, mbToBit } from 'src/lib/helpers'

export default {
    components: { FileImageComponent },
    props: [
        'value',
        'formField',
        'field',
        'errorMessage',
        'scanable',
        'disabled',
    ],
    methods: {
        onRejected(rejectedEntries) {
            this.$q.notify({
                type: 'negative',
                message: `${rejectedEntries.length} file(s) did not pass validation constraints`,
            })
        },
        handleScan() {
            scanner.scan(this.displayImagesOnPage, {
                use_asprise_dialog: false,
                output_settings: [
                    {
                        type: 'return-base64',
                        format: 'jpg',
                    },
                ],
            })
        },
        displayImagesOnPage(successful, mesg, response) {
            if (!successful) {
                console.error('Failed: ' + mesg)
                return
            }
            if (
                successful &&
                mesg != null &&
                mesg.toLowerCase().indexOf('user cancel') >= 0
            ) {
                return
            }
            let scannedImages = scanner.getScannedImages(response, true, false)
            const scanned_images = scannedImages?.map((item, index) => ({
                src: item.src,
                index,
            }))

            const files = scanned_images?.map((image, index) => {
                return base64ToFile(image?.src, `scan_image_${index}.png`)
            })
            this.formField.onChange(files[0])
        },
        onFileUpload(files) {
            const uploadedFiles = Object.entries(files)
            this.field.onChange(uploadedFiles?.map(file => file[1]))
        },
        handleRemove(file) {
            this.files = this.files.filter(
                fileObj => fileObj?.name !== file?.name,
            )
        },
        verifyExt(file) {
            const fileExtArray = file?.name?.split('.')
            const fileExt = fileExtArray[fileExtArray.length - 1]
            const allowedExt = this.options?.allowed_ext
            return allowedExt.includes(fileExt)
        },
        verifyFileSize(file) {
            if (this.options.max_size !== 0) {
                return file?.size <= mbToBit(this.options?.max_size)
            }
            return true
        },
    },
}
</script>
