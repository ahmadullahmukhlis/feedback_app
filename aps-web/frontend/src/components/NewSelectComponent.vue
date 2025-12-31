<template>
    <p v-if="error && !loading" class="text-center text-red-500 text-xs">
        {{ error }}
    </p>
    <q-select
        v-else
        v-model="value"
        :option-label="optionLabel"
        :option-value="optionValue"
        :options="options"
        :loading="loading"
        dense
        outlined
        :label="label"
        :input-debounce="serverSearchAble ? 300 : 0"
        :multiple="multiple ?? false"
        :use-chips="multiple ?? false"
        :error-message="errorMessage?.replaceAll('_', ' ')"
        :error="!!errorMessage"
        use-input
        @filter="filterFn"
        :disable="disabled"
        options-dense
        @update:model-value="
            data => {
                if (data === null && this.multiple) {
                    onChange([])
                } else {
                    onChange(data)
                }
            }
        "
        :clearable="true"
    >
        <template v-slot:option="scope">
            <q-item v-bind="scope.itemProps">
                <q-item-section>
                    <q-item-label>
                        {{ $translate(resolve(optionLabel, scope.opt)) }}
                    </q-item-label>
                </q-item-section>
            </q-item>
        </template>
        <template v-slot:no-option>
            <q-item>
                <q-item-section class="text-grey"> No results </q-item-section>
            </q-item>
        </template>
        <template v-slot:append>
            <q-btn
                size="sm"
                round
                flat
                icon="add"
                @click="handleCreatableClick"
                v-if="createdAble"
            />
        </template>
        <template v-slot:selected-item="scope">
            <q-chip
                :label="$translate(resolve(optionLabel, scope.opt))"
                v-if="multiple"
                removable
                @remove="scope.removeAtIndex(scope.index)"
            />
            <template v-else>
                {{ $translate(resolve(optionLabel, scope.opt)) }}
            </template>
        </template>
    </q-select>
</template>
<script>
import { defineComponent, ref, watch } from 'vue'
import { resolve } from 'src/lib/helpers'
import { useGeneralStore } from 'stores/generalStore'

export default defineComponent({
    name: 'NewSelectComponent',
    setup() {
        const generalStore = useGeneralStore()
        const revalidateValue = ref(null)
        watch(
            () => generalStore.table,
            newValue => (revalidateValue.value = newValue),
        )
        const setRevalidateValue = value => {
            revalidateValue.value = value
            generalStore.revalidate(value)
        }
        return {
            revalidateValue,
            setRevalidateValue,
            resolve,
        }
    },
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
        'selectId',
        'serverSearchAble',
        'handleCreatable',
        'selectType',
    ],
    data() {
        return {
            loading: true,
            options: [],
            error: null,
            value: null,
            options_copy: [],
            creatable_form: false,
        }
    },
    methods: {
        async fetchData(query = null) {
            this.loading = true
            try {
                let api = this.url
                if (query !== null) {
                    api += '&query=' + query
                }
                if (this.selectType) {
                    api += `${
                        query ? '&' : `${this.url.includes('?') ? '&' : '?'}`
                    }type=${this.selectType}`
                }
                const result = await this.$api.get(api)
                if (this.fromResource) {
                    this.options = result.data.data
                    this.options_copy = result.data.data
                } else {
                    this.options = result.data
                    this.options_copy = result.data
                }
                if (this.defaultValue) {
                    this.searchDefaultValue(this.defaultValue)
                }
            } catch (err) {
                this.error = err?.response?.data?.message
            } finally {
                this.loading = false
            }
        },
        filterFn(val, update) {
            if (val === '') {
                update(() => {
                    this.options = this.options_copy
                })
                if (this.serverSearchAble) {
                    this.fetchData(null)
                }
                return
            } else {
                const newValue = val.toLowerCase()
                const filteredOptions =
                    this.options_copy?.filter(item =>
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
                if (this.serverSearchAble) {
                    this.fetchData(newValue)
                }
            }
        },
        handleCreatableClick() {
            if (this.selectType) {
                this.creatable_form = true
            } else {
                this.handleCreatable()
            }
        },
        handleCreatableForm(model, created_id, revalidate) {
            this.creatable_form = model
            if (revalidate) {
                this.fetchData().finally(() => {
                    this.searchDefaultValue(created_id)
                })
            }
        },
        searchDefaultValue(value) {
            if (this.multiple) {
                const findSearchIndexes = []
                value.map(item => {
                    const findSearchIndex = this.options.findIndex(
                        obj =>
                            resolve(this.optionValue, obj) ===
                            resolve(this.optionValue, item),
                    )
                    if (findSearchIndex !== -1) {
                        findSearchIndexes.push(findSearchIndex)
                    }
                })
                const findOptions = []
                if (findSearchIndexes.length > 0) {
                    findSearchIndexes.map(itemIndex => {
                        findOptions.push(this.options[itemIndex])
                    })
                }
                if (findOptions.length > 0) {
                    this.value = findOptions
                    this.onChange(findOptions)
                }
            } else {
                const findSearchIndex = this.options.findIndex(
                    obj => resolve(this.optionValue, obj) === value,
                )
                if (findSearchIndex !== -1) {
                    this.value = this.options[findSearchIndex]
                    this.onChange(this.options[findSearchIndex])
                }
            }
        },
    },
    mounted() {
        this.fetchData()
    },
    watch: {
        revalidateValue(newValue) {
            if (newValue) {
                this.fetchData().finally(() => {
                    this.setRevalidateValue(null)
                })
            }
        },
        url(newValue, oldData) {
            if (newValue !== oldData) {
                this.fetchData()
            }
        },
    },
})
</script>
