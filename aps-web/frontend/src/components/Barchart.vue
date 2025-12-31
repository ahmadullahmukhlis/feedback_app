<template>
    <q-card>
        <q-card-section>
            <div class="chart-container h-![800px]">
                <canvas ref="canvas"></canvas>
            </div>
        </q-card-section>
    </q-card>
</template>

<script>
import { defineComponent, ref, onMounted } from 'vue'
import {
    Chart,
    BarController,
    BarElement,
    CategoryScale,
    LinearScale,
    Tooltip,
    Legend,
    Title,
} from 'chart.js'
import ChartDataLabels from 'chartjs-plugin-datalabels'

Chart.register(
    BarController,
    BarElement,
    CategoryScale,
    LinearScale,
    Tooltip,
    Legend,
    Title,
    ChartDataLabels,
)

export default defineComponent({
    name: 'BarChart',
    setup() {
        const canvas = ref(null)

        onMounted(() => {
            const ctx = canvas.value.getContext('2d')

            const gradientSales = ctx.createLinearGradient(0, 0, 0, 400)
            gradientSales.addColorStop(0, '#42b883')
            gradientSales.addColorStop(1, '#2c3e50')

            const gradientExpenses = ctx.createLinearGradient(0, 0, 0, 400)
            gradientExpenses.addColorStop(0, '#ff7e5f')
            gradientExpenses.addColorStop(1, '#feb47b')

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                        'January',
                        'February',
                        'March',
                        'April',
                        'May',
                        'June',
                        'July',
                    ],
                    datasets: [
                        {
                            label: 'Sales',
                            data: [40, 55, 75, 81, 56, 55, 40],
                            backgroundColor: gradientSales,
                            borderRadius: 15,
                            barPercentage: 0.9,
                        },
                        {
                            label: 'Expenses',
                            data: [30, 45, 65, 70, 46, 45, 30],
                            backgroundColor: gradientExpenses,
                            borderRadius: 15,
                            barPercentage: 0.9,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        datalabels: {
                            anchor: 'end',
                            align: 'end',
                            color: '#fff',
                            font: {
                                weight: 'bold',
                                size: 12,
                            },
                        },
                        legend: {
                            labels: {
                                font: {
                                    size: 14,
                                },
                            },
                        },
                        title: {
                            display: true,
                            text: 'Company Performance',
                            font: {
                                size: 24,
                            },
                            color: '#333',
                        },
                        tooltip: {
                            backgroundColor: '#fff',
                            titleColor: '#333',
                            bodyColor: '#666',
                            borderColor: '#ddd',
                            borderWidth: 1,
                            titleFont: {
                                size: 14,
                            },
                            bodyFont: {
                                size: 12,
                            },
                        },
                    },
                    scales: {
                        x: {
                            ticks: {
                                font: {
                                    size: 12,
                                },
                                color: '#666',
                            },
                            grid: {
                                display: false,
                            },
                        },
                        y: {
                            ticks: {
                                font: {
                                    size: 12,
                                },
                                color: '#666',
                            },
                            grid: {
                                color: '#eee',
                            },
                        },
                    },
                },
            })
        })

        return {
            canvas,
        }
    },
})
</script>

<style scoped>
.chart-container {
    width: 100%;
    height: 400px;
    margin: 0 auto;
}
</style>
