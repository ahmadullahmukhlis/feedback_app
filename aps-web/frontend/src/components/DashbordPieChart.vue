<template>
    <Pie :data="data" />
</template>
<script>
import { ArcElement, Tooltip, Legend, Chart } from 'chart.js'
import { Pie } from 'vue-chartjs'
import ApexCharts from 'apexcharts'
import { ref } from 'vue'
export default {
    name: 'DashboardPieChart',
    components: {
        Pie,
    },
    setup() {
        const data = ref({
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [
                {
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                    ],
                    borderWidth: 1,
                },
            ],
        })
        const loading = ref(true)
        Chart.register(ArcElement, Tooltip, Legend)
        return {
            data,
            loading,
        }
    },
}
</script>
