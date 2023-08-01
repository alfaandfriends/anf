<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
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
                                <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg focus:ring-0 focus:border-gray-300 appearance-none  block pl-10"
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
                                            <BreezeButton buttonType="blue" class="py-1 px-2" @click="!processing_item[index].process && !processing ? viewReport(index, result.dt_id, result.total_answers, result.chart_type) : ''">
                                                
                                                <div class="flex items-center space-x-2" v-if="processing_item[index].process && processing">
                                                    <svg class="inline-block h-4 w-4 animate-spin rounded-full border-2 border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]" viewBox="0 0 24 24">
                                                    </svg>
                                                    <span>Generating...</span>
                                                </div>
                                                <span v-else>View Report</span>
                                            </BreezeButton>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <Pagination :page_data="$page.props.answer_record" :params="'&result_id='+$page.props.result_id"></Pagination>
                        <Modal :showModal="show_report" @hideModal="show_report = false">
                            <template v-slot:header>
                                <h3 class="text-gray-900 text-xl font-semibold">                
                                    Diagnostic Test Report
                                </h3>                
                            </template>
                            <template v-slot:content>
                                <div class="h-[297mm] overflow-y-auto no-scrollbar" id="report">
                                    <div class="flex flex-col justify-between space-y-2">
                                <!-- <div class="flex justify-center bg-gray-200 py-4 rounded max-h-[90%] overflow-y-auto no-scrollbar" id="report">
                                    <div class="bg-white w-[210mm] h-[297mm] space-y-6 py-4"> -->
                                        <div class="grid grid-rows-1">
                                            <div class="flex justify-center">
                                                <h1 class="font-bold text-slate-800 text-2xl py-4 uppercase">Diagnostic Test {{ report.title }}</h1>
                                            </div>
                                        </div>
                                        <div class="grid grid-rows-1">
                                            <div class="grid grid-cols-2 px-4 space-x-4">
                                                <div class="flex items-center justify-center border-2 p-6 rounded-lg h-[300px]">
                                                    <div id="chart_image"></div>
                                                    <canvas id="scatter-chart" class="hidden m-0"></canvas>
                                                    <canvas id="bar-chart" class="hidden m-0"></canvas>
                                                </div>
                                                <div class="border-2 p-6 rounded-lg">
                                                    <!-- <h3 class="font-medium text-indigo-700">Student's Information</h3>
                                                    <hr class="mt-3 border-2 border-indigo-700 border-dashed"> -->
                                                    <dl class="mt-2 divide-y divide-gray-300">
                                                        <div class="py-3 flex justify-between text-sm font-medium">
                                                            <dt class="text-gray-500 min-w-[70px]">Name : </dt>
                                                            <dd class="text-gray-900 break-word">{{ report.name }}</dd>
                                                        </div>
                                                        <div class="py-3 flex justify-between text-sm font-medium">
                                                            <dt class="text-gray-500">Age :</dt>
                                                            <dd class="text-gray-900">{{ report.age }}</dd>
                                                        </div>
                                                        <div class="py-3 flex justify-between text-sm font-medium">
                                                            <dt class="text-gray-500">Result :</dt>
                                                            <dd class="text-gray-900">{{ report.result }}</dd>
                                                        </div>
                                                        <div class="py-3 flex justify-between text-sm font-medium">
                                                            <dt class="text-gray-500">Date :</dt>
                                                            <dd class="text-gray-900">{{ moment(report.datetime).format('DD/MM/Y') }}</dd>
                                                        </div>
                                                        <div class="py-3 flex justify-between text-sm font-medium">
                                                            <dt class="text-gray-500">Time :</dt>
                                                            <dd class="text-gray-900">{{ moment(report.datetime).format('h:mm A') }}</dd>
                                                        </div>
                                                    </dl>
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
                                                                <td class="p-2 whitespace-nowrap border-2 text-center align-middle">{{ ++index }}</td>
                                                                <td class="p-2 whitespace-nowrap border-2 align-middle">
                                                                    <div class="flex flex-wrap">
                                                                        <p class="whitespace-normal font-semibold">{{ answer.question }}</p>
                                                                    </div>
                                                                </td>
                                                                <td class="p-2 whitespace-nowrap border-2 text-center align-middle">
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
                            </template>
                            <template v-slot:footer>
                                <div class="flex justify-between space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                                    <BreezeButton buttonType="info" @click="print">Print</BreezeButton>
                                    <BreezeButton buttonType="gray" @click="show_report = false">Close</BreezeButton>
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
import ChartDataLabels from 'chartjs-plugin-datalabels';

