<template>
    <p class="text-red-600 text-center text-sm" v-if="error">
        {{ $translate('Something went wrong') }}
    </p>
    <div v-else>
        <q-select
            outlined
            dense
            :loading="!data && !error"
            :model-value="value"
            :options="options"
            use-input
            :disable="(!data && !error) || disabled"
            bottom-slots
            :label="label"
            :multiple="multiple"
            @filter="filterFn"
            :use-chips="multiple"
            options-dense
            input-debounce="0"
            :error="!!errorMessage"
            :error-message="$translate(errorMessage)"
            @update:model-value="updateValue"
        >
            <template
                v-if="createdAble && languageStore.direction == 'rtl'"
                #prepend
            >
                <q-btn
                    size="xs"
                    icon="add"
                    round
                    color="primary"
                    @click="handleAddClick(true)"
                />
            </template>
            <template
                v-else-if="createdAble && languageStore.direction == 'ltr'"
                #append
            >
                <q-btn
                    size="xs"
                    icon="add"
                    round
                    color="primary"
                    @click="handleAddClick(true)"
                />
            </template>
            <!--            <template v-slot:prepend v-if="icon">-->
            <!--                <q-icon :name="icon" />-->
            <!--            </template>-->
        </q-select>
    </div>
    <select-component-create-forms
        :handle-add-click="handleAddClick"
        :id="id"
        :modal="from"
    />
</template>
<script>
import { defineComponent, ref, watch } from 'vue'
import useSWRV from 'swrv'
import { api } from 'boot/axios'
import { errorHandler } from 'src/lib/errorHandler'
import { resolve } from 'src/lib/helpers'
import { useRouter } from 'vue-router/dist/vue-router'
import { useGeneralStore } from 'stores/generalStore'
import SelectComponentCreateForms from 'components/selectComponentCreateForms.vue'
import { useLanguageStore } from 'stores/languageStore'

export default defineComponent({
    name: 'SelectComponent',
    components: { SelectComponentCreateForms },
    props: [
        'url',
        'multiple',
        'defaultValue',
        'onChange',
        'label',
        'errorMessage',
        'optionLabel',
        'optionValue',
        'createdAble',
        'id',
        'fromResource',
        'clearAfterSelect',
        'onLoadingChanged',
        'disabled',
        'className',
        'icon',
        'findFromId',
        'onCreate',
    ],
    setup(prop) {
        const router = useRouter()
        const languageStore = useLanguageStore()
        const fetcher = url =>
            api
                .get(url)
                .then(res => (prop?.fromResource ? res.data.data : res.data))
                .catch(err => errorHandler(err, '', router))
        const { data: serverData, error, mutate } = useSWRV(prop.url, fetcher)
        const generalStore = useGeneralStore()
        let data = ref(undefined)
        let value = ref(prop.multiple ? [] : null)
        let created_id = ref(0)

        watch(
            () => generalStore.revalidateServerData,
            newValue => {
                if (newValue && newValue === prop.id) {
                    data.value = undefined
                    mutate().finally(() => {
                        created_id.value = generalStore.created_id
                        generalStore.revalidate(null, 0)
                    })
                }
            },
        )

        watch(serverData, newValue => {
            if (newValue) {
                data.value = newValue
            }
        })

        watch(created_id, newValue => {
            if (newValue !== 0) {
                const index = data?.value?.data.findIndex(
                    obj => obj.id === newValue,
                )
                if (index !== -1) {
                    const newValue2 = data?.value?.data[index]
                    const selectValue = {
                        label: resolve(prop.optionLabel, newValue2),
                        value: resolve(prop.optionValue, newValue2),
                        ...newValue2,
                    }
                    value.value = selectValue
                    if (prop.onChange) {
                        prop.onChange(selectValue)
                    }
                }
            }
        })

        watch(
            () => prop.defaultValue,
            newValue => {
                if (prop.findFromId) {
                    const index = data?.value?.data.findIndex(
                        obj => obj.id === newValue,
                    )
                    if (index !== -1) {
                        const newValue2 = data?.value?.data[index]
                        const selectValue = {
                            label: resolve(prop.optionLabel, newValue2),
                            value: resolve(prop.optionValue, newValue2),
                            ...newValue2,
                        }
                        value.value = selectValue
                        if (prop.onChange) {
                            prop.onChange(selectValue)
                        }
                    }
                    // data.value = undefined
                    generalStore.revalidate(prop.id)
                }
            },
        )

        return {
            serverData,
            error,
            data,
            value,
            languageStore,
        }
    },
    data() {
        return {
            options: [],
            from: false,
        }
    },
    methods: {
        filterFn(val, update) {
            if (val === '') {
                update(
                    () => {
                        this.options =
                            this.data.data?.map(item => ({
                                ...item,
                                label: resolve(this.optionLabel, item),
                                value: resolve(this.optionValue, item),
                            })) || []
                    },
                    ref => {
                        if (
                            val !== '' &&
                            ref.options.length > 0 &&
                            ref.getOptionIndex() === -1
                        ) {
                            ref.moveOptionSelection(1, true)
                            ref.toggleOption(ref.options[ref.optionIndex], true)
                        }
                    },
                )
            } else {
                const newValue = val.toLowerCase()
                const filteredOptions =
                    this.data.data?.filter(item =>
                        resolve(this.optionLabel, item)
                            .toLowerCase()
                            .includes(newValue),
                    ) || []
                update(
                    () => {
                        this.options = filteredOptions.map(item => ({
                            ...item,
                            label: resolve(this.optionLabel, item),
                            value: resolve(this.optionValue, item),
                        }))
                    },
                    ref => {
                        if (
                            val !== '' &&
                            ref.options.length > 0 &&
                            ref.getOptionIndex() === -1
                        ) {
                            ref.moveOptionSelection(1, true)
                            ref.toggleOption(ref.options[ref.optionIndex], true)
                        }
                    },
                )
            }
        },
        handleAddClick(model, data) {
            if (this.onCreate) {
                this.onCreate()
            } else {
                this.from = model
            }
        },
        updateValue(data) {
            this.value = data
            if (this.onChange) {
                this.onChange(data)
            }
            if (this.clearAfterSelect) {
                this.value = null
            }
        },
    },
    mounted() {
        if (!this.findFromId) {
            this.value = this.defaultValue
            if (this.serverData) {
                this.data = this.serverData
            }
        }
    },
    watch: {
        data(newValue) {
            if (newValue) {
                this.options = newValue.data?.map(item => ({
                    ...item,
                    label: resolve(this.optionLabel, item),
                    value: resolve(this.optionValue, item),
                }))
                if (this.onLoadingChanged) {
                    this.onLoadingChanged(true)
                }
            }
        },
        serverData(newValue) {
            if (this.findFromId) {
                const index = newValue?.data.findIndex(
                    obj => obj.id === this.defaultValue,
                )
                if (index !== -1) {
                    const value = newValue.data[index]
                    this.value = {
                        label: resolve(this.optionLabel, value),
                        value: resolve(this.optionValue, value),
                        ...value,
                    }
                    if (this.defaultValue && this.findFromId) {
                        this.onChange({
                            label: resolve(this.optionLabel, value),
                            value: resolve(this.optionValue, value),
                            ...value,
                        })
                    }
                }
            }
        },
    },
})
</script>
