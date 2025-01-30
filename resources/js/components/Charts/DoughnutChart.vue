<script setup>
import { Doughnut } from "vue-chartjs";
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement)

const chartData = {
    labels: [ 'January', 'February', 'March' ],
    datasets: [
        {
            data: [40, 20, 12],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'
            ],
        }
    ]
}

const chartOptions = {
    responsive: true
}
</script>

<template>
    <Doughnut
        id="my-chart-id"
        :options="chartOptions"
        :data="chartData"
    />
</template>