const printOptions = {
    name: '_blank',
    specs: [
    ],
    styles: [
        'http://127.0.0.1:8000/css/app.css',
    ],
    timeout: 1000, // default timeout before the print window appears
    autoClose: true, // if false, the window will not close after printing
    windowTitle: window.document.title, // override the window title
}

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
            current_chart_type: '',
            processing: false,
            processing_item: [],
            bar_chart: '',
            scatter_chart: '',
            show_report: false,
            report: {
                title: '',
                name: '',
                age: '',
                result: '',
                datetime: '',
            },
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
        async waitTwoSeconds() {
            await new Promise(resolve => setTimeout(resolve, 2000));
        },
        print() {
            if(this.current_chart_type == 1){
                document.getElementById('bar-chart').style.display = 'none'
                document.getElementById('chart_image').style.display = 'block'
            }
            else{
                document.getElementById('scatter-chart').style.display = 'none'
                document.getElementById('chart_image').style.display = 'block'
            }
            this.waitTwoSeconds()
            this.$htmlToPaper('report', printOptions, () => {
                if(this.current_chart_type == 1){
                    document.getElementById('bar-chart').style.display = 'block'
                    document.getElementById('chart_image').style.display = 'none'
                }
                else{
                    document.getElementById('scatter-chart').style.display = 'block'
                    document.getElementById('chart_image').style.display = 'none'
                }
            })
        },
        viewReport(index, dt_id, total_answers, chart_type){
            this.current_chart_type =   chart_type
            this.processing = true
            this.processing_item[index].process = true
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
                this.initAnswers(index)
                this.initInfos(index)
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
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            onComplete: function(){
                                document.getElementById('chart_image').innerHTML = '<img src="'+this.toBase64Image()+'">'
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            datalabels: {
                                anchor: 'end',
                                align: 'end',
                                color: '#000000',
                                font: {
                                    size: 14
                                },
                                formatter: function(value, context) {
                                    return value;
                                }
                            }
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
                        animation: {
                            onComplete: function(){
                                document.getElementById('chart_image').innerHTML = '<img src="'+this.toBase64Image()+'">'
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            // datalabels: {
                            //     display: true,
                            //     anchor: 'end',
                            //     align: 'end',
                            //     color: '#000000',
                            //     font: {
                            //         size: 14
                            //     }
                            // }
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
        },
        splitResultByCategory(index){
            const correctAnswers    = this.$page.props.answer_record.data[index].answer_record.filter(answer => answer.correct);
            const splittedAnswers   = correctAnswers.reduce((acc, item) => {
                if (item.correct) {
                    if (!acc[item.question_category_id]) {
                    acc[item.question_category_id] = 1;
                    } else {
                    acc[item.question_category_id]++;
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
        initAnswers(index){
            this.answer_data =   this.$page.props.answer_record.data[index].answer_record
        },
        initInfos(index){
            axios.get(route('diagnostic_test.get_saved_result_info'), {
                params: {
                    'result_id' : this.$page.props.result_id,
                }
            })
            .then(response => {
                this.report.title       = this.$page.props.answer_record.data[index].dt_name
                this.report.name        = response.data.child_name
                this.report.age         = response.data.child_age
                this.report.result      = this.$page.props.answer_record.data[index].total_correct_answers + '/' + this.$page.props.answer_record.data[index].total_answers
                this.report.datetime    = moment(response.data.created_at).format('DD/MM/YYYY, hh:mm A')
                this.show_report = true
                this.processing = false
                this.processing_item[index].process  = false
            })
            .catch(error => {
                console.error(error);
            });
        },

    },
    created(){
        this.$page.props.answer_record.data.map(()=>{
            this.processing_item.push({
                'process':false
            })
        })
    }
}
</script>