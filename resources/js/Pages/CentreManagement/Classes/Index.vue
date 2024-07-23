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
                <div class="relative w-full">
                    <Multiselect 
                        @select="search"
                        @deselect="search"
                        v-model="params.day"
                        valueProp="id"
                        :appendNewOption="false"
                        :searchable="true"
                        :options="$page.props.days_of_the_week"
                        :clearOnSelect="true"
                        :canClear="false"
                        :canDeselect="true"
                        trackBy="name"
                        label="name"
                        :closeOnDeselect="true"
                        placeholder="Days of the week"
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
                <div class="w-full self-center">
                    <BreezeButton buttonType="gray" class="py-2 px-3" :url="route('classes')">Clear Search</BreezeButton>
                </div>
            </div>
            <div class="overflow-x-auto">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-300">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/14">#</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/14">Programme</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Level</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Day</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Time</th>
                                <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Capacity</th> -->
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-if="!$page.props.classes.data.length">
                                <td class="text-center" colspan="10">
                                    <div class="p-3">
                                        No Record Found! 
                                    </div>
                                </td>
                            </tr> 
                            <tr class="hover:bg-gray-200" v-for="(classes, index) in $page.props.classes.data" :key="classes.ID">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-700">{{ ++index }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ classes.programme_name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ classes.level }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ classes.class_day }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="pl-2">{{ moment(classes.start_time, "HH:mm:ss").format('h:mm A') }} - {{ moment(classes.end_time, "HH:mm:ss").format('h:mm A') }}</span>
                                    </div>
                                </td>
                                <!-- <td class="px-6 py-4 whitespace-nowrap">
                                    <BreezeButton buttonType="blue" @click="viewStudents(classes.id)">
                                        <div class="text-sm font-medium text-white">{{ classes.capacity }}</div>
                                    </BreezeButton>
                                </td> -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ classes.type }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="classes.status == 1 ? ' bg-green-100 text-green-800' : ' bg-red-100 text-red-800'"> {{ classes.status == 1 ? 'Active' : 'Not Active' }} </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center">
                                        <div class="flex pr-1" v-if="$page.props.can.edit_classes">
                                            <BreezeButton buttonType="info" class="py-1 px-4" title="Edit Class" @click="editClass(classes.id)">Edit</BreezeButton>
                                        </div>
                                        <div class="flex" v-if="$page.props.can.delete_classes">
                                            <BreezeButton buttonType="danger" title="Delete Class" @click="deleteClass(classes.id)">Delete</BreezeButton>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <Pagination :page_data="$page.props.classes" :params="params"></Pagination>
                </div>
            </div>
            <ConfirmationModal 
                :show="isOpen" 
                @close="isOpen = false"
                confirmationAlert="danger"
                confirmationTitle="Delete Class"
                confirmationText="Are you sure want to delete this class?"
                confirmationButton="Delete"
                confirmationMethod="delete"
                :confirmationRoute="confirmationRoute"
                :confirmationData="confirmationData"
            >
            </ConfirmationModal>
            <VueFinalModal v-model="showModal">
                    <div id="default-modal" data-modal-show="true" aria-hidden="true" class="overflow-x-hidden overflow-y-auto h-modal md:h-full top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center">
                        <!-- <div class="relative w-full px-4 h-full md:h-auto"> -->
                        <div class="absolute top-1/3 px-20">
                            <!-- Modal content -->
                            <div class="bg-white rounded-lg shadow relative">
                                <!-- Modal header -->
                                <div class="flex items-start justify-between p-5 border-b rounded-t">
                                    <h3 class="text-gray-900 text-xl lg:text-2xl font-semibold">
                                        Terms of Service
                                    </h3>
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="default-modal">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-6 space-y-6">
                                    <p class="text-gray-500 text-base leading-relaxed">
                                        With less than a month to go before the European Union enacts new consumer privacy laws for its citizens, companies around the world are updating their terms of service agreements to comply.
                                    </p>
                                    <p class="text-gray-500 text-base leading-relaxed">
                                        The European Union’s General Data Protection Regulation (G.D.P.R.) goes into effect on May 25 and is meant to ensure a common set of data rights in the European Union. It requires organizations to notify users as soon as possible of high-risk data breaches that could personally affect them.
                                    </p>
                                </div>
                                <!-- Modal footer -->
                                <div class="flex space-x-2 items-center p-6 border-t border-gray-200 rounded-b">
                                    <button data-modal-toggle="default-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">I accept</button>
                                    <button data-modal-toggle="default-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Decline</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </VueFinalModal>
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
import { $vfm, VueFinalModal, ModalsContainer } from 'vue-final-modal'
import { debounce } from 'vue-debounce'

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon,
        ConfirmationModal, Head, Link, Multiselect, VueFinalModal, ModalsContainer, Pagination
    },
    props: {
        filter: Object,
    },
    // watch: {
    //     params: {
    //         handler(){
    //             if(this.params){
    //                 this.$inertia.get(this.route('classes'), this.params, { replace: true, preserveState: true});
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
                day: this.filter.day ? this.filter.day : '',
            }
        }
    },
    methods: {
        addClass(centreID){
            this.$inertia.get(this.route('classes.create'), {'centre_id': centreID});
        },
        editClass(classID){
            this.$inertia.get(this.route('classes.edit'), {'class_id': classID});
        },
        deleteClass(classID){
            this.confirmationRoute = 'classes.destroy'
            this.confirmationData = classID
            this.isOpen = true
        },
        viewStudents(classID){
            this.showModal = true
        },
        search(){
            this.$inertia.get(this.route('classes'), this.params, { replace: true, preserveState: true});
        }
    }
}
</script>
