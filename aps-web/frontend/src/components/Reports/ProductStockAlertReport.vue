<template>
    <div>
        <p class="text-lg font-semibold">{{ $translate('Stock Alert') }}</p>
        <q-markup-table class="mt-5">
            <q-inner-loading :showing="loading" />
            <thead class="bg-gray-200">
                <tr>
                    <th>
                        {{ $translate('Code') }}
                    </th>
                    <th>
                        {{ $translate('Product') }}
                    </th>
                    <th>
                        {{ $translate('Warehouse') }}
                    </th>
                    <th>
                        {{ $translate('Quantity') }}
                    </th>
                    <th>
                        {{ $translate('Alert Quantity') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="data.length < 1">
                    <td colspan="5">
                        <p class="text-center text-red-500">
                            {{ $translate('No record found') }}
                        </p>
                    </td>
                </tr>
                <tr v-else v-for="pro in data" :key="pro.id">
                    <td>{{ pro.product.code }}</td>
                    <td>{{ pro.product.name }}</td>
                    <td>{{ pro.warehouse.name }}</td>
                    <td>{{ pro.product.qty }}</td>
                    <td>{{ pro.alert_qty }}</td>
                </tr>
            </tbody>
        </q-markup-table>
    </div>
</template>
<script>
import { appRoutes } from 'src/appRouter/routes'
import { api } from 'boot/axios'

export default {
    data() {
        return {
            loading: false,
            data: [],
        }
    },
    methods: {
        async fetchData() {
            this.loading = true
            try {
                const result = await api.get(
                    appRoutes.reporting.api.replace('{report}', 'stock_alerts'),
                )
                this.data = result.data.data
            } catch (err) {
            } finally {
                this.loading = false
            }
        },
    },
    mounted() {
        this.fetchData()
    },
}
</script>
