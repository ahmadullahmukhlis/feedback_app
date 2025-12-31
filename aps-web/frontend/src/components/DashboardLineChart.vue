<template>
    <LineChart :data="data" />
</template>
<script>
import { defineComponent } from 'vue'
import { Line as LineChart } from 'vue-chartjs'
import {
    CategoryScale,
    LinearScale,
    Chart,
    PointElement,
    registerables,
} from 'chart.js'

export default defineComponent({
    name: 'DashboardLineChart',
    components: {
        LineChart,
    },
    setup() {
        Chart.register(
            CategoryScale,
            LinearScale,
            PointElement,
            ...registerables,
        ) // Register the PointElement here
    },
    data() {
        return {
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [
                    {
                        label: 'First dataset',
                        data: [33, 53, 85, 41, 44, 65],
                        fill: true,
                        backgroundColor: 'rgba(75,192,192,0.2)',
                        borderColor: 'rgba(75,192,192,1)',
                    },
                    {
                        label: 'Second dataset',
                        data: [33, 25, 35, 51, 54, 76],
                        fill: false,
                        borderColor: '#742774',
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            },
        }
    },
})
</script>
