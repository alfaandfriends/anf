<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<style>
.multiselect-assistive-text{
    display: none;
}
.progress-report-date-picker{
    border: 2px solid #D1D5DB; /* Default border color and thickness */
    border-radius: 0.35rem;
}
:hover.progress-report-date-picker  {
    border: 2px solid #D1D5DB; /* Highlighted border color and thickness */
}
:focus.progress-report-date-picker  {
    border: 2px solid #D1D5DB; /* Highlighted border color and thickness */
}
.date-picker{
    border: 1px solid #D1D5DB; /* Default border color and thickness */
    border-radius: 0.35rem;
}
:hover.date-picker  {
    border: 1px solid #D1D5DB; /* Highlighted border color and thickness */
}
:focus.date-picker  {
    border: 1px solid #D1D5DB; /* Highlighted border color and thickness */
}
</style>

<template>
    <Head title="Progress Report" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <template v-if="$page.props.can.view_progress_report_settings">
                <div class="flex justify-end">
                    
                    <BreezeButton class="py-2 px-4 space-x-2" :route="route('progress_report.settings')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 512 512">
                        <path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/></svg>
                        <span>Settings</span>
                    </BreezeButton>
                </div>
                <hr class="my-3 border border-dashed border-gray-400">
            </template>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-2 mb-3">
                <div class="relative w-full">
                    <svg class="absolute top-2.5 left-3 h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                        <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <input type="text" class="h-10 border-2 border-gray-300 w-full appearance-none focus:ring-0 focus:border-gray-300 py-1 pl-10 pr-4 text-gray-700 bg-white rounded-md" v-debounce:800ms="search" v-model="params.search">
                </div>
                <div class="w-full">
                    <Multiselect 
                        @select="search"
                        v-model="params.centre_id"
                        valueProp="ID"
                        :appendNewOption="false"
                        :searchable="true"
                        :options="$page.props.allowed_centres"
                        :clearOnSelect="true"
                        :canClear="false"
                        :canDeselect="false"
                        trackBy="label"
                        label="label"
                        placeholder="Centre"
                            :classes="{
                                container: 'relative w-full flex items-center justify-end box-border cursor-pointer border-2 border-gray-300 rounded-md bg-white text-base leading-snug outline-none h-10',
                                containerDisabled: 'cursor-default bg-gray-100',
                                containerOpen: 'rounded-b-none',
                                containerActive: 'border-2 border-gray-300',
                                singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                search: 'w-full mt-1 h-8 absolute inset-0 focus:border-none outline-none focus:ring-0 appearance-none border-2 border-transparent focus:border-gray-300 text-base font-sans bg-white rounded-lg',
                                placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500',
                                clear: 'pr-10 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80 text-gray-800',
                                clearIcon: 'fa fa-heart bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                                spinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0',
                                dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                                dropdownHidden: 'hidden',
                                options: 'flex flex-col p-0 m-0 list-none w-full',
                                group: 'p-0 m-0',
                                groupLabel: 'flex text-sm box-border items-center justify-start text-left py-2 px-3 font-semibold bg-gray-200 cursor-default leading-normal',
                                groupLabelPointable: 'cursor-pointer',
                                groupLabelPointed: 'bg-gray-300 text-black-700',
                                groupLabelSelected: 'bg-gray-100 text-black',
                                groupLabelSelectedPointed: 'bg-gray-100 text-black opacity-90',
                                groupOptions: 'p-0 m-0',
                                option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3',
                                optionPointed: 'text-gray-800 bg-gray-100',
                                optionSelected: 'text-white bg-indigo-500',
                                optionDisabled: 'text-gray-300 cursor-not-allowed',
                                optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                                optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                                noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                                noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                                fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                            }"
                    />
                </div>
                <div class="w-full">
                    <Multiselect 
                        @select="search"
                        @deselect="search"
                        v-model="params.programme_id"
                        valueProp="id"
                        :appendNewOption="false"
                        :searchable="true"
                        :options="$page.props.programmes"
                        :clearOnSelect="true"
                        :canClear="false"
                        :canDeselect="true"
                        trackBy="name"
                        label="name"
                        placeholder="All Programmes"
                            :classes="{
                                container: 'relative w-full flex items-center justify-end box-border cursor-pointer border-2 border-gray-300 rounded-md bg-white text-base leading-snug outline-none h-10',
                                containerDisabled: 'cursor-default bg-gray-100',
                                containerOpen: 'rounded-b-none',
                                containerActive: 'border-2 border-gray-300',
                                singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                search: 'w-full mt-1 h-8 absolute inset-0 focus:border-none outline-none focus:ring-0 appearance-none border-2 border-transparent focus:border-gray-300 text-base font-sans bg-white rounded-lg',
                                placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500',
                                clear: 'pr-10 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80 text-gray-800',
                                clearIcon: 'fa fa-heart bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                                spinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0',
                                dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                                dropdownHidden: 'hidden',
                                options: 'flex flex-col p-0 m-0 list-none w-full',
                                group: 'p-0 m-0',
                                groupLabel: 'flex text-sm box-border items-center justify-start text-left py-2 px-3 font-semibold bg-gray-200 cursor-default leading-normal',
                                groupLabelPointable: 'cursor-pointer',
                                groupLabelPointed: 'bg-gray-300 text-black-700',
                                groupLabelSelected: 'bg-gray-100 text-black',
                                groupLabelSelectedPointed: 'bg-gray-100 text-black opacity-90',
                                groupOptions: 'p-0 m-0',
                                option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3',
                                optionPointed: 'text-gray-800 bg-gray-100',
                                optionSelected: 'text-white bg-indigo-500',
                                optionDisabled: 'text-gray-300 cursor-not-allowed',
                                optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                                optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                                noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                                noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                                fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                            }"
                    >
                        <template #singlelabel="{ value }">
                            <div class="multiselect-single-label">
                                {{ value.name }}
                            </div>
                        </template>
                        <template #option="{ option }">
                            {{ option.name }} ({{ option.country_name }})
                        </template>
                    </Multiselect>
                </div>
                <div class="w-full">
                    <Multiselect 
                        @select="search"
                        @deselect="search"
                        v-model="params.programme_level"
                        valueProp="level"
                        :appendNewOption="false"
                        :searchable="true"
                        :options="$page.props.levels"
                        :clearOnSelect="false"
                        :canClear="false"
                        :canDeselect="true"
                        trackBy="level"
                        label="level"
                        placeholder="All Levels"
                            :classes="{
                                container: 'relative w-full flex items-center justify-end box-border cursor-pointer border-2 border-gray-300 rounded-md bg-white text-base leading-snug outline-none h-10',
                                containerDisabled: 'cursor-default bg-gray-100',
                                containerOpen: 'rounded-b-none',
                                containerActive: 'border-2 border-gray-300',
                                singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                search: 'w-full mt-1 h-8 absolute inset-0 focus:border-none outline-none focus:ring-0 appearance-none border-2 border-transparent focus:border-gray-300 text-base font-sans bg-white rounded-lg',
                                placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500',
                                clear: 'pr-10 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80 text-gray-800',
                                clearIcon: 'fa fa-heart bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                                spinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0',
                                dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                                dropdownHidden: 'hidden',
                                options: 'flex flex-col p-0 m-0 list-none w-full',
                                group: 'p-0 m-0',
                                groupLabel: 'flex text-sm box-border items-center justify-start text-left py-2 px-3 font-semibold bg-gray-200 cursor-default leading-normal',
                                groupLabelPointable: 'cursor-pointer',
                                groupLabelPointed: 'bg-gray-300 text-black-700',
                                groupLabelSelected: 'bg-gray-100 text-black',
                                groupLabelSelectedPointed: 'bg-gray-100 text-black opacity-90',
                                groupOptions: 'p-0 m-0',
                                option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3',
                                optionPointed: 'text-gray-800 bg-gray-100',
                                optionSelected: 'text-white bg-indigo-500',
                                optionDisabled: 'text-gray-300 cursor-not-allowed',
                                optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                                optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                                noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                                noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                                fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                            }">
                            <template #singlelabel="{ value }">
                                <div class="multiselect-single-label">
                                    Level {{ value.level }}
                                </div>
                            </template>
                            <template #option="{ option }">
                                Level {{ option.level }}
                            </template>
                        </Multiselect>
                </div>
                <div class="w-full">
                    <Datepicker :class="'w-full rounded-lg shadow-sm'" 
                                input-class-name="progress-report-date-picker focus:ring-0"
                                v-model="params.date" 
                                format="MMMM yyyy"
                                :month-picker="true" 
                                :auto-apply="true" 
                                :placeholder="'Month / Year'" 
                    />
                </div>
            </div>
            <!-- <hr class="my-3 border border-dashed border-gray-400">
            <div class="grid justify-end mb-3">
                <BreezeButton buttonType="info" @click="showCreateProgressReport()">Add Progress Report</BreezeButton>
            </div> -->
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-300">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">#</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-4/12">Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">Centre</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">Month / Year</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">Total Present</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">Total Absent</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-if="!$page.props.progress_reports.data.length">
                            <td class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found! 
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200" v-for="(result, index) in $page.props.progress_reports.data" :key="result.report_id">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-700">{{ ++index }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col space-y-1 text-sm text-gray-900">
                                    <span class="font-semibold">{{ result.student_name }}</span>
                                    <div class="flex items-center text-sm space-x-2">
                                        <div class="text-xs px-2 py-1 border text-indigo-700 font-semibold border-indigo-500 rounded bg-indigo-200">
                                            {{ result.programme_name }}
                                        </div>
                                        <div class="text-xs px-2 py-1 border text-blue-700 font-semibold border-blue-500 rounded bg-blue-200">
                                            Level {{ result.programme_level }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ result.centre_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ moment(result.month).format('MMMM Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ result.total_present + '/' + result.total_class }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ result.total_absent + '/' + result.total_class }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center space-x-2">
                                    <BreezeButton buttonType="blue" @click="viewProgressReport(result.progress_report_id)" v-if="$page.props.can.view_progress_report">View Details</BreezeButton>
                                    <BreezeButton class="py-1 px-4" @click="showProgressReport(result.progress_report_id, result.student_fee)" v-if="$page.props.can.view_progress_report">{{ generate.id == result.progress_report_id && generate.running ? 'Generating...'  : 'Show / Print'}}</BreezeButton>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination :page_data="$page.props.progress_reports" :params="params"></Pagination>
            </div>
        </div>
        <ConfirmationModal 
            :show="isOpen" 
            @close="isOpen = false"
            confirmationAlert="danger"
            confirmationTitle="Delete Artwork"
            confirmationText="Are you sure want to delete this artwork?"
            confirmationButton="Delete"
            confirmationMethod="delete"
            :confirmationRoute="confirmationRoute"
            :confirmationData="confirmationData"
        />
        <Modal :showModal="show_progress_report" :modalType="'lg'" @hideModal="show_progress_report = false">
            <template v-slot:content>
                <div class="p-6 overflow-y-auto no-scrollbar">
                    <div class="flex justify-center">
                        <component :is="component.file" v-if="component.file" :data="component.data"/>
                    </div>
                </div>
            </template>
            <template v-slot:footer>
                <div class="flex justify-between space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                    <BreezeButton buttonType="info" v-print="'#progress_report'">Print</BreezeButton>
                    <BreezeButton buttonType="gray" @click="show_progress_report = false">Close</BreezeButton>
                </div>
            </template>
        </Modal>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { SearchIcon, TrashIcon, PencilIcon } from '@heroicons/vue/solid'
import { Head, Link } from '@inertiajs/inertia-vue3';
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import Pagination from '@/Components/Pagination.vue'
import moment from 'moment';
import axios from 'axios';
import Multiselect from '@vueform/multiselect'
import Datepicker from '@vuepic/vue-datepicker';
import Modal from '@/Components/Modal.vue'
import print from 'vue3-print-nb'
import { debounce } from 'vue-debounce'
import Toggle from '@vueform/toggle';

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon, Head, Link, ConfirmationModal, Multiselect, Datepicker, Modal, Toggle
    },
    data(){
        return{
            component: {
                file: null,
                data: ''
            },
            generate: {
                id: '',
                running: false,
            },
            printing: false,
            show_progress_report: false,
            show_create_progress_report: false,
            isOpen: false,
            confirmationData: '',
            confirmationRoute: '',
            open_modal: false,
            params: {
                search: this.$page.props.filter.search ? this.$page.props.filter.search : '',
                centre_id: this.$page.props.filter.centre_id ? this.$page.props.filter.centre_id : '',
                programme_id: this.$page.props.filter.programme_id ? this.$page.props.filter.programme_id : '',
                date: this.$page.props.filter.date ? this.$page.props.filter.date : { month: new Date().getMonth(), year: new Date().getFullYear() },
                programme_level: this.$page.props.filter.programme_level ? this.$page.props.filter.programme_level : '',
            },
            form: {
                create_bulk: false,
                student_id: '',
                student_fee_id: '',
                date: '',
                from_date: '',
                to_date: ''
            },
            list: {
                students: [],
                student_fees: []
            },
            loading: {
                students: false,
                student_fees: false
            },
            form_error: {
                student_id: '',
                student_fee_id: ''
            }
        }
    },
    watch:{
        'params.date': {
            handler(){
                this.search()
            },
            deep: true
        },
    },
    methods: {
        viewProgressReport(progress_report_id){
            this.$inertia.get(this.route('progress_report.details'), {'progress_report_id': progress_report_id}, { })
        },
        showProgressReport(progress_report_id, student_fee){
            if(this.generate.running){
                return
            }
            this.generate.running = true
            axios.get(route('progress_report.full_reports'), {
                responseType: 'blob', // Set the response type to 'blob' to handle binary data
                params: {
                    progress_report_id: progress_report_id, 
                    student_fee: student_fee
                }
            })
            .then(response => {
                // Create a Blob object from the response data
                const blob = new Blob([response.data], { type: 'application/pdf' });

                // Create a URL for the Blob object
                const pdfUrl = URL.createObjectURL(blob);

                // Open the PDF in a new tab
                window.open(pdfUrl, '_blank');
                this.generate.running = false
            })
            .catch(error => {
                console.error('Error fetching PDF:', error);
                this.generate.running = false
            });
            // if(this.generate.running){
            //     return
            // }
            // this.generate.id = progress_report_id
            // this.generate.running = true
            // axios.get(route('progress_report.full_reports', {progress_report_id: progress_report_id, student_fee: student_fee}))
            // .then(response => {
            //     import(`./Reports/${response.data.report_template}.vue`)
            //     .then(module => {
            //         this.component.file = module.default;
            //     })
            //     this.component.data = response.data;
            //     this.generate.id = ''
            //     this.generate.running = false
            //     this.show_progress_report = true
            // });
        },
        search(){
            this.$inertia.get(this.route('progress_report'), this.params, { replace: true, preserveState: true})
        },
        showCreateProgressReport(){
            this.show_create_progress_report = true
        },
        findStudents(query){
            debounce(val => '400ms')(10)
            if(query){
                this.loading.students = true
                axios.get(route('students.find'), {
                    params: {
                        'keyword': query
                    }
                })
                .then((res) => {
                    this.list.students = res.data
                    this.loading.students = false
                });
            }
        },
        findStudentFees(){
            this.loading.student_fees = true
            axios.get(route('students.fees', this.form.student_id))
            .then((res) => {
                this.list.student_fees = res.data
                this.loading.student_fees = false
            });
        },
        createProgressReport(){
            this.$inertia.post(route('progress_report.create'), this.form)
        }
    },
    directives: {
        print   
    }
}
</script>