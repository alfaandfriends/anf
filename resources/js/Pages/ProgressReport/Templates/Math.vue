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
    <Head title="Art Gallery" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 bg-indigo-50 space-y-6 sm:p-6">
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="font-bold text-indigo-800">Information</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <dl class="divide-y divide-gray-100">
                                        <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6 text-gray-900">Child's Name:</dt>
                                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">Dhiya Rania Alayna Binti Muhammad Eqbal (8)</dd>
                                        </div>
                                        <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6 text-gray-900">Date Joined</dt>
                                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">May 2022</dd>
                                        </div>
                                        <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6 text-gray-900">Class Type / Level address</dt>
                                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">ANF Maths (Level 2)</dd>
                                        </div>
                                        <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6 text-gray-900">Teacher</dt>
                                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">Hazma Syarihan binti Mohamed Rafique</dd>
                                        </div>
                                    </dl>
                                </div>
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
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">Term / Book</th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">Unit</th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">Lesson</th>
                                                        <!-- <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">Assessments through Observations</th> -->
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
                                                                {{ moment(progress_report_list[result.id].date).format('DD/MM/Y') }}
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm font-medium text-gray-700">
                                                                {{ findTermBook(result.id) }}
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm font-medium text-gray-700">
                                                                {{ findUnit(result.id) }}
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm font-medium text-gray-700">
                                                                {{ findLesson(result.id) }}
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                            <span class="inline-flex items-center justify-center px-2 py-1 text-xs rounded" :class="attendanceStatusColor(result.id)">{{ attendanceStatus(result.id) }}</span>
                                                            
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                            <BreezeButton buttonType="blue" @click="viewProgressReport(result.id)">Update</BreezeButton>
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
        <Modal :showModal="show_progress_report" @hideModal="show_progress_report = false">
            <template v-slot:header>
                <h3 class="text-gray-900 text-xl font-semibold">                
                    Update Progress Report
                </h3>                
            </template>
            <template v-slot:content>
                <div class="p-5 overflow-y-auto">
                    <div class="grid grid-rows-1">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-3">
                                <label for="title" class="block text-sm font-bold text-gray-700"> Date </label>
                                <div class="mt-1 flex rounded-md.shadow-sm">
                                    <Datepicker :class="'w-full rounded-lg shadow-sm'" 
                                                :style="$page.props.errors.end_time ? '--dp-border-color: #fa9e9e' : ''" 
                                                input-class-name="date-picker"
                                                :enableTimePicker="false"
                                                :auto-apply="true" 
                                                :placeholder="'Select Date'" 
                                                :format="'dd/MM/yyyy'"
                                                :model-value="form.date" 
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-3">
                                <label for="title" class="block text-sm font-bold text-gray-700"> Term / Book </label>
                                <div class="mt-1 flex rounded-md.shadow-sm">
                                    <select name="math_term_book_id" id="math_term_book_id" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.math_term_book_id ? 'border-red-300' : 'border-gray-300'" v-model="form.term_book_id" autocomplete="off">
                                        <option :value="math_term_book.id" v-for="math_term_book, index in $page.props.math_terms_books">{{ math_term_book.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="block text-sm font-bold text-gray-700"> Unit </label>
                                <div class="mt-1 flex rounded-md.shadow-sm">
                                    <select name="math_unit_id" id="math_unit_id" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.math_unit_id ? 'border-red-300' : 'border-gray-300'" v-model="form.unit_id" autocomplete="off">
                                        <option :value="math_unit.id" v-for="math_unit, index in $page.props.math_units">{{ math_unit.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-3">
                                <label for="title" class="block text-sm font-bold text-gray-700"> Lesson </label>
                                <div class="mt-1 flex rounded-md.shadow-sm">
                                    <select name="math_lesson_id" id="math_lesson_id" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.math_lesson_id ? 'border-red-300' : 'border-gray-300'" v-model="form.lesson_id" autocomplete="off">
                                        <option :value="math_lesson.id" v-for="math_lesson, index in $page.props.math_lessons">{{ math_lesson.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1">
                            <div class="mb-3">
                                <label for="title" class="block text-sm font-bold text-gray-700"> Assessments through Observations </label>
                                <div class="mt-1 flex rounded-md.shadow-sm">
                                    <textarea class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" rows="4" v-model="form.assessment"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2">
                            <div class="mb-3">
                                <label for="title" class="block text-sm font-bold text-gray-700"> Status </label>
                                <div class="mt-1 flex rounded-md.shadow-sm">
                                    <select name="attendance_status" id="attendance_status" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.attendance_status ? 'border-red-300' : 'border-gray-300'" v-model="form.attendance_status" autocomplete="off" @change="updateAttendanceStatus(result.id)">
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
                    <BreezeButton @click="show_progress_report = false">Save</BreezeButton>
                </div>
            </template>
        </Modal>
    </BreezeAuthenticatedLayout>
</template>

<script>

import { Head, Link } from '@inertiajs/inertia-vue3';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import Modal from '@/Components/Modal.vue'
import moment from 'moment';

export default {
    components: {
        Head, Link, Datepicker, Modal, 
    },
    data(){
        return{
            show_progress_report: false,
            progress_report_list: {},
            form:{
                date: '',
                term_book_id: '',
                unit_id: '',
                lesson_id: '',
                assessment: '',
                attendance_status: '',
            }
        }
    },
    methods: {
        findTermBook(report_id){
            const term_book = this.$page.props.math_terms_books.find((term_book) => term_book.id == this.progress_report_list[report_id].math_term_book_id)
            return term_book ? term_book.name : '';
        },
        findUnit(report_id){
            const unit = this.$page.props.math_units.find((unit) => unit.id == this.progress_report_list[report_id].math_unit_id)
            return unit ? unit.name : '';
        },
        findLesson(report_id){
            const lesson = this.$page.props.math_lessons.find((lesson) => lesson.id == this.progress_report_list[report_id].math_lesson_id)
            return lesson ? lesson.name : '';
        },
        attendanceStatus(report_id){
            const status = this.$page.props.attendance_status.find((status) => status.id == this.progress_report_list[report_id].attendance_status)
            return status ? status.name : '';
        },
        attendanceStatusColor(report_id){
            const status    = this.$page.props.attendance_status.find((status) => status.id == this.progress_report_list[report_id].attendance_status)
            var color
            if(status.id == 1){
                color = 'text-green-100 bg-green-600'
            }
            if(status.id == 2){
                color = 'text-red-100 bg-red-600'
            }
            if(status.id == 3){
                color = 'text-gray-700 bg-gray-300'
            }
            return color
        },
        viewProgressReport(report_id){
            this.form.date = this.progress_report_list[report_id].date
            this.form.term_book_id = this.progress_report_list[report_id].math_term_book_id
            this.form.unit_id = this.progress_report_list[report_id].math_unit_id
            this.form.lesson_id = this.progress_report_list[report_id].math_lesson_id
            this.form.assessment = this.progress_report_list[report_id].math_assessment
            this.form.attendance_status = this.progress_report_list[report_id].attendance_status
            this.show_progress_report = true
        },
        // updateDate(report_id) {
        //     console.log(this.progress_report_list[report_id].date)
        //     if(this.progress_report_list[report_id].date != ''){
        //         this.$inertia.post(route('progress_report.details.update_date'), {'report_id' : report_id, 'date' : this.progress_report_list[report_id].date}, { preserveState: true})
        //     }
        // },
        // updateAttendanceStatus(report_id) {
        //     this.$inertia.post(route('math_manipulatives.configuration.store'), this.form, { preserveState: true})
        // }
    },
    created(){
        this.$page.props.progress_reports.forEach(item => {
            this.progress_report_list[item.id]  =   {
                'id' : item.id,
                'date' : item.date,
                'math_term_book_id' : item.math_term_book_id,
                'math_unit_id' : item.math_unit_id,
                'math_lesson_id' : item.math_lesson_id,
                'math_assessments' : item.math_assessments,
                'coding_lesson_id' : item.coding_lesson_id,
                'coding_module_id' : item.coding_module_id,
                'coding_assessments' : item.coding_assessments,
                'digital_art_lesson_id' : item.digital_art_lesson_id,
                'digital_art_objectives_id' : item.digital_art_objectives_id,
                'digital_art_assessments' : item.digital_art_assessments,
                'attendance_status' : item.attendance_status,
            }
        })
    }
}
</script>