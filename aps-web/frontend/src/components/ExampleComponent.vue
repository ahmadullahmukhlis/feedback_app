<template>
    <vue-apex-charts type="area" :options="chartOptions" :series="series" />
</template>
<script>
import VueApexCharts from 'vue3-apexcharts'
import { ref } from 'vue'
import { api } from 'boot/axios'
import { appRoutes } from 'src/appRouter/routes'

export default {
    components: { VueApexCharts },
    setup() {
        const loading = ref(true)
        const series = ref([
            {
                name: 'series1',
                data: [31, 40, 28, 51, 42, 109, 100],
            },
            {
                name: 'series2',
                data: [11, 32, 45, 32, 34, 52, 41],
            },
            {
                name: 'series3',
                data: [21, 42, 55, 42, 44, 62, 51],
            },
        ])

        const chartOptions = ref({
            labels: [2, 3, 4, 4, 5, 5],
            chart: {
                height: 350,
                type: 'area',
            },
            xaxis: {},
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: 'smooth',
            },
        })
        return {
            series,
            chartOptions,
            loading,
        }
    },
}
</script>
