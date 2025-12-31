<template>
    <q-input
        dense
        outlined
        :disable="disabled"
        :label="label"
        :model-value="modelValue"
        @update:model-value="updateValue"
        :error="!!errorMessage"
        :error-message="errorMessage?.replaceAll('_', ' ')"
        class="my-input"
    >
        <template v-slot:append>
            <q-icon name="colorize" class="cursor-pointer">
                <q-popup-proxy
                    cover
                    transition-show="scale"
                    transition-hide="scale"
                >
                    <q-color
                        v-model="internalValue"
                        format-model="hex"
                        @update:model-value="updateValue"
                    />
                </q-popup-proxy>
            </q-icon>
        </template>
    </q-input>
</template>

<script>
export default {
    props: {
        modelValue: {
            type: String,
            default: '#000000',
        },
        onChange: {
            type: Function,
            default: () => {},
        },
        label: {
            type: String,
            default: '',
        },
        errorMessage: {
            type: String,
            default: '',
        },
        disabled: {
            type: Boolean,
            default: false,
        },
    },

    data() {
        return {
            internalValue: this.modelValue,
        }
    },

    watch: {
        modelValue(newVal) {
            this.internalValue = newVal
        },
    },

    methods: {
        updateValue(val) {
            this.internalValue = val
            this.$emit('update:modelValue', val)
            this.onChange(val)
        },
    },
}
</script>
