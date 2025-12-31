<template>
    <div>
        <q-select
            class="flex-1"
            :options="
                reportDateRangeOptions?.map(item => ({
                    label: $translate(item?.label),
                    value: item?.value,
                }))
            "
            outlined
            dense
            v-model="filterDateStore.filter"
            option-value="value"
            option-label="label"
            options-dense
            options-selected-class="bg-[dodgerblue] text-white"
        />
    </div>
    <div class="mt-2" v-if="filterDateStore.filter.value === 'CUSTOM'">
        <q-input
            :error="false"
            outlined
            dense
            :label="$translate('Custom date')"
            :model-value="
                filterDateStore.date_range?.from &&
                filterDateStore.date_range?.to
                    ? `${filterDateStore.date_range?.from} - ${filterDateStore.date_range?.to}`
                    : null
            "
        >
            <template v-slot:append>
                <q-icon name="event" class="cursor-pointer">
                    <q-popup-proxy>
                        <q-date
                            v-model="filterDateStore.date_range"
                            range
                            today-btn
                        />
                    </q-popup-proxy>
                </q-icon>
                <q-icon
                    name="close"
                    class="cursor-pointer"
                    @click="filterDateStore.updateDateRangeFilter(null, null)"
                ></q-icon>
            </template>
        </q-input>
    </div>
</template>
<script>
import { reportDateRangeOptions } from 'src/lib/helpers'
import { useDateFilterStore } from 'stores/dateFilterStore'

export default {
    setup() {
        const filterDateStore = useDateFilterStore()
        return {
            reportDateRangeOptions,
            filterDateStore,
        }
    },
    methods: {},
}
</script>
