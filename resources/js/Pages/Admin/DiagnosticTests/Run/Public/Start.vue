<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<style>
.criterion_image img{
    object-fit: scale-down; 
    height: 5rem;
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
    <div class="flex flex-col h-screen">
        <div class="flex-grow flex flex-col items-center justify-center py-6 bg-indigo-500 overflow-x-auto sm:overflow-x-clip">
            <div class="flex flex-col items-center justify-center w-full h-full max-w-4xl" v-show="show_chart" style="display:hidden">
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md overflow-x-auto w-[350px] sm:w-full h-[200px] sm:h-auto" v-show="show_scatter_chart">
                    <canvas id="scatter-chart" class="hidden m-0"></canvas>
                    <div class="flex items-center p-4 text-sm text-gray-800 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600" role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <div class="flex flex-col space-y-2">
                            <span v-for="info in chart_info"><span class="font-semibold" :class="'text-[' + info.category_color + ']'">{{ info.category_name }}:</span> {{ info.category_description }}</span>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md overflow-x-auto w-[350px] sm:w-full h-[200px] sm:h-auto" v-show="show_bar_chart">
                    <canvas id="bar-chart" class="hidden m-0"></canvas>
                    <div class="flex items-center p-4 text-sm text-gray-800 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600" role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <div class="flex flex-col space-y-2">
                            <span v-for="info in chart_info"><span class="font-semibold" :style="'color: ' + info.category_color">{{ info.category_name }}:</span> {{ info.category_description }}</span>
                        </div>
                    </div>
                </div>
                <div class="p-6 text-center">
                    <button class="py-2 px-4 rounded shadow-md bg-gray-800 text-white hover:bg-gray-700" @click="parentDetails">Next Step</button>
                </div>
            </div>
            <div class="w-full max-w-2xl mt-32 sm:mt-0" v-if="show_parent_details">
                <div class="flex-1 flex-grow flex flex-col w-full border bg-white px-6 py-8 shadow-md rounded-[4px] min-w-[25%] space-y-4">
                    <div class="flex flex-col">
                        <div class="font-semibold leading-5 text-xl">Final step</div>
                        <div class="mt-1 leading-5 text-slate-500 text-sm">Kindly fill out the parent's details to receive the generated result.</div>
                    </div>
                    <hr>
                    <div class="flex flex-col text-sm rounded-md space-y-1">
                        <label class="block text-sm text-gray-700 font-bold" for="">Parent's Name <span class="text-red-500">*</span></label>
                        <input type="text" class="mb-5 rounded-[4px] border p-3 hover:outline-none focus:outline-none focus:ring-0 focus:border-gray-500" :class="error.parent_name ? 'border-red-500' : 'border-gray-500'" v-model="form.parent_name" autocomplete="off" required/>
                    </div>
                    <div class="flex flex-col text-sm rounded-md space-y-1">
                        <label class="block text-sm text-gray-700 font-bold" for="">Parent's Contact Number <span class="text-red-500">*</span></label>
                        <input type="text" class="w-full mb-5 rounded-[4px] border p-3 hover:outline-none focus:outline-none focus:ring-0 focus:border-gray-500" :class="error.parent_contact ? 'border-red-500' : 'border-gray-500'" v-model="form.parent_contact" autocomplete="off" @input="restrictToNumbers" required/>
                    </div>
                    <div class="flex flex-col text-sm rounded-md space-y-1">    
                        <label class="block text-sm text-gray-700 font-bold" for="">Parent's Area/Location <span class="text-red-500">*</span></label>
                        <input type="text" class="border rounded-[4px] p-3 hover:outline-none focus:outline-none focus:ring-0 focus:border-gray-500" :class="error.parent_area_location ? 'border-red-500' : 'border-gray-500'" v-model="form.parent_area_location" autocomplete="off" placeholder="e.g. Puchong, Selangor" required/>
                    </div>
                    <div class="flex flex-col text-sm rounded-md space-y-1">    
                        <label class="block text-sm text-gray-700 font-bold" for="">Parent's Email <span class="text-red-500">*</span></label>
                        <input type="email" class="border rounded-[4px] p-3 hover:outline-none focus:outline-none focus:ring-0 focus:border-gray-500" :class="error.parent_email ? 'border-red-500' : 'border-gray-500'" v-model="form.parent_email" autocomplete="off" required/>
                    </div>
                    <hr>
                    <div class="flex items-center">
                        <input id="link-checkbox" type="checkbox" value="" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-0 cursor-pointer" v-model="form.has_edu_teacher_email">
                        <label for="link-checkbox" class="ms-2 text-sm font-medium text-gray-900 cursor-pointer">Keep a copy for myself</label>
                    </div>
                    <template v-if="form.has_edu_teacher_email">
                        <div class="flex flex-col text-sm rounded-md space-y-1">    
                            <input type="email" class="border rounded-[4px] p-3 hover:outline-none focus:outline-none focus:ring-0 focus:border-gray-500 border-gray-500" v-model="form.edu_teacher_email" autocomplete="off" placeholder="Your Email"/>
                        </div>
                    </template>
                    <button type="submit" class="mt-5 w-full border p-2 text-white rounded-[4px] hover:bg-gray-700" :class="!submitting ? 'bg-gray-800 hover:bg-gray-700' : 'bg-gray-800'" @click="!submitting ? saveResult() : ''">{{ submitting ? 'Submitting...' : 'Submit' }}</button>
                    <div class="text-center">
                        <span class="italic text-center text-sm text-gray-700 font-semibold" v-if="submitting">Please do not close your browser or current tab</span>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-2xl" v-if="show_thank_you">
                <div class="flex-col border bg-white px-6 py-8 shadow-md rounded-[4px] min-w-[25%] space-y-8">
                    <div class="flex flex-col items-center space-y-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-green-600 w-28 h-28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h1 class="font-mono text-xl sm:text-3xl font-bold">Thank You!</h1>
                        <h3 class="font-sans text-sm sm:text-xl">{{ $page.props.final_message }}</h3>
                    </div>
                    <button type="submit" class="mt-5 w-full border p-2 bg-gray-800 text-white rounded-[4px] hover:bg-gray-700" @click="returnHome">Return Home</button>
                </div>
            </div>
            <div class="w-full max-w-2xl mt-16 sm:mt-0" v-if="show_quiz">
                <div class="flex flex-col bg-white rounded-lg shadow min-w-[70%]">
                    <div class="flex flex-col min-w-full rounded text-center p-8 sm:p-16 space-y-6 sm:space-y-10">
                        <span class="text-xl sm:text-3xl font-bold uppercase">{{ dt_details.name }}</span>
                        <nav class="flex flex-col items-center space-y-4 m-0">
                            <p class="text-sm sm:text-lg font-medium">Question {{ dt_index + 1 }} of {{ dt_list.length }}</p>
                            <ol role="list" class="flex items-center space-x-2 sm:space-x-4">
                                <li v-for="(data, key) in dt_list" :key="key">
                                    <div v-if="current.answer_records[key] && current.answer_records[key].correct" class="block w-3 h-3 sm:w-4 sm:h-4 bg-green-400 rounded-full">
                                        <span class="sr-only">{{ key }}</span>
                                    </div>
                                    <div v-else-if="dt_index == key" class="relative flex items-center justify-center">
                                        <span class="absolute w-4 h-4 sm:w-5 sm:h-5 p-px flex">
                                            <span class="w-full h-full rounded-full bg-indigo-500" />
                                        </span>
                                        <span class="relative block w-2.5 h-2.5 sm:w-3.5 sm:h-3.5 bg-white rounded-full" />
                                        <span class="sr-only">{{ key }}</span>
                                    </div>
                                    <div v-else-if="current.answer_records[key] && !current.answer_records[key].correct" class="block w-3 h-3 sm:w-4 sm:h-4 bg-red-500 rounded-full">
                                        <span class="sr-only">{{ key }}</span>
                                    </div>
                                    <div v-else class="block w-3 h-3 sm:w-4 sm:h-4 bg-gray-300 rounded-full">
                                        <span class="sr-only">{{ key }}</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                        <div v-if="current.question != '' && current.question_type != 4">
                            <div class="border-4 border-gray-400 p-3 w-full rounded-lg shadow-xl flex items-center justify-center md:p-5">
                                <h1 class="text-center font-mono font-bold text-sm sm:text-xl whitespace-pre-wrap">{{ current.question }}</h1>
                            </div>
                        </div>
                        <div class="px-6" v-if="current.remarks">
                            <span class="font-bold uppercase italic text-red-500">* {{ current.remarks }} *</span>
                        </div>
                        <div class="flex items-center justify-center" v-if="current.question_image">
                            <img :src="'/storage/' + current.question_image" class="select-none rounded-lg" alt="">
                        </div>
                        <div class="flex flex-col sm:flex-row justify-center sm:space-x-10 space-y-2 sm:space-y-0" v-if="current.question_type == 1">
                            <div class="select-none text-white flex justify-center items-center rounded bg-indigo-600 hover:bg-indigo-500 hover:text-white cursor-pointer drop-shadow" v-for="(answer_info, index) in current.answers" @click="saveSingleChoice(index)">
                                <div class="p-1 w-32" v-if="answer_info.image_name" v-html="answer_info.answer">
                                </div>
                                <div class="py-5 px-6" v-else>
                                    <span v-html="answer_info.answer"></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col space-y-10" v-if="current.question_type == 2">
                            <div class="grid grid-cols-4 gap-4 mx-auto">
                                <div class="flex justify-center items-center rounded cursor-pointer drop-shadow" v-for="(answer_info, index) in current.answers" @click="selectMultipleChoices(index)" :class="checkSingleValueExistsInArray(index) ? 'text-white bg-indigo-600' : 'text-white bg-indigo-400'">
                                    <div class="p-1 w-32" v-if="answer_info.image_name" v-html="answer_info.answer">
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
                        <div class="flex flex-col space-y-2" v-if="current.question_type == 3">
                            <div class="text-left space-y-2">
                                <h3 class="font-semibold text-xl">Elements</h3>
                                <draggable class="flex flex-wrap gap-4 border-2 p-3 rounded border-gray-300 min-h-[30px]" :list="current.matrix_items" group="matrix_sorting" @change="log">
                                    <template v-for="element in current.matrix_items">
                                        <div class="flex items-center border px-2 py-1 rounded border-indigo-400 bg-indigo-300 cursor-grab focus:cursor-grab criterion_image" v-html="element"></div>
                                    </template>
                                </draggable>
                            </div>
                            <div class="flex justify-start" v-for="answer, index in current.answers">
                                <div class="flex flex-col space-y-6 justify-center">
                                    <div class="flex items-center justify-center border-2 border-indigo-400 w-[5rem] h-[5rem] rounded-lg">
                                        <div class="p-1 w-[5rem]" v-if="answer.criterion.image_name != null" v-html="answer.criterion.value">
                                        </div>
                                        <div class="py-5 px-6" v-else>
                                            <span v-html="answer.criterion.value"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col space-y-28 justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                                        <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
                                    </svg>
                                </div>
                                <div class="flex flex-col space-y-6 justify-center">
                                    <draggable class="flex flex-wrap items-center border-2 border-indigo-400 min-h-[5rem] min-w-[12rem] rounded-lg space-x-2 p-3" :list="selected_answer.matrix_sorting[index]" group="matrix_sorting" @change="log">
                                        <template v-for="element in selected_answer.matrix_sorting[index]">
                                            <div class="flex items-center border px-2 py-1 rounded border-indigo-400 bg-indigo-300 cursor-grab focus:cursor-grab criterion_image" v-html="element"></div>
                                        </template>
                                    </draggable>
                                </div>
                            </div>
                            <div class="flex flex-row justify-center">
                                <BreezeButton @click="saveMatrixSorting()">Confirm Answers</BreezeButton>
                            </div>
                        </div>
                        <div class="flex flex-col space-y-10" v-if="current.question_type == 4">
                            <div class="border-4 border-gray-400 p-3 w-full rounded-lg shadow-xl flex flex-wrap items-center justify-center md:p-5">
                                <h1 class="text-left font-mono font-bold text-sm sm:text-lg space-y-2 leading-loose whitespace-pre-line">
                                    <template v-for="(part, index) in sentence_parts" :key="index">
                                        <input v-if="part.input" type="text" v-model="part.answer" :style="[part.answer.length < 2 ? 'width: 2.6rem': 'width: ' + (part.answer.length * 1 + 2) + 'rem']" class="text-center h-8 sm:h-10 focus:ring-0 focus:border-indigo-300 font-mono font-bold rounded-md text-sm sm:text-lg border-gray-300 tracking-widest">
                                        <template v-else>
                                            {{ part.text }}
                                        </template>
                                    </template>
                                </h1>
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
</template>

<script>
import { defineComponent } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { Head, Link  } from '@inertiajs/inertia-vue3'
import { VueDraggableNext  } from 'vue-draggable-next'
import Chart from 'chart.js/auto'
import axios from 'axios'

export default {
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
            submitting: false,
            can_go_higher: true,
            can_go_lower: true,
            chart_info: [],
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
            answer: '',
            correct: false,
            current: {
                question: '',
                question_type: '',
                question_image: '',
                remarks: '',
                criterions: [],
                answers: [],
                score: 0,
                answer_records: [],
                matrix_items: [],
                matrix_sequence: []
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
                dt_title: '',
                student_name: this.form_data.name,
                student_age: this.form_data.age,
                student_school: this.form_data.school,
                parent_name: '',
                parent_contact: '',
                parent_area_location: '',
                parent_email: '',
                answer_record: [],
                eligible_level: '',
                language_id: this.$page.props.language_id,
                has_edu_teacher_email: false,
                edu_teacher_email: '',
            },
            error:{
                parent_name: false,
                parent_contact: false,
                parent_area_location: false,
                parent_email: false,
            },
            chart_data: [1, 2, 3]
        }
    },
    methods: {
        restrictToNumbers() {
            // Remove non-numeric characters from the input
            this.form.parent_contact = this.form.parent_contact.replace(/\D/g, "");

            // You can add additional validation logic here if needed
            // For example, check if the input is a valid phone number, etc.
        },
        clearAllAnswers(){
            this.selected_answer.single_choice = '',
            this.selected_answer.multiple_choices = []
            this.resetFillInBlank()
            this.answer = ''
            this.correct = false
        },
        pushAnswer(){
            if(this.dt_list[this.dt_index]){
                this.form.answer_record.push({
                    'dt_id' : this.dt_list[this.dt_index].dt_id,
                    'question_id' : this.dt_list[this.dt_index].id,
                    'question_category_id' : this.dt_list[this.dt_index].category_id,
                    'question' : this.dt_list[this.dt_index].question,
                    'correct' : this.correct,
                    'answer' : this.answer
                })
                this.current.answer_records.push({
                    'dt_id' : this.dt_list[this.dt_index].dt_id,
                    'question_id' : this.dt_list[this.dt_index].id,
                    'question_category_id' : this.dt_list[this.dt_index].category_id,
                    'question' : this.dt_list[this.dt_index].question,
                    'correct' : this.correct,
                    'answer' : this.answer
                })
                this.dt_index += 1
            }
        },
        saveSingleChoice(selected_answer){
            this.selected_answer.single_choice  =   selected_answer
            this.answer                         =   selected_answer
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
                const correct    =   this.checkIfArrayMatch(this.selected_answer.multiple_choices, this.dt_list[this.dt_index].correct_answer.map(Number))
                if(correct){
                    this.current.score += 1
                    this.correct = true
                }
                this.answer = this.selected_answer.multiple_choices
                this.pushAnswer()
            }
        },
        saveMatrixSorting(){
            var correct   =  this.checkMatrixSortingAnswer()
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
        checkMatrixSortingAnswer(){
            var matrix_answers  =   []
            var item_count      =   0

            this.current.matrix_sequence.map((item)=>{
                item.map(()=>{
                    item_count++
                })
            })

            this.selected_answer.matrix_sorting.map((matrix_sorting_item, index)=>{
                matrix_sorting_item.map((item)=>{
                    if(!this.current.matrix_sequence[index].includes(item)){
                        matrix_answers.push(false)
                    }
                    else{
                        matrix_answers.push(true)
                    }
                })
            })

            if(matrix_answers.length == item_count){
                if(matrix_answers.includes(false)){
                    
                }
                else{
                    return true
                }
            }
            return false
            
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
            const answer    =   []
            this.sentence_parts.forEach((items)=>{
                if(items.input){
                    answer.push(items.answer)
                }
            })
            this.answer = answer
            if(this.sentence_parts.every(this.partIsCorrect) && this.inputAnswersUnique(this.sentence_parts)){
                this.current.score += 1
                this.correct = true
            }
            this.pushAnswer()
        },
        partIsCorrect (part) {
            const answer = part.answer.replace(/\s+/g, ' ').trim()  
            const answer_matched     =    part.text.includes(answer)
            return !part.input || (Array.isArray(part.text) && part.text.length !== 0) === answer_matched
        },
        inputAnswersUnique(sentenceParts) {
            const inputParts = sentenceParts.filter(part => part.input);

            const uniqueAnswers = new Set(inputParts.map(part => part.answer));
            
            return uniqueAnswers.size === inputParts.length;
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
                    text: isInput ? segment.slice(1, -1).split('|') : segment
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
                this.current.answer_records = []
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
            
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            this.error.parent_name          = this.form.parent_name === ''
            this.error.parent_contact       = this.form.parent_contact === ''
            this.error.parent_area_location = this.form.parent_area_location === ''
            this.error.parent_email         = this.form.parent_email === '' || !emailRegex.test(this.form.parent_email);

            for (const key in this.error) {
                if (this.error[key] === true) {
                    return;
                }
            }

            this.submitting = true
            this.form.dt_title = this.$page.props.dt_details.name
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

            const result = combined.reduce((acc, question) => {
                if (question.correct) {
                    acc[question.question_category_id] = (acc[question.question_category_id] || 0) + 1;
                } else if (!acc.hasOwnProperty(question.question_category_id)) {
                    // Initialize with 0 if not present
                    acc[question.question_category_id] = null;
                }
                return acc;
            }, {});
            
            const finalScores = [];
            Object.keys(result).forEach((key, index) => {
                finalScores[index] = result[key];
            });
            Object.values(finalScores)

            this.chart_data = finalScores
            this.initChart()

            if(this.dt_details.chart_id == 1){
                this.chart_info         = this.$page.props.diagnostic_test_chart_info.filter(item => item.chart_id === this.dt_details.chart_id);
                this.show_bar_chart     = true
                this.show_scatter_chart = false
            }
            else{
                this.chart_info         = this.$page.props.diagnostic_test_chart_info.filter(item => item.chart_id === this.dt_details.chart_id);
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
                        data: [
                            { x: this.chart_data[0] ? this.chart_data[0] : 0, y: this.chart_data[1] ? this.chart_data[1] : 0 }
                        ],
                        label: "Test",
                        borderColor: "rgba(255, 8, 0, 1)",
                        pointStyle: 'crossRot',
                        radius: 10,
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
                        },
                        datalabels: {
                            display: false, // This line controls the display of data labels
                        },
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
                            },
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
                            },
                        }
                    },
                    ticks: {
                        precision:0
                    },
                    layout: {
                        padding: {
                            top: 5
                        }
                    },
                    clip: false,
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
                        this.chart_data = []
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
                                this.form.eligible_level = this.dt_details.id
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
                        this.clearAllAnswers()
                        if(this.current.question_type == 3){
                            this.current.criterions     = this.dt_list[this.dt_index].answers.criterion ? this.dt_list[this.dt_index].answers.criterion : ''
                            //reset sort items and matrix sequence
                            this.current.matrix_items   = []
                            this.current.matrix_sequence =   []
                            //gather all sort items
                            this.dt_list[this.dt_index].answers.map((question, index)=>{
                                var matrix_images    =   question.element.value.split(", ");
                                matrix_images.map((image)=>{
                                    this.current.matrix_items.push(image)
                                    this.shuffleArray(this.current.matrix_items)
                                })
                                this.current.matrix_sequence[index]  =   matrix_images
                                this.selected_answer.matrix_sorting[index]  =   []
                            })
                        }
                    }
                }
            },
            immediate: true
        }
    },
}
</script>
                                