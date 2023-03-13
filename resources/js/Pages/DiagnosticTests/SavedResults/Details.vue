<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Diagnostic Test" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="mx-auto">
                <div class="align-middle inline-block min-w-full px-2">
                    <div class="flex justify-between mb-4">
                        <div class="flex space-x-2">
                            <div class="flex relative text-gray-400 focus-within:text-gray-600">
                                <SearchIcon class="text-gray-600 h-4 w-4 fill-current pointer-events-none absolute top-1/4 left-3" :style="'top:30%'"></SearchIcon>
                                <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:ring-0 focus:border-gray-300 appearance-none  block pl-10"
                                        type="text" v-model="params.search" placeholder="Search">
                            </div>
                        </div>
                    </div>
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-300">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/14">#</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/14">Level</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Result</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Date Taken</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-if="!$page.props.answer_record.data.length">
                                    <td class="text-center" colspan="10">
                                        <div class="p-3">
                                            No Record Found! 
                                        </div>
                                    </td>
                                </tr> 
                                <tr class="hover:bg-gray-200" v-for="(result, index) in $page.props.answer_record.data" :key="result.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-700">{{ index + 1 }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ result.dt_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ result.total_correct_answers + '/' + result.total_answers }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ moment(result.created_at).format('DD/MM/YYYY') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center space-x-2">
                                            <BreezeButton buttonType="blue" class="py-1 px-2" @click="!processing ? viewChart(index, result.dt_id, result.total_answers, result.chart_type) : ''">View Chart</BreezeButton>
                                            <BreezeButton buttonType="gray" class="py-1 px-2" @click="!processing ? viewAnswers(index++) : ''">Answer Records</BreezeButton>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <Pagination :page_data="$page.props.answer_record" :params="'&result_id='+$page.props.result_id"></Pagination>
                        <Modal :showModal="show_chart" @hideModal="show_chart = false">
                            <template v-slot:header>
                                <h3 class="text-gray-900 text-xl font-semibold">                
                                    Chart
                                </h3>                
                            </template>
                            <template v-slot:content>
                                <div class="p-4 space-y-4">
                                    <div class="flex justify-center">
                                        <canvas id="scatter-chart" class="hidden m-0"></canvas>
                                        <canvas id="bar-chart" class="hidden m-0"></canvas>
                                    </div>
                                </div>
                            </template>
                            <template v-slot:footer>
                                <div class="flex justify-end space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                                    <BreezeButton buttonType="info" @click="show_chart = false">Close</BreezeButton>
                                </div>
                            </template>
                        </Modal>
                        <Modal :showModal="show_answers" modalType="lg" @hideModal="show_answers = false">
                            <template v-slot:header>
                                <h3 class="text-gray-900 text-xl font-semibold">                
                                    Answer Records
                                </h3>                
                            </template>
                            <template v-slot:content>
                                <div class="p-4 space-y-4">
                                    <div class="overflow-x-auto">
                                        <table class="table-auto w-full">
                                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                                <tr>
                                                    <th class="p-2 whitespace-nowrap border" v-for="answer, index in answer_data">
                                                        <div class="flex justify-center font-semibold text-left text-gray-700">Q{{ ++index }}</div>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-sm divide-y divide-gray-100">
                                                <tr>
                                                    <td class="p-2 whitespace-nowrap border text-center align-middle" v-for="answer, index in answer_data">
                                                        <div class="flex justify-center">
                                                            <svg v-if="answer.correct" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill text-green-500" viewBox="0 0 16 16">
                                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                                            </svg>
                                                            <svg v-else xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill text-red-500" viewBox="0 0 16 16">
                                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                                                            </svg>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </template>
                            <template v-slot:footer>
                                <div class="flex justify-end space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                                    <BreezeButton buttonType="info" @click="show_answers = false">Close</BreezeButton>
                                </div>
                            </template>
                        </Modal>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { SearchIcon, TrashIcon, PencilIcon } from '@heroicons/vue/solid'
