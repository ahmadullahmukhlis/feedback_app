<template>
    <q-input
        outlined
        :disable="disabled"
        dense
        :label="label"
        :model-value="formattedValue"
        @update:model-value="handleInput"
        type="text"
        :error="!!errorMessage"
        :error-message="errorMessage?.replaceAll('_', ' ')"
    >
        <template v-slot:append>
            <span class="text-xs">{{ appendText }}</span>
        </template>
    </q-input>
</template>

<script>
export default {
    name: 'MoneyInput',
    props: {
        modelValue: {
            type: Number,
            default: 0,
        },
        onChange: {
            type: Function,
            default: () => {},
        },
        label: {
            type: String,
            default: () => '',
        },
        appendText: {
            type: String,
            default: () => '',
        },
        errorMessage: {
            type: String,
            default: () => '',
        },
        disabled: {
            type: Boolean,
            default: () => false,
        },
    },

    data() {
        return {
            formattedValue: this.formatNumber(this.modelValue),
        }
    },

    watch: {
        modelValue(newVal) {
            this.formattedValue = this.formatNumber(newVal)
        },
    },

    methods: {
        formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')
        },

        parseNumber(formattedNumber) {
            return parseInt(formattedNumber.replace(/,/g, ''), 10) || 0
        },

        handleInput(newValue) {
            // Remove all non-digit characters
            const cleaned = newValue.replace(/[^0-9]/g, '')
            const parsedNumber = this.parseNumber(cleaned)

            // Format the cleaned number
            this.formattedValue = this.formatNumber(parsedNumber)

            // Emit events
            this.$emit('update:modelValue', parsedNumber)
            this.onChange(Number(this.formattedValue.replace(/,/g, '')))
        },
    },
}
</script>
