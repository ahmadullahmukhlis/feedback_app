<template>
    <q-dialog :model-value="true">
        <q-card style="width: 500px">
            <q-card-section>
                <h2 class="text-xl font-bold">
                    {{ translate('Filter users') }}
                </h2>
            </q-card-section>
            <form>
                <q-card-section>
                    <p class="text-lg font-bold">
                        {{ translate('User created date') }}
                    </p>
                    <q-date today-btn v-model="model" range class="w-full" />
                </q-card-section>
                <q-card-actions align="right">
                    <q-btn
                        outline
                        size="small"
                        color="primary"
                        icon-right="filter_alt"
                        @click="handleClose(true)"
                    >
                        {{ translate('Filter records') }}
                    </q-btn>
                    <q-btn
                        outline
                        size="small"
                        icon-right="close"
                        color="red"
                        @click="handleClose(false)"
                    >
                        {{ translate('Close') }}
                    </q-btn>
                </q-card-actions>
            </form>
        </q-card>
    </q-dialog>
</template>
<script>
import { defineComponent } from 'vue'
import { useLanguageStore } from 'stores/languageStore'

export default defineComponent({
    name: 'UserFilterModel',
    props: ['handleCloseModel', 'filters'],
    data() {
        const { translate } = useLanguageStore()
        return {
            model: {
                from: null,
                to: null,
            },
            translate,
        }
    },
    methods: {
        handleClose(filter = true) {
            if (filter) {
                this.handleCloseModel(false, this.model)
            } else {
                this.handleCloseModel(false, null)
            }
        },
    },
    mounted() {
        if (this.filters) {
            this.model = this.filters
        }
    },
})
</script>
