<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<style>
canvas{
    width:800 !important;
    height:800 !important;
}
.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}

.flip-list-move {
  transition: transform 0.5s;
}
.no-move {
  transition: transform 0s;
}
</style>
<template>
    <Head title="Diagnostic Test" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <div class="px-4 py-5 bg-indigo-100 space-y-6 sm:p-6 h-full">
                    <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                        <div class="sm:row-span-3 space-y-2">
                            <div class="items-center flex flex-col justify-center p-6 bg-white border border-gray-200 rounded-lg shadow-md" v-show="show_chart">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md self-center w-[80%]" v-show="show_scatter_chart">
                                    <canvas id="scatter-chart" class="hidden m-0"></canvas>
                                </div>
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md self-center w-[80%]" v-show="show_bar_chart">
                                    <canvas id="bar-chart" class="hidden m-0"></canvas>
                                </div>
                                <div class="p-6">
                                    <button class="py-2 px-4 rounded shadow-md bg-gray-800 text-white hover:bg-gray-700" @click="parentDetails">Next Step</button>
                                </div>
                            </div>
                            <div class="items-center flex flex-col justify-center p-6 bg-white border border-gray-200 rounded-lg shadow-md" v-if="show_parent_details">
                                <div class="flex-col border bg-white px-6 py-8 shadow-md rounded-[4px] min-w-[25%] space-y-4">
                                    <div class="flex flex-col">
                                        <div class="font-semibold leading-5 text-xl">Final step</div>
                                        <div class="mt-1 leading-5 text-slate-500 text-sm">Please fill in below details.</div>
                                    </div>
                                    <hr>
                                    <div class="flex flex-col text-sm rounded-md space-y-1">
                                        <label class="block text-sm text-gray-700 font-bold" for="">Parent's Name <span class="text-red-500">*</span></label>
                                        <input class="mb-5 rounded-[4px] border p-3 hover:outline-none focus:outline-none focus:ring-0 focus:border-gray-500" :class="error.parent_name ? 'border-red-500' : 'border-gray-500'" v-model="form.parent_name" autocomplete="off"/>
                                    </div>
                                    <div class="flex flex-col text-sm rounded-md space-y-1">
                                        <label class="block text-sm text-gray-700 font-bold" for="">Contact Number <span class="text-red-500">*</span></label>
                                        <input class="mb-5 rounded-[4px] border p-3 hover:outline-none focus:outline-none focus:ring-0 focus:border-gray-500" :class="error.parent_contact ? 'border-red-500' : 'border-gray-500'" v-model="form.parent_contact" autocomplete="off"/>
                                    </div>
                                    <div class="flex flex-col text-sm rounded-md space-y-1">    
                                        <label class="block text-sm text-gray-700 font-bold" for="">Address <span class="text-red-500">*</span></label>
                                        <input class="border rounded-[4px] p-3 hover:outline-none focus:outline-none focus:ring-0 focus:border-gray-500" :class="error.parent_address ? 'border-red-500' : 'border-gray-500'" v-model="form.parent_address" autocomplete="off"/>
                                    </div>
                                    <div class="flex flex-col text-sm rounded-md space-y-1">    
                                        <label class="block text-sm text-gray-700 font-bold" for="">Email <span class="text-red-500">*</span></label>
                                        <input class="border rounded-[4px] p-3 hover:outline-none focus:outline-none focus:ring-0 focus:border-gray-500" :class="error.parent_email ? 'border-red-500' : 'border-gray-500'" v-model="form.parent_email" autocomplete="off"/>
                                    </div>
                                    <button type="submit" class="mt-5 w-full border p-2 bg-gray-800 text-white rounded-[4px] hover:bg-gray-700" @click="saveResult()">Submit</button>
                                </div>
                            </div>
                            <div class="items-center flex flex-col justify-center p-6 bg-white border border-gray-200 rounded-lg shadow-md" v-if="show_thank_you">
                                <div class="flex-col border bg-white px-6 py-8 shadow-md rounded-[4px] min-w-[25%] space-y-8">
                                    <div class="flex flex-col items-center space-y-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="text-green-600 w-28 h-28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <h1 class="font-mono text-4xl font-bold">Thank You!</h1>
                                        <h3 class="font-sans text-xl">{{ dt_details.final_message }}</h3>
                                    </div>
                                    <button type="submit" class="mt-5 w-full border p-2 bg-gray-800 text-white rounded-[4px] hover:bg-gray-700" @click="returnHome">Return Home</button>
                                </div>
                            </div>
                            <div class="items-center flex flex-col justify-center p-24 bg-white border border-gray-200 rounded-lg shadow-md" v-if="show_quiz">
                                <div class="inline-block min-w-full rounded text-center p-16">
                                    <div class="px-6 pb-8">
                                        <!-- <span class="text-2xl font-bold uppercase">{{ question_types[current.question_type].name }} Question</span> -->
                                        <span class="text-2xl font-bold uppercase">{{ dt_details.name }} Question</span>
                                    </div>
                                    <div class="question_container">
                                        <div v-if="current.question != '' && current.question_type != 4" :class="!current.question_image ? 'py-28' : ''">
                                            <div class="border-4 border-gray-400 p-3 w-full rounded-lg shadow-xl flex items-center justify-center md:p-5 mb-3">
                                                <h1 class="text-center font-mono font-bold text-2xl">{{ current.question }}</h1>
                                            </div>
                                        </div>
                                        <div class="px-6 pb-8" v-if="current.remarks">
                                            <span class="font-bold uppercase italic text-red-500">* {{ current.remarks }} *</span>
                                        </div>
                                        <div class="flex container justify-center" v-if="current.question_image">
                                            <div class="flex flex-col justify-center w-64 h-64">
                                                <img :src="'/storage/' + current.question_image" class="select-none rounded-lg" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-row justify-center space-x-10 pt-20" v-if="current.question_type == 1">
                                        <div class="select-none flex justify-center items-center rounded bg-indigo-300 hover:bg-indigo-500 hover:text-white cursor-pointer drop-shadow" v-for="(answer_info, index) in current.answers" @click="saveSingleChoice(index)">
                                            <div class="p-1 w-32" v-if="answer_info.image_name != null" v-html="answer_info.answer">
                                            </div>
                                            <div class="py-5 px-6" v-else>
                                                <span v-html="answer_info.answer"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col space-y-10" v-if="current.question_type == 2">
                                        <div class="select-none flex flex-row justify-center space-x-10 pt-20">
                                            <div class="flex justify-center items-center rounded cursor-pointer drop-shadow" v-for="(answer_info, index) in current.answers" @click="selectMultipleChoices(index)" :class="checkSingleValueExistsInArray(index) ? 'text-white bg-indigo-500' : 'bg-indigo-300'">
                                                <div class="p-1 w-32" v-if="answer_info.image_name != null" v-html="answer_info.answer">
                                                </div>
                                                <div class="py-5 px-6" v-else>
                                                    <span v-html="answer_info.answer"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-row justify-center">
                                            <BreezeButton @click="saveMultipleChoices()">Confirm Answers</BreezeButton>
                                        </div>
                                    </div>
                                    <div class="flex flex-col space-y-10" v-if="current.question_type == 3">
                                        <div class="flex flex-col space-y-3">
                                            <div class="flex flex-row justify-center space-x-6">
                                                <div class="flex items-center justify-center border-2 border-indigo-400 w-32 h-32 rounded-lg" v-for="(criterion, index) in current.criterions">
                                                    <div class="p-1 w-32" v-if="criterion.image_name != null" v-html="criterion.value">
                                                    </div>
                                                    <div class="py-5 px-6" v-else>
                                                        <span v-html="criterion.value"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex flex-row justify-center space-x-28">
                                                <div class="" v-for="(criterion, index) in current.criterions">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-caret-down-fill w-10 h-10" viewBox="0 0 16 16">
                                                        <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                                        </svg>
                                                </div>
                                            </div>
                                            <div class="flex justify-center">
                                                <div class="flex flex-row justify-center rounded-lg bg-indigo-50 shadow-md p-3">
                                                    <draggable :animation="300" class="flex space-x-6" v-model="selected_answer.matrix_sorting">
                                                        <div class="flex items-center justify-center border-2 border-indigo-400 w-32 h-32 rounded-lg cursor-move" v-for="(element, index) in selected_answer.matrix_sorting">
                                                            <div class="p-1 w-32" v-if="element.image_name != null" v-html="element.value">
                                                            </div>
                                                            <div class="py-5 px-6" v-else>
                                                                <span v-html="element.value"></span>
                                                            </div>
                                                        </div>
                                                    </draggable>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-row justify-center">
                                            <BreezeButton @click="saveMatrixSorting()">Confirm Answers</BreezeButton>
                                        </div>
                                    </div>
                                    <div class="flex flex-col space-y-10" v-if="current.question_type == 4">
                                        <div class="py-28">
                                            <div class="border-4 border-gray-400 p-3 w-full rounded-lg shadow-xl flex items-center justify-center md:p-5 mb-3">
                                                <h1 class="text-center font-mono font-bold text-2xl" v-for="(part, index) in sentence_parts" :key="index">
                                                    <input type="text" v-if="part.input" v-model="part.answer" class="focus:ring-0 focus:border-indigo-300 rounded-md text-2xl border-gray-300">
                                                    <h1 v-else>&nbsp;{{ part.text }}&nbsp;</h1>
                                                </h1>
                                            </div>
                                        </div>
                                        <div class="flex flex-row justify-center">
                                            <BreezeButton @click="saveFillInBlankAnswers()">Confirm Answers</BreezeButton>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { defineComponent } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { Head, Link  } from '@inertiajs/inertia-vue3';
