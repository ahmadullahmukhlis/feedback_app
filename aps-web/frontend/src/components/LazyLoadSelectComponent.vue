<template>
    <div class="mb-2">
        <div>
            <q-select
                v-model="model"
                use-input
                use-chips
                input-debounce="500"
                :label="label"
                multiple
                dense
                outlined
                :options="options"
                :option-label="optionLabel"
                @filter="filterFn"
                @filter-abort="abortFilterFn"
            >
                <template v-slot:no-option>
                    <q-item>
                        <q-item-section class="text-grey">
                            No results
                        </q-item-section>
                    </q-item>
                </template>
            </q-select>
        </div>
    </div>
</template>

<script>
import { ref, watch } from 'vue'
import { api } from 'boot/axios'
import { appRoutes } from 'src/appRouter/routes'
import { resolve } from 'src/lib/helpers'
import { errorHandler } from 'src/lib/errorHandler'

export default {
    props: {
        multiple: {
            type: Boolean,
            default: true,
        },
        optionLabel: {
            type: String,
            default: '',
        },
        url: {
            type: String,
            default: '',
        },
        onChange: {
            type: Function,
            default: undefined,
        },
        label: {
            type: String,
            default: '',
        },
        defaultValues: {
            type: Array,
            default: () => [],
        },
    },
    setup(props) {
        const options = ref([])
        const model = ref(null)
        watch(model, newValue => {
            if (props.onChange) {
                props.onChange(newValue)
            }
        })
        return {
            model,
            options,
            resolve,
            async filterFn(val, update, abort) {
                try {
                    const result = await api.get(
                        props.url +
                            '?for_api=true&search=' +
                            val.toLocaleString(),
                    )
                    update(() => {
                        if (val === '') {
                            options.value = []
                        } else {
                            options.value = result.data.data
                        }
                    })
                    setTimeout(() => {}, 500)
                } catch (err) {
                    errorHandler(err, '', this.$router)
                    abort()
                }
            },

            abortFilterFn() {
                // console.log('delayed filter aborted')
            },
        }
    },
    mounted() {
        if (this.multiple && this.defaultValues.length > 0) {
            this.model = this.defaultValues
        }
    },
}
</script>
