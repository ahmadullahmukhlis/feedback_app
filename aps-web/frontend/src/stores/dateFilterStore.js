import { defineStore } from 'pinia/dist/pinia'
export const useDateFilterStore = defineStore('UseDateFilterStore', {
    state: () => ({
        filter: {
            label: 'Today',
            value: 'TODAY',
        },
        date_range: {
            from: null,
            to: null,
        },
    }),
    actions: {
        updateDateRangeFilter(from_date, to_date) {
            this.date_range = {
                from: from_date,
                to: to_date,
            }
        },
        updateFilter(value) {
            this.filter = value
        },
    },
})
