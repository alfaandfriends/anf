<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Students" />

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
                                        <h1 class="font-bold text-indigo-800">Admission Information</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="class_name" class="block text-sm font-bold text-gray-700"> Student Name <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md.shadow-sm">
                                                <Multiselect 
                                                    v-debounce="findStudents"
                                                    v-model="form.student_id"
                                                    @close="clearStudents"
                                                    valueProp="id"
                                                    :loading="searching_students"
                                                    placeholder="Please enter some keywords"
                                                    :options="students"
                                                    :searchable="true"
                                                    noOptionsText="Nothing found"
                                                    noResultsText="Nothing found"
                                                    :clearOnSelect="true"
                                                    :canClear="false"
                                                    :canDeselect="false"
                                                    :internal-search="false"
                                                    trackBy="name"
                                                    label="name"
                                                    :classes="{
                                                        container: 
                                                            $page.props.errors.centre_id ? 
                                                            'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-red-300 rounded-md bg-white text-base leading-snug outline-none':
                                                            'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white text-base leading-snug outline-none',
                                                        containerDisabled: 'cursor-default bg-gray-100',
                                                        containerOpen: 'rounded-b-none',
                                                        containerOpenTop: 'rounded-t-none',
                                                        containerActive: 'border border-indigo-300',
                                                        singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                                        singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                                        multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                        search: 'w-full absolute inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-white rounded-md pl-3.5',
                                                        placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-400',
                                                        clear: 'pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80',
                                                        clearIcon: 'bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                                                        dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                                        dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                                                        dropdownHidden: 'hidden',
                                                        options: 'flex flex-col p-0 m-0 list-none w-full',
                                                        optionsTop: 'flex-col-reverse',
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
                                                        fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                                                        spacer: 'h-9 py-px box-content',
                                                    }"
                                                >
                                                </Multiselect>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="centre" class="block text-sm font-bold text-gray-700"> Centre <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md.shadow-sm">
                                                <Multiselect 
                                                    v-model="search_form.centre_id"
                                                    valueProp="ID"
                                                    :searchable="true"
                                                    :options="$page.props.allowed_centres"
                                                    :clearOnSelect="false"
                                                    :canClear="false"
                                                    :canDeselect="false"
                                                    trackBy="label"
                                                    label="label"
                                                    :classes="{
                                                        container: 
                                                            $page.props.errors.centre_id ? 
                                                            'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-red-300 rounded-md bg-white text-base leading-snug outline-none':
                                                            'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white text-base leading-snug outline-none',
                                                        containerDisabled: 'cursor-default bg-gray-100',
                                                        containerOpen: 'rounded-b-none',
                                                        containerOpenTop: 'rounded-t-none',
                                                        containerActive: 'border border-indigo-300',
                                                        singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                                        singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                                        multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                        search: 'w-full absolute inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-white rounded-md pl-3.5',
                                                        placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-400',
                                                        clear: 'pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80',
                                                        clearIcon: 'bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                                                        dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                                        dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                                                        dropdownHidden: 'hidden',
                                                        options: 'flex flex-col p-0 m-0 list-none w-full',
                                                        optionsTop: 'flex-col-reverse',
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
                                                        fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                                                        spacer: 'h-9 py-px box-content',
                                                    }"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="programme" class="block text-sm font-bold text-gray-700"> Programme <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select name="programme" id="programme" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.programme ? 'border-red-300' : 'border-gray-300'" v-model="search_form.programme_id" autocomplete="off">
                                                    <option value="">-- Select Programme --</option>
                                                    <option :value="programme.id" v-for="(programme, index) in programme_list" :key="index">{{ programme.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-0 sm:gap-4">
                                            <div class="mb-4">
                                                <label for="class_type" class="block text-sm font-bold text-gray-700"> Class Type <span class="text-red-500">*</span></label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <select name="class_type" id="class_type" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.class_type ? 'border-red-300' : 'border-gray-300'" v-model="search_form.class_type" autocomplete="off" :disabled="disable_input.class_type">
                                                        <option value="">-- Select Type --</option>
                                                        <option :value="class_type.id" v-for="(class_type, index) in class_types" :key="index">{{ class_type.name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label for="class_level" class="block text-sm font-bold text-gray-700"> Class Level <span class="text-red-500">*</span></label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <select name="class_level" id="class_level" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.class_level ? 'border-red-300' : 'border-gray-300'" v-model="search_form.class_level" autocomplete="off" :disabled="disable_input.class_levels">
                                                        <option value="">-- Select Level --</option>
                                                        <option :value="i.level" v-for="i, index in class_levels" :key="i">{{ i.level }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label for="class_method" class="block text-sm font-bold text-gray-700"> Class Method <span class="text-red-500">*</span></label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <select name="class_method" id="class_method" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.class_method ? 'border-red-300' : 'border-gray-300'" v-model="search_form.class_method" autocomplete="off">
                                                        <option value="">-- Select Method --</option>
                                                        <option :value="method.id" v-for="(method, index) in method_list" :key="index">{{ method.name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-end">
                                        <div class="flex space-x-2">
                                            <BreezeButton @click="findClasses">Search Classes</BreezeButton>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4" ref="available_classes">
                            <div class="sm:row-span-3" v-if="enable_container.available_classes">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="font-bold text-indigo-800">Classes Available</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <div class="shadow overflow-hidden border-b border-gray-200 rounded-t-sm rounded-b-none">
                                                <table class="min-w-full divide-y divide-gray-200">
                                                    <thead class="bg-blue-200">
                                                        <tr class="px-2">
                                                            <th class="px-2 py-1 text-left">#</th>
                                                            <th class="px-2 py-1 text-left">Day</th>
                                                            <th class="px-2 py-1 text-left">Time</th>
                                                            <th class="px-2 py-1 text-left">Capacity</th>
                                                            <th class="px-2 py-1 text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-if="!list.available_classes.data || list.available_classes.total == 0">
                                                            <td colspan="10" class="py-2 text-center">
                                                                <div class="flex justify-center py-4 items-center space-x-2" v-if="searching_classes">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-repeat animate-spin" viewBox="0 0 16 16">
                                                                        <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                                                        <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                                                    </svg>
                                                                    <span>Searching classes...</span>
                                                                </div>
                                                                <span v-if="list.available_classes.total == 0">No classes available</span>
                                                            </td>
                                                        </tr>
                                                        <tr v-else class="hover:bg-gray-200" v-for="classes, index in list.available_classes.data">
                                                            <td class="px-2 py-2 text-left">{{ index + 1 }}</td>
                                                            <td class="px-2 py-2 text-left">{{ classes.class_day}}</td>
                                                            <td class="px-2 py-2 text-left">
                                                                <div class="text-sm font-medium text-gray-900 flex items-center">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                    </svg>
                                                                    <span class="pl-2">{{ moment(classes.start_time, "HH:mm:ss").format('h:mm A') }} - {{ moment(classes.end_time, "HH:mm:ss").format('h:mm A') }}</span>
                                                                </div>
                                                            </td>
                                                            <td class="px-2 py-2 text-left">{{ classes.capacity}}</td>
                                                            <td class="px-2 py-2 text-center">
                                                                <div class="flex justify-center">
                                                                    <BreezeButton v-if="classes.class_type == 1" buttonType="blue" @click="getNormalFee(classes.class_id, index)">Choose</BreezeButton>
                                                                    <input v-else class="h-5 w-5 border border-indigo-300 rounded-sm bg-white focus:ring-offset-0 focus:ring-0 checked:bg-gray focus:bg-white transition duration-200 align-top bg-no-repeat bg-center bg-contain float-left cursor-pointer" 
                                                                            type="checkbox" 
                                                                            @click="getPlusFee($event, classes.class_id, index)">
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
                        </div>
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4" ref="class_fee">
                            <div class="sm:row-span-3" v-if="enable_container.show_fee">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="font-bold text-indigo-800">Fee Information</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="flex p-4 justify-between bg-indigo-100 shadow rounded-md">
                                        <div class="flex flex-row items-center border-b sm:border-b-0 w-full sm:w-auto pb-4 sm:pb-0 space-x-4">
                                            <div class="text-green-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                                    </svg>
                                            </div>
                                            <span class="text-gray-700">{{ form.fee.label }} - {{ form.fee.fee_amount }}</span>
                                        </div>
                                    </div>
                                    <div class="flex pt-4 justify-end">
                                        <BreezeButton buttonType="info" @click="addStudent">Admit Student</BreezeButton>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import Toggle from '@vueform/toggle';
import Multiselect from '@vueform/multiselect'
import moment from 'moment';
import { debounce } from 'vue-debounce'
// import route from 'vendor/tightenco/ziggy/src/js';

export default {
    components: {
        Head, Link, Datepicker, Toggle, Multiselect
    },
    props: {
        programme_list: Object,
        method_list: Object,
        centre_id: String,
    },
    data(){
        return{
            class_types: [],
            class_levels: [],
            students: [],
            fee_info: {
            },
            selected_class_count: 0,
            searching_students: false,
            searching_classes: false,
            disable_input: {
                class_type: true,
                class_levels: true,
            },
            enable_container:{
                available_classes: false,
                show_fee: false,
            },
            list: {
                available_classes: [],
            },
            search_form:{
                centre_id: this.centre_id ? this.centre_id : '',
                programme_id: '',
                class_type: '',
                class_level: '',
                class_method: '',
            },
            form: {
                student_id: '',
                centre_id: this.centre_id ? this.centre_id : '',
                fee: [],
                classes: [],
            }
        }
    },
    watch: {
        'search_form.programme_id': {
            handler(){
                if(this.search_form.programme_id){
                    this.disable_input.class_type = true
                    this.disable_input.class_levels = true
                    this.search_form.class_type = ''
                    this.search_form.class_level = ''
                    axios.get(route('classes.get_class_types'), {
                        params: {
                            'programme_id': this.search_form.programme_id,
                        }
                    })
                    .then((response) => {
                        this.class_types = response.data
                        this.disable_input.class_type = false
                    })
                }
            },
            deep: true
        },
        'search_form.class_type': {
            handler(){
                if(this.search_form.programme_id && this.search_form.class_type){
                    this.disable_input.class_levels = true
                    this.search_form.class_level = ''
                    axios.get(route('classes.get_class_levels'), {
                        params: {
                            'programme_id': this.search_form.programme_id,
                            'class_type': this.search_form.class_type
                        }
                    })
                    .then((response) => {
                        this.class_levels = response.data
                        this.disable_input.class_levels = false
                    })
                }
            },
            deep: true
        },
    },
    methods: {
        submit() {
            this.$inertia.post(route('classes.store'), this.form, { preserveState: true})
        },
        findStudents(query){
            debounce(val => '400ms')(10)
            if(query){
                this.searching_students = true
                axios.get(route('students.find'), {
                    params: {
                        'keyword': query
                    }
                })
                .then((res) => {
                    this.students = res.data
                    this.searching_students = false
                });
            }
        },
        findClasses(){
            if(this.form.student_id && this.search_form.centre_id && this.search_form.programme_id && this.search_form.class_level && this.search_form.class_type && this.search_form.class_method){
                this.searching_classes = true   
                this.enable_container.show_fee = false
                this.list.available_classes = []
                this.selected_class_count = 0
                axios.get(route('classes.find'), {
                    'params': {
                        'centre_id': this.search_form.centre_id,
                        'programme_id':  this.search_form.programme_id,
                        'class_method':  this.search_form.class_method,
                        'class_level':  this.search_form.class_level,
                        'class_type':  this.search_form.class_type,
                    }
                })
                .then((res) => {
                    this.list.available_classes = res.data
                    this.enable_container.available_classes = true,
                    this.searching_classes = false
                    this.form.classes = []
                    this.scrollToElement('available_classes')
                });
            }
        },
        getNormalFee(class_id, index){
            this.selected_class_count = 1
            this.getFee(class_id, index)
            this.form.classes.push(class_id)
        },
        getPlusFee(event, class_id, index){
            if(event.target.checked){
                this.selected_class_count += 1
                this.getFee(class_id, index, true)
                this.form.classes.splice(index, 0, class_id)
            }
            else{
                this.selected_class_count -= 1
                this.getFee(class_id, index, true)
                this.form.classes.splice(index, 1)
            }
        },
        getFee(class_id, index, byClassCount = false){
            axios.get(route('programmes.get_fee'), {
                    'params': {
                        'class_id' : !byClassCount ? class_id : '',
                        'class_type' : this.search_form.class_type,
                        'class_count':this.selected_class_count
                    }
                })
                .then((res) => {
                    this.form.fee = []
                    this.form.fee = res.data
                    if(res.data.id){
                        this.enable_container.show_fee = true
                        this.scrollToElement('class_fee')
                    }
                    else{
                        this.enable_container.show_fee = false
                    }
                });
        },
        clearStudents(){
            this.students = []
        },
        scrollToElement(element) {
            const el = this.$refs[element];
            if (el) {
                el.scrollIntoView({behavior: 'smooth'});
            }
        },
        addStudent(){
            this.$inertia.post(route('students.store'), this.form)
        }
    }
}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>