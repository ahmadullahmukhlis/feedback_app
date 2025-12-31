<template>
    <q-card>
        <q-card-section>
            <div class="chart-container">
                <canvas ref="canvas"></canvas>
            </div>
        </q-card-section>
    </q-card>
</template>

<script>
import { defineComponent, ref, onMounted } from 'vue'
import {
    Chart,
    PolarAreaController,
    RadialLinearScale,
    ArcElement,
    Tooltip,
    Legend,
} from 'chart.js'
import ChartDataLabels from 'chartjs-plugin-datalabels'

Chart.register(
    PolarAreaController,
    RadialLinearScale,
    ArcElement,
    Tooltip,
    Legend,
    ChartDataLabels,
)

export default defineComponent({
    name: 'PolarAreaChart',
    setup() {
        const canvas = ref(null)

        onMounted(() => {
            const ctx = canvas.value.getContext('2d')

            const dataValues = [11, 16, 7, 3, 14]
            const labels = ['Red', 'Green', 'Yellow', 'Grey', 'Blue']

            const colors = [
                { start: '#ff9a9e', end: '#fad0c4' },
                { start: '#a1c4fd', end: '#c2e9fb' },
                { start: '#fbc2eb', end: '#a6c1ee' },
                { start: '#fddb92', end: '#d1fdff' },
                { start: '#84fab0', end: '#8fd3f4' },
            ]

            const gradients = colors.map(color => {
                const gradient = ctx.createLinearGradient(0, 0, 0, 400)
                gradient.addColorStop(0, color.start)
                gradient.addColorStop(1, color.end)
                return gradient
            })

            new Chart(ctx, {
                type: 'polarArea',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            data: dataValues,
                            backgroundColor: gradients,
                            borderWidth: 2,
                            borderColor: '#fff',
                            hoverBorderColor: '#333',
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        r: {
                            ticks: {
                                display: false,
                            },
                            grid: {
                                color: '#eee',
                            },
                        },
                    },
                    plugins: {
                        datalabels: {
                            color: '#fff',
                            font: {
                                weight: 'bold',
                                size: 14,
                            },
                            formatter: value => `${value}%`,
                        },
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#333',
                                font: {
                                    size: 14,
                                },
                                padding: 20,
                            },
                        },
                        tooltip: {
                            backgroundColor: '#fff',
                            titleColor: '#333',
                            bodyColor: '#666',
                            borderColor: '#ddd',
                            borderWidth: 1,
                            titleFont: {
                                size: 16,
                                weight: 'bold',
                            },
                            bodyFont: {
                                size: 14,
                            },
                            callbacks: {
                                label: context => {
                                    const label = context.label || ''
                                    const value = context.formattedValue || ''
                                    return `${label}: ${value}%`
                                },
                            },
                        },
                    },
                    animation: {
                        animateRotate: true,
                        animateScale: true,
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
