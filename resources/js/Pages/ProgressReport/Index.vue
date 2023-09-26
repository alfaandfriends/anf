<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<style>
.multiselect-assistive-text{
    display: none;
}
.date-picker{
    border-width: 2px; 
    border-color: #D1D5DB;
    border-radius: 0.5rem;  
}
:hover.date-picker  {
    border-color: #D1D5DB; 
}
</style>
<template>
    <Head title="Progress Report" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="mx-auto">
                <div class="align-middle inline-block min-w-full">
                    <div class="flex space-x-2 pb-4 relative text-gray-400 focus-within:text-gray-600 items-center">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-10 w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none">
                                    <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </span>
                            <input type="text" class="h-10 border-2 border-gray-300 w-full appearance-none focus:ring-0 focus:border-gray-300 py-1 pl-10 pr-4 text-gray-700 bg-white border rounded-md" placeholder="Search" v-model="params.search">
                        </div>
                        <div class="flex">
                            <Multiselect 
                                v-model="params.centre_id"
                                valueProp="ID"
                                :appendNewOption="false"
                                :searchable="true"
                                :options="$page.props.allowed_centres"
                                :clearOnSelect="false"
                                :canClear="false"
                                :canDeselect="true"
                                trackBy="label"
                                label="label"
                                placeholder="Centre"
                                    :classes="{
                                        container: 'relative w-full md:w-64 lg:w-64 flex items-center justify-end box-border cursor-pointer border-2 border-gray-300 rounded-lg bg-white text-base leading-snug outline-none h-10',
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
                        <div class="flex">
                            <Multiselect 
                                v-model="params.programme_id"
                                valueProp="id"
                                :appendNewOption="false"
                                :searchable="true"
                                :options="$page.props.programmes"
                                :clearOnSelect="false"
                                :canClear="false"
                                :canDeselect="true"
                                trackBy="name"
                                label="name"
                                placeholder="Programme"
                                    :classes="{
                                        container: 'relative w-full md:w-64 lg:w-64 flex items-center justify-end box-border cursor-pointer border-2 border-gray-300 rounded-lg bg-white text-base leading-snug outline-none h-10',
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
                        <div class="flex">
                            <Multiselect 
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
                                placeholder="Level"
                                    :classes="{
                                        container: 'relative w-full md:w-64 lg:w-64 flex items-center justify-end box-border cursor-pointer border-2 border-gray-300 rounded-lg bg-white text-base leading-snug outline-none h-10',
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
                        <div class="flex">
                            <Datepicker :class="'w-full rounded-lg shadow-sm'" 
                                        :style="$page.props.errors.end_time ? '--dp-border-color: #fa9e9e' : ''" 
                                        input-class-name="date-picker"
                                        v-model="params.date" 
                                        :month-picker="true" 
                                        :auto-apply="true" 
                                        :placeholder="'Month / Year'" 
                            />
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table-auto min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-300">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">#</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-4/12">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">Centre</th>
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
                                            <div class="flex items-center text-sm">
                                                <span class="text-sm text-indigo-600 italic font-semibold">{{ result.programme_name }}</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-600" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                                                  </svg>
                                                <span class="text-sm text-slate-600 font-semibold italic">Level {{ result.programme_level }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ result.centre_name }}</div>
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
                                            <BreezeButton class="py-1 px-2" @click="showProgressReport(result.progress_report_id, result.student_fee)" v-if="$page.props.can.view_progress_report">{{ generate.id == result.progress_report_id && generate.running ? 'Generating...'  : 'Show / Print'}}</BreezeButton>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <Pagination :page_data="$page.props.progress_reports"></Pagination>
                    </div>
                </div>
            </div>
            <!-- </div> -->
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
        </div>
        <Modal :modalType="'md'" :showModal="show_progress_report" @hideModal="show_progress_report = false">
            <!-- <template v-slot:header>
                <h3 class="text-gray-900 text-xl font-semibold">                
                    Progress Report
                </h3>                
            </template> -->
            <template v-slot:content>
                <div class="p-6 overflow-y-auto no-scrollbar">
                    <div class="grid grid-rows-1">
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
import '@vuepic/vue-datepicker/dist/main.css';
import Modal from '@/Components/Modal.vue'
import print from 'vue3-print-nb'

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon, Head, Link, ConfirmationModal, Multiselect, Datepicker, Modal
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
            isOpen: false,
            confirmationData: '',
            confirmationRoute: '',
            open_modal: false,
            params: {
                search: this.$page.props.filter.search ? this.$page.props.filter.search : '',
                centre_id: this.$page.props.filter.centre_id ? this.$page.props.filter.centre_id : '',
                programme_id: this.$page.props.filter.programme_id ? this.$page.props.filter.programme_id : '',
                date: this.$page.props.filter.date ? this.$page.props.filter.date : '',
                programme_level: this.$page.props.filter.programme_level ? this.$page.props.filter.programme_level : '',
            }
        }
    },
    watch: {
        params: {
            handler(){
                if(this.params){
                    this.$inertia.get(this.route('progress_report'), this.params, { replace: true, preserveState: true})
                }
            },
            deep: true
        }
    },
    methods: {
        viewProgressReport(progress_report_id){
            this.$inertia.get(this.route('progress_report.details'), {'progress_report_id': progress_report_id}, { })
        },
        showProgressReport(progress_report_id, student_fee){
            if(this.generate.running){
                return
            }
            this.generate.id = progress_report_id
            this.generate.running = true
            axios.get(route('progress_report.full_reports', {progress_report_id: progress_report_id, student_fee: student_fee}))
            .then(response => {
                import(`./Reports/${response.data.report_template}.vue`)
                .then(module => {
                    this.component.file = module.default;
                })
                this.component.data = response.data;
                this.generate.id = ''
                this.generate.running = false
                this.show_progress_report = true
            });
        },
    },
    directives: {
        print   
    }
}
</script>