<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import BreezeAuthenticatedLayout from '@/Layouts/CRM/Authenticated.vue';
</script>

<template>
    <BreezeAuthenticatedLayout>
        <div class="grid grid-cols-1 lg:grid-cols-4">
            <div class="col-span-1">
                <label for="">Demo Chart</label>
                <canvas id="bar-chart"></canvas>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import Chart from 'chart.js/auto'

export default {
    mounted(){
        
let bar_chart_canvas    = document.getElementById('bar-chart')
let bar_chart           = bar_chart_canvas.getContext("2d");

const BarChart = new Chart(bar_chart, {
    type: 'bar',
    data: {
        labels: ['January', 'February', 'March', 'April'],
        datasets: [{
            data: [40, 20, 12,35],
        }]
    },
    options: {
        animation: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                enabled: true
            },
        }
    }
})

    }
}
</script>