import { VueDraggableNext  } from 'vue-draggable-next'
import Chart from 'chart.js/auto';
import axios from 'axios';

export default defineComponent({
    components: {
        Head, Link, draggable: VueDraggableNext
    },
    props: {
        form_data: Object,
        dt_details: Object,
        dt_list: Object,
        diagnostic_test_categories_label: Object,
        diagnostic_test_categories: Object,
    },
    data() {
        return {
            can_go_higher: true,
            can_go_lower: true,
            bar_chart: '',
            scatter_chart: '',
            show_chart: false,
            show_bar_chart: false,
            show_scatter_chart: false,
            show_quiz: true,
            show_parent_details: false,
            show_thank_you: false,
            count: 1,
            dt_index: 0,
            correct: false,
            current: {
                question: '',
                question_type: '',
                question_image: '',
                remarks: '',
                criterions: [],
                answers: [],
                score: 0,
                answer_records: []
            },
            question_types: {
                1: {
                    name: 'Single Choice'
                },
                2: {
                    name: 'Multiple Choices'
                },
                3: {
                    name: 'Matrix Sorting'
                },
                4: {
                    name: 'Fill in the Blank'
                }
            },
            selected_answer: {
                single_choice: '',
                multiple_choices: [],
                matrix_sorting: [],
                fill_in_blank: [],
            },
            sentence_parts: [],
            form:{
                student_id: this.form_data.child_id,
                student_name: this.form_data.name,
                student_age: this.form_data.age,
                student_school: this.form_data.school,
                parent_name: '',
                parent_contact: '',
                parent_address: '',
                parent_email: '',
                answer_record: [],
                eligible_level: ''
            },
            error:{
                parent_name: false,
                parent_contact: false,
                parent_address: false,
                parent_email: false,
            },
            chart_data: [1, 2, 3]
        }
    },
    methods: {
        clearAllAnswers(){
            this.selected_answer.single_choice = '',
            this.selected_answer.multiple_choices = []
            this.correct = false
        },
        pushAnswer(){
            if(this.dt_list[this.dt_index]){
                this.form.answer_record.push({
                    'dt_id' : this.dt_list[this.dt_index].dt_id,
                    'question_id' : this.dt_list[this.dt_index].id,
                    'question' : this.dt_list[this.dt_index].question,
                    'correct' : this.correct
                })
                this.dt_index += 1
            }
        },
        saveSingleChoice(selected_answer){
            this.selected_answer.single_choice  =   selected_answer
            if(this.selected_answer.single_choice == this.dt_list[this.dt_index].correct_answer){
                this.current.score += 1
                this.correct = true
            }
            this.pushAnswer()
        },
        selectMultipleChoices(selected_answer){
            const index = this.selected_answer.multiple_choices.indexOf(selected_answer);

            if (index !== -1) {
                this.selected_answer.multiple_choices.splice(index, 1);
            } else {
                this.selected_answer.multiple_choices.push(selected_answer);
            }
            
        },
        saveMultipleChoices(){
            if(this.selected_answer.multiple_choices.length < 1){
                alert('Please select at least ONE answer.')
            }
            else{
                if (this.selected_answer.multiple_choices.length !== this.dt_list[this.dt_index].correct_answer.length) {
                    this.dt_index += 1
                }
                else{
                    const correct    =   this.checkIfArrayMatch(this.selected_answer.multiple_choices, this.dt_list[this.dt_index].correct_answer)
                    if(correct){
                        this.current.score += 1
                        this.correct = true
                    }
                    this.pushAnswer()
                }
            }
        },
        saveMatrixSorting(){
            const correct = this.checkIfArrayMatch(this.selected_answer.matrix_sorting, this.dt_list[this.dt_index].answers.element)
            if(correct){
                this.current.score += 1
                this.correct = true
            }
            this.pushAnswer()
        },
        checkSingleValueExistsInArray(selected_answer){
            const index = this.selected_answer.multiple_choices.indexOf(selected_answer);

            if (index !== -1) {
                return true
            } else {
                return false
            }
        },
        checkArrayExistsInArray(arr1, arr2){
            arr2.every(function(item) {
                return arr1.indexOf(item) !== -1;
            });
        },
        checkIfArrayMatch(arr1, arr2){
            arr1.sort();
            arr2.sort();

            for (let i = 0; i < arr1.length; i++) {
                if (arr1[i] !== arr2[i]) {
                    return false;
                }
            }
            return true;
        },
        shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        },
        saveFillInBlankAnswers(){
            if(this.sentence_parts.every(this.partIsCorrect)){
                this.current.score += 1
                this.correct = true
            }
            this.pushAnswer()
        },
        partIsCorrect (part) {
            return !part.input || part.text === part.answer.replace(/\s+/g, ' ').trim()
        },
        resetFillInBlank(){
            const re = /(\[[^\]]*\])/
            // The filter removes empty strings
            const parts = this.current.question.split(re).filter(text => text)

            this.sentence_parts = parts.map(segment => {
                const isInput = re.test(segment)

                return {
                    answer: '',
                    input: isInput,
                    text: isInput ? segment.slice(1, -1) : segment
                }
            })
        },
        parentDetails(){
            this.show_chart = false
            this.show_quiz = false
            this.show_parent_details = true
        },
        handleBeforeUnload(event) {
            event.preventDefault();
            event.returnValue = '';
            const confirmationMessage = 'Are you sure you want to leave the page?';
            event.returnValue = confirmationMessage;
            return confirmationMessage;
        },
        getHigherLevelDt(){
            axios.get(route('diagnostic_test.new_level'), {
                params: {
                    dt_id: this.dt_details.higher_score_direction,
                }
            })
            .then(response => {
                this.dt_index = 0
                this.current.score = 0
                this.$page.props.diagnostic_test_categories_label = response.data.category_label
                this.$page.props.dt_details = response.data.dt_details
                this.$page.props.dt_list = response.data.dt_list
            })
            .catch(error => {
                console.error(error);
            });
        },
        getLowerLevelDt(){
            axios.get(route('diagnostic_test.new_level'), {
                params: {
                    dt_id: this.dt_details.lower_score_direction,
                }
            })
            .then(response => {
                this.dt_index = 0
                this.current.score = 0
                this.$page.props.diagnostic_test_categories_label = response.data.category_label
                this.$page.props.dt_details = response.data.dt_details
                this.$page.props.dt_list = response.data.dt_list
            })
            .catch(error => {
                console.error(error);
            });
        },
        saveResult(){
            axios.post(route('diagnostic_test.save_result'), this.form)
            .then(response => {
                if(response){
                    this.show_parent_details = false
                    this.show_thank_you = true
                }
            })
            .catch(error => {
                console.error(error);
            });
        },
        returnHome(){
            this.$inertia.get(route('public.diagnostic_test'))
        },
        processGraph(){
            /* Get current level answer records and get each question's category*/
            this.current.answer_records =   this.form.answer_record.filter(item => item.dt_id === this.form.eligible_level);
            const combined = this.current.answer_records.map(q => {
                const category = this.dt_list.find(c => c.id === q.question_id);
                return { ...q, category_id: category ? category.category_id : null };
            });

            const correctAnswers    = combined.filter(answer => answer.correct);
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
            const finalScores = [];
            Object.keys(splittedAnswers).forEach((key, index) => {
                finalScores[index] = splittedAnswers[key];
            });
            Object.values(finalScores)

            this.chart_data = finalScores
            this.initChart()

            if(this.dt_details.chart_id == 1){
                this.show_bar_chart     = true
                this.show_scatter_chart = false
            }
            else{
                this.show_scatter_chart = true
                this.show_bar_chart     = false
            }

        },
        initChart(){
            
            this.bar_chart ? this.bar_chart.destroy() : ''
            this.scatter_chart ? this.scatter_chart.destroy() : ''

            /* Plugins */
            const total_questions = this.dt_list.length
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
                    datasets: [{ 
                        // data: [
                        //     { x: this.chart_data[0], y: this.chart_data[1] }
                        // ],
                        label: "Test",
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
                            max: this.dt_list.length,
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
                            max: this.dt_list.length,
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

            /* Init bar chart */
            let bar_chart_canvas    = document.getElementById('bar-chart')
            let bar_chart      = bar_chart_canvas.getContext("2d");

            const BarChart = new Chart(bar_chart, {
                type: 'bar',
                data: {
                    labels: this.diagnostic_test_categories_label,
                    datasets: [{
                        data: this.chart_data,
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
                            max: this.dt_list.length,
                            stepSize: 1,
                            ticks: {
                                beginAtZero: true
                            }
                        },
                        x:{
                            min: 0,
                            max: this.dt_list.length,
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
    },
    watch: {
        dt_index: {
            handler(){
                if(this.dt_list.length){
                    if(this.dt_list.length == this.dt_index){
                        const current_score         =   this.current.score
                        const high_score_limit      =   this.dt_details.higher_score
                        const high_score_redirect   =   this.dt_details.higher_score_direction
                        const low_score_limit       =   this.dt_details.lower_score
                        const low_score_redirect    =   this.dt_details.lower_score_direction
                        
                        if(!this.form.eligible_level){
                            /* Go next level if score over limit */
                            if(high_score_redirect && current_score > low_score_limit && current_score > high_score_limit){
                                this.form.eligible_level = this.dt_details.id
                                this.getHigherLevelDt()
                                this.can_go_lower = false
                            }
                            /* Go previous level if score below limit */
                            else if(low_score_redirect && current_score < low_score_limit){
                                this.getLowerLevelDt()
                                this.can_go_higher = false
                            }
                            else{
                                this.form.eligible_level = this.dt_details.id
                                this.show_chart = true
                                this.show_quiz = false
                            }
                        }
                        else{
                            if(current_score == 0 || current_score < low_score_limit){
                                if(this.can_go_lower){
                                    if(low_score_redirect){
                                        this.getLowerLevelDt()
                                    }
                                    else{
                                        this.show_chart = true
                                        this.show_quiz = false
                                    }
                                }
                                else{
                                    this.getLowerLevelDt()
                                    this.show_chart = true
                                    this.show_quiz = false
                                }
                            }
                            else if(current_score > low_score_limit && current_score > high_score_limit){
                                if(this.can_go_higher){
                                    if(high_score_redirect){
                                        this.form.eligible_level = this.dt_details.id
                                        this.getHigherLevelDt()
                                    }
                                    else{
                                        this.form.eligible_level = this.dt_details.id
                                        this.show_chart = true
                                        this.show_quiz = false
                                    }
                                }
                                else{
                                    this.form.eligible_level = this.dt_details.id
                                    this.show_chart = true
                                    this.show_quiz = false
                                }
                            }
                            else{
                                this.form.eligible_level += 1
                                this.show_chart = true
                                this.show_quiz = false
                            }
                        }
                        this.processGraph()
                    }
                    else{
                        this.current.question       = this.dt_list[this.dt_index].question ? this.dt_list[this.dt_index].question : ''
                        this.current.question_type  = this.dt_list[this.dt_index].question_type ? this.dt_list[this.dt_index].question_type : ''
                        this.current.question_image = this.dt_list[this.dt_index].question_image ? this.dt_list[this.dt_index].question_image : ''
                        this.current.remarks        = this.dt_list[this.dt_index].remarks ? this.dt_list[this.dt_index].remarks : ''
                        this.current.answers        = this.dt_list[this.dt_index].answers ? this.dt_list[this.dt_index].answers : ''
                        this.current.criterions     = this.dt_list[this.dt_index].answers.criterion ? this.dt_list[this.dt_index].answers.criterion : ''
                        this.clearAllAnswers()
                        if(this.current.question_type == 3){
                            this.selected_answer.matrix_sorting = this.dt_list[this.dt_index].answers.element.slice()
                            this.shuffleArray(this.selected_answer.matrix_sorting)
                        }
                    }
                }
            },
            immediate: true
        },
        question: {
            immediate: true,
            handler: 'resetFillInBlank'
        }
    },
    beforeDestroy() {
        window.removeEventListener('beforeunload', this.handleBeforeUnload);
    },
    mounted(){
        window.addEventListener('beforeunload', this.handleBeforeUnload);
    }
})
</script>
                                