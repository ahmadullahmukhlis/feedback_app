<template>
    <q-dialog :model-value="true">
        <q-card style="width: 400px">
            <q-card-section>
                <h2 class="text-xl font-bold">Filter activity log</h2>
            </q-card-section>
            <form>
                <q-card-section>
                    <p class="text-lg font-bold">
                        Users logged in from {{ model?.from }} - {{ model?.to }}
                    </p>
                    <q-date today-btn v-model="model" range class="w-full" />
                </q-card-section>
                <q-card-actions align="right">
                    <q-btn
                        outline
                        size="small"
                        color="primary"
                        icon-right="filter_alt"
                        @click="onSave"
                    >
                        Filter
                    </q-btn>
                    <q-btn
                        outline
                        size="small"
                        icon-right="close"
                        color="red"
                        @click="generalStore.setFilter(false, {})"
                    >
                        Close
                    </q-btn>
                </q-card-actions>
            </form>
        </q-card>
    </q-dialog>
</template>
<script>
import { appRoutes } from 'src/appRouter/routes'
import { useGeneralStore } from 'stores/generalStore'
export default {
    name: 'LoginLogFilterModel',
    setup() {
        const generalStore = useGeneralStore()
        return {
            appRoutes,
            generalStore,
        }
    },
    data() {
        return {
            model: {
                from: '',
                to: '',
            },
        }
    },
    methods: {
        onSave() {
            this.generalStore.setFilter(false, {
                from: this.model.from,
                to: this.model.to,
            })
        },
    },
    mounted() {
        if (Object.entries(this.generalStore.filters.options).length > 0) {
            this.model = {
                from: this.generalStore.filters.options.from,
                to: this.generalStore.filters.options.to,
            }
        }
    },
}
</script>
