<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Classes" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="flex justify-end mb-3" v-if="$page.props.can.create_classes">
                <BreezeButton @click="addClass(params.centre_id)">New Class</BreezeButton>
            </div>
            <hr class="my-3 border border-dashed border-gray-400">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-2 mb-3">
                <div class="relative w-full">
                    <svg class="absolute top-2.5 left-3 h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                        <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <input type="text" class="h-10 border-2 border-gray-300 w-full appearance-none focus:ring-0 focus:border-gray-300 py-1 pl-10 pr-4 text-gray-700 bg-white rounded-md" v-debounce:800ms="search" v-model="params.search">
                </div>
                <div class="relative w-full">
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
                        :options="$page.props.options.programmes"
                        :clearOnSelect="true"
                        :closeOnDeselect="true"
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
                        :options="$page.props.options.levels"
                        :clearOnSelect="false"
                        :closeOnDeselect="true"
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
                <div class="w-full self-center">
                    <BreezeButton buttonType="gray" class="py-2 px-3" :route="route('assessments')">Clear Search</BreezeButton>
                </div>
            </div>
            <div class="overflow-x-auto">
                <div class="shadow overflow-x-auto border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-300">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/14">#</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/14">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Centre</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-if="!$page.props.assessments.data.length">
                                <td class="text-center" colspan="10">
                                    <div class="p-3">
                                        No Record Found! 
                                    </div>
                                </td>
                            </tr> 
                            <tr class="hover:bg-gray-200" v-for="(assessment, index) in $page.props.assessments.data" :key="assessment.ID">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-700">{{ ++index }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ assessment.student_name }}</div>
                                    <div class="flex items-center text-sm space-x-2">
                                        <div class="text-xs px-2 py-1 border text-indigo-700 font-semibold border-indigo-500 rounded bg-indigo-200">
                                            {{ assessment.programme_name }}
                                        </div>
                                        <div class="text-xs px-2 py-1 border text-blue-700 font-semibold border-blue-500 rounded bg-blue-200">
                                            Level {{ assessment.programme_level }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ assessment.centre_name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center">
                                        <div class="flex pr-1" v-if="$page.props.can.create_assessments">
                                            <BreezeButton buttonType="info" class="py-1 px-4" @click="editAssessment(assessment.programme_level, index)">View / Update</BreezeButton>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <Pagination :page_data="$page.props.assessments" :params="params"></Pagination>
                </div>
            </div>
        </div>
        <Modal :showModal="showModal" modalType="sm" @hideModal="showModal = false">
            <template v-slot:header>
                <div class="flex items-center justify-between py-3 px-4 border-b rounded-t font-semibold">
                    <h3 class="text-gray-900 text font-semibold">                
                        Assessments
                    </h3>       
                    <button type="button" @click="showModal = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="default-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>                 
            </template>
            <template v-slot:content>
                <div class="w-full p-3 text-xs md:text-sm">
                    <div class="flex flex-col md:items-center">
                        <div class="flex-1 overflow-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-indigo-100">
                                        <th class="px-3 py-1 border w-6/12 text-left">Units</th>
                                        <th class="px-3 py-1 border w-3/12 text-center">Pre</th>
                                        <th class="px-3 py-1 border w-3/12 text-center">Post</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="unit, index in units" :key="unit.id">
                                        <td class="px-3 py-0.5 whitespace-nowrap">{{ unit.name }}</td>
                                        <td class="px-3 py-0.5 text-center">
                                            <input class="px-4 h-7 w-full text-center text-xs rounded" type="text" placeholder="score" v-model.lazy="form.assessments[index].pre">
                                        </td>
                                        <td class="px-3 py-0.5 text-center">
                                            <input class="px-4 h-7 w-full text-center text-xs rounded" type="text" placeholder="score" v-model.lazy="form.assessments[index].post">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr class="mt-3 mb-1">
                    <div class="flex justify-end mt-3 space-x-2">
                        <BreezeButton buttonType="gray" class="px-3 py-1.5" @click="showModal = false">Cancel</BreezeButton>
                        <BreezeButton buttonType="info" class="px-3 py-1.5" @click="submit">Save</BreezeButton>
                    </div>
                </div>
                
            </template>
        </Modal >
    </BreezeAuthenticatedLayout>
</template>



<script>
import { SearchIcon, TrashIcon, PencilIcon } from '@heroicons/vue/solid'
import { Head, Link } from '@inertiajs/inertia-vue3';
import Pagination from '@/Components/Pagination.vue'
import moment from 'moment';
import Multiselect from '@vueform/multiselect'
import { $vfm, VueFinalModal, ModalsContainer } from 'vue-final-modal'
import { debounce } from 'vue-debounce'
import axios from 'axios';
import Modal from '@/Components/Modal.vue'

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon,
        Head, Link, Multiselect, VueFinalModal, ModalsContainer, Pagination
    },
    props: {
        filter: Object,
    },
    // watch: {
    //     params: {
    //         handler(){
    //             if(this.params){
    //                 this.$inertia.get(this.route('assessments'), this.params, { replace: true, preserveState: true});
    //             }
    //         },
    //         deep: true
    //     }
    // },
    data(){
        return{
            showModal: false,
            isOpen: false,
            userID: '',
            confirmationTitle: '',
            confirmationText: '',
            confirmationAlert: '',
            confirmationButton: '',
            confirmationMethod: '',
            confirmationData: '',
            confirmationRoute: '',
            params: {
                search: this.filter.search ? this.filter.search : '',
                centre_id: this.filter.centre_id ? this.filter.centre_id : '',
                programme_id: this.filter.programme_id ? this.filter.programme_id : '',
                level: this.filter.level ? this.filter.level : '',
            },
            units: [],
            form: {
                student_id: '',
                programme_level_id: '',
                assessments: []
            }
        }
    },
    computed: {
        getPreValue(){
            this.units.map(unit=>{
                return this.form.assessments.find(item=>item.id == unit.id)?.post || ''
            })
        },
        getPostValue(){
            this.units.map(unit=>{
                return this.form.assessments.find(item=>item.id == unit.id)?.post || ''
            })
        }
    },
    methods: {
        addClass(centreID){
            this.$inertia.get(this.route('assessments.create'), {'centre_id': centreID});
        },
        editAssessment(level, index){
            this.form.assessments = []
            axios.get(route('assessments.create', level))
            .then((response)=>{
                this.units = response.data
                this.form.student_id = this.$page.props.assessments.data[index].student_id
                this.form.programme_level_id = this.$page.props.assessments.data[index].programme_level_id
                this.units.map(item=>{
                    this.form.assessments.push({    
                        'unit_id': item.id,
                        'unit_name': item.name,
                        'pre' : '',
                        'post': '',
                    })
                })
                this.showModal = true
            })
        },
        submit(){
            this.$inertia.post(this.route('assessments.store'), this.form, { preserveState: false});
        },
        search(){
            this.$inertia.get(this.route('assessments'), this.params, { replace: true, preserveState: true});
        },
    }
}
</script>