import { Head, Link } from '@inertiajs/inertia-vue3';
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import Pagination from '@/Components/Pagination.vue'
import moment from 'moment';
import Multiselect from '@vueform/multiselect'
import axios from 'axios'
import Modal from '@/Components/Modal.vue'
import Chart from 'chart.js/auto';

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon,
        ConfirmationModal, Head, Link, Multiselect, Modal, Pagination
    },
    props: {
        filter: Object,
    },
    data(){
        return{
            processing: false,
            show_chart: false,
            show_answers: false,
            bar_chart: '',
            scatter_chart: false,
            params: {
                search: this.filter.search ? this.filter.search : '',
            },
            chart_data: {
                categories: {
                    label: [],
                    data: [],
                },
                total_answers: 4
            },
            answer_data: []
        }
    },
    watch: {
        params: {
            handler(){
                if(this.params){
                    this.$inertia.get(this.route('diagnostic_test.saved_result.details'), this.params, { replace: true, preserveState: true});
                }
            },
            deep: true
        }
    },
    methods: {
        viewChart(index, dt_id, total_answers, chart_type){
            this.processing = true
            this.chart_data.total_answers = total_answers

            this.bar_chart ? this.bar_chart.destroy() : ''
            this.scatter_chart ? this.scatter_chart.destroy() : ''

            this.displayChart(index, dt_id, chart_type)
        },
        displayChart(index, dt_id, chart_type){
            axios.get(route('diagnostic_test.get_dt_categories'), {
                params: {
                    'dt_id' : dt_id,
                    'chart_type': chart_type
                }
            })
            .then(response => {
                this.chart_data.categories.label    =   response.data.label;
                this.chart_data.categories.data     =   response.data.data;
                this.chart_data.categories.data     =   this.splitResultByCategory(index)
                this.initChart(chart_type)
                this.processing = false
            })
            .catch(error => {
                console.error(error);
            });
        },
        initChart(chart_type){
            /* Show Bar Chart */
            if(chart_type == 1){

                /* Init bar chart */
                let bar_chart_canvas    = document.getElementById('bar-chart')
                let bar_chart           = bar_chart_canvas.getContext("2d");

                const BarChart = new Chart(bar_chart, {
                    type: 'bar',
                    data: {
                        labels: this.chart_data.categories.label,
                        datasets: [{
                            data: this.chart_data.categories.data,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        animation: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                        },
                        scales: {
                            y:{
                                min: 0,
                                max: this.chart_data.total_answers,
                                stepSize: 1,
                                ticks: {
                                    beginAtZero: true
                                }
                            },
                            x:{
                                min: 0,
                                max: this.chart_data.total_answers,
                                stepSize: 1,
                                ticks: {
                                    beginAtZero: true
                                }
                            }
                        },
                        ticks: {
                            precision:0
                        }
                    }
                })
                this.bar_chart = BarChart
            }

            /* Show Scatter Chart */
            if(chart_type == 2){
                
                /* Plugins */
                const total_questions = this.chart_data.total_answers
                const scatterArbitraryLine = {
                    id: 'scatterArbitraryLine',
                    beforeDatasetDraw(chart, args, pluginOptions){
                        const { ctx, 
                                chartArea: {top, bottom, left, right, width, height },
                                scales: {x, y}
                        } = chart;

                        lines(0,9,0,9)
                        function lines(xS, xE, yS, yE){
                            ctx.save()
                            ctx.beginPath()
                            ctx.strokeStyle = 'rgba(170, 170, 170, 1)'
                            ctx.lineWidth = 3
                            ctx.moveTo(x.getPixelForValue(0), y.getPixelForValue(0))
                            ctx.lineTo(x.getPixelForValue(total_questions), y.getPixelForValue(total_questions))
                            ctx.stroke()
                            ctx.restore()
                        }
                    }
                }
                
                const scatterAnnotationLine = {
                    id: 'scatterAnnotationLine',
                    beforeDraw: chart=>{
                        if(chart.tooltip._active && chart.tooltip._active.length){
                            const ctx = chart.ctx
                            ctx.save()
                            const activePoint = chart.tooltip._active[0]

                            ctx.beginPath()
                            ctx.moveTo(activePoint.element.x, chart.chartArea.top)
                            ctx.lineTo(activePoint.element.x, activePoint.element.y)
                            ctx.lineWidth = 2
                            ctx.strokeStyle = 'white'
                            ctx.stroke()
                            ctx.restore()

                            ctx.beginPath()
                            ctx.moveTo(activePoint.element.x, activePoint.element.y)
                            ctx.lineTo(activePoint.element.x, chart.chartArea.bottom)
                            ctx.lineWidth = 2
                            ctx.strokeStyle = 'red'
                            ctx.stroke()
                            ctx.restore()

                            ctx.beginPath()
                            ctx.moveTo(chart.chartArea.left, activePoint.element.y)
                            ctx.lineTo(activePoint.element.x, activePoint.element.y)
                            ctx.lineWidth = 2
                            ctx.strokeStyle = 'red'
                            ctx.stroke()
                            ctx.restore()

                        }
                    }
                }

                /* Init scatter chart */
                let scatter_chart_canvas    = document.getElementById('scatter-chart')
                let scatter_plot_chart      = scatter_chart_canvas.getContext("2d");

                const ScatterChart = new Chart(scatter_plot_chart, {
                    type: 'scatter',
                    data: {
                        labels: this.chart_data.total_answers,
                        datasets: [{ 
                            data: [
                                { x: this.chart_data.categories.data[0], y: this.chart_data.categories.data[1] }
                            ],
                            borderColor: "rgba(255, 8, 0, 1)",
                            pointStyle: 'crossRot',
                            radius: 6,
                            hoverRadius: 10,
                            fill: false,
                        }]
                    },
                    options: {
                        animation: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                        },
                        scales: {
                            y:{
                                min: 0,
                                max: this.chart_data.total_answers,
                                stepSize: 1,
                                ticks: {
                                    beginAtZero: true
                                },
                                title: {
                                    display: true,
                                    text: 'Operations'
                                }
                            },
                            x:{
                                min: 0,
                                max: this.chart_data.total_answers,
                                stepSize: 1,
                                ticks: {
                                    beginAtZero: true
                                },
                                title: {
                                    display: true,
                                    text: 'Numbers'
                                }
                            }
                        },
                        ticks: {
                            precision:0
                        }
                    },
                    plugins: [scatterArbitraryLine, scatterAnnotationLine]
                })
                this.scatter_chart = ScatterChart
            }
            this.show_chart = true
        },
        splitResultByCategory(index){
            const correctAnswers    = this.$page.props.answer_record.data[index].answer_record.filter(answer => answer.correct);
            const splittedAnswers   = correctAnswers.reduce((acc, item) => {
                if (item.correct) {
                    if (!acc[item.category_id]) {
                    acc[item.category_id] = 1;
                    } else {
                    acc[item.category_id]++;
                    }
                }
                return acc;
            }, {})
            const newObject = {};
            Object.keys(splittedAnswers).forEach((key, index) => {
                newObject[index] = splittedAnswers[key];
            });
            return Object.values(newObject)
        },
        viewAnswers(index){
            this.answer_data =   this.$page.props.answer_record.data[index].answer_record
            this.show_answers = true
        }
    },
}
</script>