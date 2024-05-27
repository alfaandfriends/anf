<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Diagnostic Test Report" />
    <div class="flex flex-col justify-center items-center p-3 space-y-4" v-show="!finish_loading_report">
        <div class="mt-16">
            Please wait while report is loading...
        </div>
    </div>
    <!-- <div class="flex justify-center" v-show="finish_loading_report"> -->
        <div class="flex justify-center w-[215mm] mx-2 my-2" v-show="finish_loading_report">
            <div class="flex flex-col items-center space-y-4">
                <div class="border border-gray-700 w-[210mm]">
                    <div class="flex flex-col justify-between space-y-2 bg-white p-3" id="report" ref="report">
                        <div class="grid grid-rows-1">
                            <div class="flex justify-center">
                                <h1 class="font-bold text-slate-800 text-xl py-5 uppercase">Diagnostic Test {{ report.title }}</h1>
                            </div>
                        </div>
                        <div class="grid grid-rows-1">
                            <div class="grid grid-cols-2 px-4 space-x-4">
                                <div class="flex items-center justify-center rounded-lg">
                                    <canvas id="scatter-chart" ref="scatterChart" class="hidden m-0"></canvas>
                                    <canvas id="bar-chart" ref="barChart" class="hidden m-0"></canvas>
                                </div>
                                <div class="p-6 rounded-lg">
                                    <dl class="mt-2 space-y-3">
                                        <div class="flex justify-between text-sm font-medium">
                                            <dt class="text-gray-500 min-w-[70px]">Name : </dt>
                                            <dd class="text-gray-900 break-word">{{ report.name }}</dd>
                                        </div>
                                        <div class="flex justify-between text-sm font-medium">
                                            <dt class="text-gray-500">Age :</dt>
                                            <dd class="text-gray-900">{{ report.age }}</dd>
                                        </div>
                                        <div class="flex justify-between text-sm font-medium">
                                            <dt class="text-gray-500">Result :</dt>
                                            <dd class="text-gray-900">{{ report.result }}</dd>
                                        </div>
                                        <div class="flex justify-between text-sm font-medium">
                                            <dt class="text-gray-500">Date / Time</dt>
                                            <dd class="text-gray-900">{{ report.date }} - {{ report.time }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 px-4 space-x-4">
                                <div class="flex items-center p-2 text-sm text-gray-800 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600" role="alert">
                                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                    </svg>
                                    <div class="flex flex-col text-xs">
                                        <span v-for="info in chart_data.categories.info"><span class="font-semibold" :style="'color: ' + info.category_color">{{ info.category_name }}:</span> {{ info.category_description }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-rows-1">
                            <div class="grid grid-cols-1">
                                <div class="flex justify-center px-4">
                                    <table class="w-full">
                                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-indigo-100">
                                            <tr>
                                                <th class="p-2 whitespace-nowrap border-2 rounded-tr" width="3">
                                                    <div class="flex justify-center font-semibold text-left text-gray-700">#</div>
                                                </th>
                                                <th class="p-2 whitespace-nowrap border-2">
                                                    <div class="flex font-semibold justify-center text-gray-700">Question</div>
                                                </th>
                                                <th class="p-2 whitespace-nowrap border-2 w-8">
                                                    <div class="flex justify-center font-semibold text-left text-gray-700">Result</div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-sm divide-y divide-gray-100">
                                            <tr v-for="answer, index in answer_data">
                                                <td class="p-1 whitespace-nowrap border-2 text-center align-middle text-sm">{{ ++index }}</td>
                                                <td class="p-1 whitespace-nowrap border-2 align-middle text-sm">
                                                    <div class="flex flex-col flex-wrap">
                                                        <p class="whitespace-normal font-semibold">{{ answer.question }}</p>
                                                        <template v-if="answer.answer">
                                                            <div class="flex items-center">
                                                                <p class="whitespace-normal font-semibold">Answer: 
                                                                    <template v-if="answer.answer.length">
                                                                        <span>{{ answer.answer.map(item => (item === null ? 'Blank' : item)) }}</span>
                                                                    </template>
                                                                    <template v-else>
                                                                        <span>{{ answer.answer }}</span>
                                                                    </template>
                                                                </p>
                                                            </div>
                                                        </template>
                                                        <template v-else>
                                                            <p class="whitespace-normal font-semibold">Answer: {{ answer.answer + 1 }}</p>
                                                        </template>
                                                    </div>
                                                </td>
                                                <td class="p-1 whitespace-nowrap border-2 text-center align-middle text-sm">
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
                        </div>
                    </div>
                </div>
                <BreezeButton @click="download" v-if="finish_loading_report">Download</BreezeButton>
            </div>
        </div>
    <!-- </div> -->
</template>

<script>
import { SearchIcon, TrashIcon, PencilIcon } from '@heroicons/vue/solid'
import { Head, Link } from '@inertiajs/inertia-vue3';
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import Pagination from '@/Components/Pagination.vue'
import moment from 'moment';
import Multiselect from '@vueform/multiselect'
import axios from 'axios'
import Chart from 'chart.js/auto';
import annotationPlugin from 'chartjs-plugin-annotation';
import ChartDataLabels from 'chartjs-plugin-datalabels';
import domtoimage from 'dom-to-image';

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon,
        ConfirmationModal, Head, Link, Multiselect, Pagination
    },
    props: {
        filter: Object,
    },
    data(){
        return{
            finish_loading_report: false,
            current_chart_type: '',
            chart_info: [],
            bar_chart: '',
            scatter_chart: '',
            chart_image: '',
            show_report: false,
            report: {
                title: '',
                name: '',
                age: '',
                result: '',
                datetime: '',
            },
            chart_data: {
                categories: {
                    label: [],
                    data: [],
                    info: [],
                },
                total_answers: 4
            },
            answer_data: []
        }
    },
    methods: {
        async waitTwoSeconds() {
            await new Promise(resolve => setTimeout(resolve, 2000));
        },
        viewReport(){
            const dt_id = this.$page.props.answer_record.dt_id
            const total_answers = this.$page.props.answer_record.total_answers
            const chart_type = this.$page.props.answer_record.chart_type


            this.current_chart_type =   chart_type
            this.chart_data.total_answers = total_answers

            this.bar_chart ? this.bar_chart.destroy() : ''
            this.scatter_chart ? this.scatter_chart.destroy() : ''

            this.displayChart(dt_id, chart_type)
        },
        displayChart(dt_id, chart_type){
            axios.get(route('diagnostic_test.get_dt_categories'), {
                params: {
                    'dt_id' : dt_id,
                    'chart_type': chart_type
                }
            })
            .then(response => {
                this.chart_data.categories.label    =   response.data.label;
                this.chart_data.categories.data     =   response.data.data;
                this.chart_data.categories.data     =   this.splitResultByCategory()
                this.chart_data.categories.info     =   response.data.info
                this.initChart(chart_type)
                this.initAnswers()
                this.initInfos()
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
                            backgroundColor: [
                                '#7B66FF',  // First bar color
                                '#39A7FF', // Second bar color
                                '#508D69', // Third bar color
                                '#ED5AB3', // Fourth bar color
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        animation: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: false
                            },
                            datalabels: {
                                display: false, // This line controls the display of data labels
                            },
                        },
                        scales: {
                            y:{
                                min: 0,
                                max: 3,
                                stepSize: 1,
                                ticks: {
                                    beginAtZero: true
                                }
                            },
                            x:{
                                display: false, // Hide the x-axis labels
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
                    },
                    plugins: [ChartDataLabels]
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
                                display: false // <-- this option disables legends
                            },
                            tooltip: {
                                enabled: false
                            }
                        },
                        scales: {
                            y:{
                                min: 0,
                                max: 5,
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
                                max: 5,
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
        },
        splitResultByCategory(){
            const splittedAnswers   = this.$page.props.answer_record.answer_record.reduce((acc, question) => {
                if (question.correct) {
                    acc[question.question_category_id] = (acc[question.question_category_id] || 0) + 1;
                } else if (!acc.hasOwnProperty(question.question_category_id)) {
                    // Initialize with 0 if not present
                    acc[question.question_category_id] = null;
                }
                return acc;
            }, {});
            
            const newObject = {};
            Object.keys(splittedAnswers).forEach((key, index) => {
                newObject[index] = splittedAnswers[key];
            });
            return Object.values(newObject)
        },
        initAnswers(){
            this.answer_data =   this.$page.props.answer_record.answer_record
        },
        initInfos(){
            this.report.title       = this.$page.props.answer_record.dt_name
            this.report.name        = this.$page.props.answer_record.child_name
            this.report.age         = this.$page.props.answer_record.child_age
            this.report.result      = this.$page.props.answer_record.total_correct_answers + '/' + this.$page.props.answer_record.total_answers
            this.report.date        = moment(this.$page.props.answer_record.created_at).format('DD/MM/YYYY')
            this.report.time        = moment(this.$page.props.answer_record.created_at).format('hh:mm A')
            this.finish_loading_report = true
        },
        download(){
            document.getElementById('report').style.display = 'block'
            var node = document.getElementById('report')
            setTimeout(() => {
                var scale = 2;
                domtoimage.toPng(node, {
                    width: node.clientWidth * scale,
                    height: node.clientHeight * scale,
                    style: {
                        transform: 'scale('+scale+')',
                        transformOrigin: 'top left'
                    }
                })
                .then(function (dataUrl) {
                    var link = document.createElement('a');
                    link.href = dataUrl;
                    link.download = 'Diagnostic Test Report.png'; 
                    link.style.display = 'none';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                })
                .catch(function (error) {
                    console.error('oops, something went wrong!', error);
                });
            })
        }
    },
    created(){
        this.viewReport()
    },
}
</script>