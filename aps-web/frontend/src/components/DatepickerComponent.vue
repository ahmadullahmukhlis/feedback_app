<template>
    <div>
        <q-input
            class="w-full"
            dense
            v-model="date"
            mask="date"
            :rules="['date']"
            :label="$translate(label)"
            outlined
            :error="!!errorMessage"
            :error-message="$translate(errorMessage)"
        >
            <template v-slot:append>
                <q-icon name="event" class="cursor-pointer">
                    <q-popup-proxy
                        cover
                        transition-show="scale"
                        transition-hide="scale"
                    >
                        <q-date v-model="date" today-btn>
                            <div class="row items-center justify-end">
                                <q-btn
                                    v-close-popup
                                    label="Close"
                                    color="primary"
                                    flat
                                />
                            </div>
                        </q-date>
                    </q-popup-proxy>
                </q-icon>
            </template>
        </q-input>
    </div>
</template>

<script>
export default {
    props: {
        value: String,
        label: String,
        onChange: Function,
        errorMessage: String,
    },
    data() {
        return {
            date: this.value,
        }
    },
    watch: {
        date(newValue) {
            this.date = newValue
            if (this.onChange) {
                this.onChange(newValue)
            }
        },
    },
}
</script>
