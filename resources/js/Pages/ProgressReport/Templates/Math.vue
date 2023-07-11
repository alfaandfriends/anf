<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<style>
.multiselect-assistive-text{
    display: none;
}
.date-picker{
    border-width: 1px; 
    border-color: #D1D5DB;
    border-radius: 0.4rem;  
}
:hover.date-picker  {
    border-color: #D1D5DB; 
}
</style>

<template>
    <Head title="Progress Report" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 bg-indigo-50 space-y-6 sm:p-6">
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <StudentInformation></StudentInformation>
                            </div>
                        </div>
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="font-bold text-indigo-800 self-end">Progress Report Listing</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="overflow-x-auto">
                                            <table class="table-auto min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-300">
                                                    <tr>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">Date</th>
                                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">Status</th>
                                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    <tr v-if="!$page.props.progress_reports.length">
                                                        <td class="text-center" colspan="10">
                                                            <div class="p-3">
                                                                No Record Found! 
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="hover:bg-gray-200" v-for="(result, index) in $page.props.progress_reports" :key="result.report_id">
                                                        <td class="px-4 py-2 whitespace-nowrap">
                                                            <div class="text-sm font-medium text-gray-700">
                                                                {{ moment(result.date).format('DD/MM/Y') }}
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                            <span class="inline-flex items-center justify-center px-2 py-1 text-xs rounded" :class="result.attendance_status_class_name">{{ result.attendance_status_name }}</span>
                                                            
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                            <BreezeButton buttonType="blue" @click="viewProgressReport(index)">View / Update</BreezeButton>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <Modal :modalType="'lg'" :showModal="show_progress_report" @hideModal="show_progress_report = false">
            <template v-slot:header>
                <h3 class="text-gray-900 text-xl font-semibold">                
                    Update Progress Report
                </h3>                
            </template>
            <template v-slot:content>
                <div class="p-6 overflow-y-auto no-scrollbar">
                    <div class="grid grid-rows-1">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-3">
                                <label for="title" class="block text-sm font-bold text-gray-700"> Date </label>
                                <div class="mt-1 flex rounded-md.shadow-sm">
                                    <Datepicker :class="'w-full rounded-lg shadow-sm'" 
                                                :style="$page.props.errors.date ? '--dp-border-color: #fa9e9e' : '--dp-border-color: #cccccc'" 
                                                :enableTimePicker="false"
                                                :auto-apply="true" 
                                                :placeholder="'Select Date'" 
                                                :format="'dd/MM/yyyy'"
                                                v-model="form.date" 
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1">
                            <hr class="my-4">
                        </div>
                        <div class="grid grid-cols-4 gap-4">
                            <div class="mb-3">
                                <label for="title" class="block text-sm font-bold text-gray-700"> Term / Book </label>
                                <div class="mt-1 flex rounded-md.shadow-sm">
                                    <Multiselect 
                                        @select="getUnits(search.term_book_id)"
                                        v-model="search.term_book_id"
                                        valueProp="id"
                                        :appendNewOption="false"
                                        :searchable="true"
                                        :options="$page.props.math_terms_books"
                                        :clearOnSelect="false"
                                        :canClear="false"
                                        :canDeselect="false"
                                        trackBy="name"
                                        label="name"
                                        :loading="loading.terms_books"
                                        placeholder="Please Select"
                                        :classes="{
                                            container: 'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer rounded-sm bg-white text-base leading-snug border-gray-300' ,
                                            containerDisabled: 'cursor-not_allowed bg-gray-100 border focus:border-gray-200 h-10',
                                            containerOpen: 'rounded-b-none',
                                            containerOpenTop: 'rounded-t-none',
                                            containerActive: 'border border-gray-300',
                                            search: 'w-full absolute inset-0 border-gray-300 focus:outline-none focus:border-transparent focus:ring-0 appearance-none text-base font-sans bg-white rounded-sm',
                                            dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                            dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                                            dropdownHidden: 'hidden',
                                            options: 'flex flex-col p-0 m-0 list-none w-full',
                                            optionsTop: 'flex-col-reverse',
                                            option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3 text-sm',
                                            optionPointed: 'text-gray-800 bg-gray-100',
                                            optionSelected: 'text-white bg-indigo-500',
                                            optionDisabled: 'text-gray-300 cursor-not-allowed',
                                            optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                                            optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                                            noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                                            noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                                        }"
                                    />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="block text-sm font-bold text-gray-700"> Unit </label>
                                <div class="mt-1 flex rounded-md.shadow-sm">
                                    <Multiselect 
                                        @select="getLessons(search.unit_id)"
                                        v-model="search.unit_id"
                                        valueProp="id"
                                        :appendNewOption="false"
                                        :searchable="true"
                                        :options="options.units"
                                        :disabled="disabled.units"
                                        :clearOnSelect="false"
                                        :canClear="false"
                                        :canDeselect="false"
                                        trackBy="name"
                                        label="name"
                                        :loading="loading.units"
                                        placeholder="Please Select"
                                        :classes="{
                                            container: 'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer rounded-sm bg-white text-base leading-snug border-gray-300' ,
                                            containerDisabled: 'cursor-not_allowed bg-gray-100 border focus:border-gray-200 h-10',
                                            containerOpen: 'rounded-b-none',
                                            containerOpenTop: 'rounded-t-none',
                                            containerActive: 'border border-gray-300',
                                            search: 'w-full absolute inset-0 border-gray-300 focus:outline-none focus:border-transparent focus:ring-0 appearance-none text-base font-sans bg-white rounded-sm',
                                            dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                            dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                                            dropdownHidden: 'hidden',
                                            options: 'flex flex-col p-0 m-0 list-none w-full',
                                            optionsTop: 'flex-col-reverse',
                                            option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3 text-sm',
                                            optionPointed: 'text-gray-800 bg-gray-100',
                                            optionSelected: 'text-white bg-indigo-500',
                                            optionDisabled: 'text-gray-300 cursor-not-allowed',
                                            optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                                            optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                                            noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                                            noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                                        }"
                                    />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="block text-sm font-bold text-gray-700"> Lesson </label>
                                <div class="mt-1 flex rounded-md.shadow-sm">
                                    <Multiselect 
                                        :option-height="104" :custom-label="customLabel"
                                        v-model="search.lesson_id"
                                        valueProp="id"
                                        :appendNewOption="false"
                                        :searchable="true"
                                        :options="options.lessons"
                                        :clearOnSelect="false"
                                        :canClear="false"
                                        :canDeselect="false"
                                        trackBy="name"
                                        label="name"
                                        :disabled="disabled.lessons"
                                        placeholder="Please Select"
                                        :loading="loading.lessons"
                                        :classes="{
                                            container: 'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer rounded-sm bg-white text-base leading-snug border-gray-300' ,
                                            containerDisabled: 'cursor-not-allowed bg-gray-100 border focus:border-gray-200 h-10',
                                            containerOpen: 'rounded-b-none',
                                            containerOpenTop: 'rounded-t-none',
                                            containerActive: 'border border-gray-300',
                                            search: 'w-full absolute inset-0 border-gray-300 focus:outline-none focus:border-transparent focus:ring-0 appearance-none text-base font-sans bg-white rounded-sm',
                                            dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                            dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                                            dropdownHidden: 'hidden',
                                            options: 'flex flex-col p-0 m-0 list-none w-full',
                                            optionsTop: 'flex-col-reverse',
                                            option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3 text-sm',
                                            optionPointed: 'text-gray-800 bg-gray-100',
                                            optionSelected: 'text-white bg-indigo-500',
                                            optionDisabled: 'text-gray-300 cursor-not-allowed',
                                            optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                                            optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                                            noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                                            noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                                        }"
                                    >
                                        <template slot="singleLabel" slot-scope="props">
                                            <img class="option__image" :src="'https://picsum.photos/200'" alt="No Man’s Sky">
                                            <span class="option__desc">
                                                <span class="option__title">{{ options.lessons.id }}</span>
                                            </span>
                                            </template>
                                        <template slot="option" slot-scope="props">
                                            <img class="option__image" :src="'https://picsum.photos/200'" alt="No Man’s Sky">
                                        <div class="option__desc"><span class="option__title">{{ options.lessons.id }}</span><span class="option__small">{{ options.lessons.id }}</span></div>
                                        </template>
                                    </Multiselect>
                                </div>
                            </div>
                            <div class="flex self-end">
                                <div class="mb-3">
                                    <label for="" class="block text-sm font-bold text-gray-700"> </label>
                                    <div class="mt-1 flex rounded-md.shadow-sm">
                                        <BreezeButton class="py-3 px-4" buttonType="info" @click="addItem">Add</BreezeButton>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 py-3">
                            <div class="mb-3">
                                <label for="title" class="block text-sm font-bold text-gray-700"> Objectives </label>
                            </div>
                            <div class="grid grid-cols-1 py-3" v-if="!form.report_data">
                                <div class="flex justify-center py-4 items-center space-x-2" v-if="loading.objectives">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-repeat animate-spin" viewBox="0 0 16 16">
                                        <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                        <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                        </svg>
                                        <span>Loading...</span>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 divide-y divide-neutral-200 border-x border-t border-b mb-3" v-else>
                                <div class="p-3 bg-gray-50" v-if="!form.report_data.length">No objectives found.</div>
                                <div class="p-5 bg-gray-50 hover:bg-gray-100" v-for="data, index in form.report_data">
                                    <details class="group space-y-4">
                                        <summary class="flex justify-between items-center font-medium cursor-pointer list-none">
                                            <div class="ml-2 text-sm">
                                                <div class="flex space-x-4">
                                                    <label for="helper-checkbox" class="font-medium text-gray-900">{{ data.unit_name }}</label>
                                                    <label class="font-medium text-red-500 hover:text-red-600 cursor-pointer" @click="deleteItem(index)">Delete</label>
                                                </div>
                                                <p id="helper-checkbox-text" class="text-xs font-normal text-gray-500">{{ data.lesson_name }}</p>
                                            </div>
                                            <span class="transition group-open:rotate-180">
                                                <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path>
                                                </svg>
                                            </span>
                                        </summary>
                                        <ul class="text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg">
                                            <li class="w-full border-b border-gray-200 rounded-t-lg" v-for="objective, objective_index in data.objectives">
                                                <div class="flex items-center pl-3">
                                                    <input :id="objective.id" type="checkbox" :value="objective.id" v-model="form.report_data[index].objectives[objective_index].achieved" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-gray-300 focus:ring-0">
                                                    <label :for="objective.id" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 cursor-pointer">{{ objective.name }}</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </details>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1">
                            <div class="mb-3">
                                <label for="title" class="block text-sm font-bold text-gray-700"> Comments </label>
                                <div class="mt-1 flex rounded-md.shadow-sm">
                                    <textarea class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" rows="4" v-model="form.comments"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-3">
                                <label for="title" class="block text-sm font-bold text-gray-700"> Status </label>
                                <div class="mt-1 flex rounded-md.shadow-sm">
                                    <select name="attendance_status" id="attendance_status" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.attendance_status ? 'border-red-300' : 'border-gray-300'" v-model="form.attendance_status" autocomplete="off">
                                        <option :value="attendance_status.id" v-for="attendance_status, index in $page.props.attendance_status">{{ attendance_status.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot:footer>
                <div class="flex justify-end space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                    <BreezeButton buttonType="gray" @click="show_progress_report = false">Cancel</BreezeButton>
                    <BreezeButton @click="updateProgressReport">Save</BreezeButton>
                </div>
            </template>
        </Modal>
    </BreezeAuthenticatedLayout>
</template>

<script>

import { Head, Link } from '@inertiajs/inertia-vue3';
import StudentInformation from '@/Pages/ProgressReport/Templates/StudentInformation.vue';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import Modal from '@/Components/Modal.vue'
import moment from 'moment';
import axios from 'axios';
import Multiselect from '@vueform/multiselect'

export default {
    components: {
        Head, Link, Datepicker, Modal, Multiselect, 
    },
    data(){
        return{
            show_progress_report: false,
            objectives_not_found: false,
            progress_report_list: {},
            disabled:{
                terms_books: true,
                units: true,
                lessons: true,
            },
            options: {
                terms_books: [],
                units: [],
                lessons: [],
                objectives: [],
            },
            loading: {
                terms_books: false,
                units: false,
                lessons: false,
                objectives: false,
            },
            search: {
                term_book_id: '',
                unit_id: '',
                lesson_id: '',
            },
            form: {
                date: '',
                report_data: '',
                comments: '',
                attendance_status: '',
            }
        }
    },
    methods: {
        viewProgressReport(index) {
            this.form.report_id             =   this.$page.props.progress_reports[index].id
            this.form.date                  =   this.$page.props.progress_reports[index].date
            this.form.report_data           =   JSON.parse(this.$page.props.progress_reports[index].report_data)
            this.form.attendance_status     =   this.$page.props.progress_reports[index].attendance_status
            this.form.comments              =   this.$page.props.progress_reports[index].comments
            this.show_progress_report       =   true;
        },
        updateProgressReport() {
            this.$inertia.post(route('progress_report.store_math'), this.form, {
            onBefore: visit => {
                // this.show_progress_report = false
            },
            preserveScroll: true,
            preserveState: false,
            });
        },
        getUnits(term_book_id) {
            this.loading.units = true;

            this.disabled.units = true;
            this.disabled.lessons = true;

            this.options.units = [];
            this.options.lessons = [];
            
            this.search.unit_id = '';
            this.search.lesson_id = '';

            axios.get(route('progress_report.get_math_units', term_book_id))
            .then(response => {
                this.options.units  =   response.data
                this.disabled.units = false;
                this.loading.units = false;
            });
        },
        getLessons(unit_id) {
            this.loading.lessons = true;
            
            this.disabled.lessons = true;

            this.options.lessons = [];

            this.search.lesson_id = '';

            axios.get(route('progress_report.get_math_lessons', unit_id))
            .then(response => {
                this.options.lessons = response.data;
                this.disabled.lessons = false;
                this.loading.lessons = false;
            });
        },
        addItem() {
            if(this.search.term_book_id && this.search.unit_id && this.search.lesson_id) {
                const objectives_exists =  this.form.report_data.find(item => item.lesson_id === this.search.lesson_id)
                console.log(objectives_exists)
                if(objectives_exists){
                    alert('You already added this lesson!')
                    return
                }
                axios.get(route('progress_report.get_math_objectives', this.search.lesson_id))
                .then(response => {
                    const new_item  =   {
                        term_book_id: this.search.term_book_id,
                        term_book_name: this.$page.props.math_terms_books.find(item => item.id === this.search.term_book_id)?.name,
                        unit_id: this.search.unit_id,
                        unit_name: this.options.units.find(item => item.id === this.search.unit_id)?.name,
                        lesson_id: this.search.lesson_id,
                        lesson_name: this.options.lessons.find(item => item.id === this.search.lesson_id)?.name,
                        objectives: []
                    }
                    const initialLength     =   this.form.report_data.length
                    const test              =   this.form.report_data.push(new_item)
                    const addedItemIndex    =   initialLength;
                    const addedItem         =   this.form.report_data[addedItemIndex];
                            
                    response.data.forEach(data => {
                        addedItem.objectives.push({
                            id: data.id,
                            name: data.name,
                            achieved: false
                        })
                    })
                });
            }
        },
        deleteItem(index) {
            this.form.report_data.splice(index, 1);
        },
        customLabel ({ title, desc }) {
            return `${title} - ${desc}`
        }
    },
}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>