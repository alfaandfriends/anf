<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Students" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4 space-y-2">
            <Tabs></Tabs>
            <div class="bg-white rounded p-4 border border-gray-400">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-2 mb-3">
                    <div class="relative w-full">
                        <svg class="absolute top-2.5 left-3 h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                            <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <input type="text" class="h-10 border-2 border-gray-300 w-full appearance-none focus:ring-0 focus:border-gray-300 py-1 pl-10 pr-4 text-gray-700 bg-white rounded-md" v-debounce:800ms="search" v-model="params.search">
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-300">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/14">#</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/14">Name</th>
                                    <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Programme</th> -->
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Parent</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Status</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-if="!$page.props.students.data.length">
                                    <td class="text-center" colspan="10">
                                        <div class="p-3">
                                            No Record Found! 
                                        </div>
                                    </td>
                                </tr> 
                                <tr class="hover:bg-gray-200" v-for="(students, index) in $page.props.students.data">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-700">{{ ++index }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ students.name }}</div>
                                    </td>
                                    <!-- <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ students.programme_name }}</div>
                                    </td> -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ students.parent_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="students.status == true ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"> {{ students.status == true ? 'Active' : 'Inactive' }} </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <BreezeButton buttonType="warning" title="Edit Class" @click="editStudent(students.id)" v-if="$page.props.can.edit_students">
                                            Edit Student
                                        </BreezeButton>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <Pagination :page_data="$page.props.students" :params="params"></Pagination>
                    </div>
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
                    <div id="default-modal" data-modal-show="true" aria-hidden="true" class="overflow-x-hidden overflow-y-auto h-modal md:h-full md:inset-0 z-50 justify-center items-center">
                        <!-- <div class="relative w-full px-4 h-full md:h-auto"> -->
                        <div class="absolute top-1/4 left-1/4 w-2/3">
                            <!-- Modal content -->
                            <div class="bg-white rounded-lg shadow relative">
                                <!-- Modal header -->
                                <div class="flex items-start justify-between p-5 border-b rounded-t">
                                    <h3 class="text-gray-900 text-xl lg:text-2xl font-semibold">
                                        Student List
                                    </h3>
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="default-modal">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-6 space-y-6">
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-300">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">1</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">Muhammad Charlie</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="flex space-x-2 items-center p-6 border-t border-gray-200 rounded-b">
                                    <BreezeButton buttonType="gray" @click="showModal = false">Close</BreezeButton>
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
import Tabs from './Tabs.vue'

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon,
        ConfirmationModal, Head, Link, Multiselect, VueFinalModal, ModalsContainer, Pagination, Tabs
    },
    props: {
        filter: Object,
    },
    // mounted(){
    //     this.params.centre_id = this.$page.props.allowed_centres[0] ? this.$page.props.allowed_centres[0].ID : ''
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
            }
        }
    },
    methods: {
        newAdmission(centreID){
            this.$inertia.get(this.route('students.create'), {'centre_id': centreID});
        },
        editStudent(studentID){
            this.$inertia.get(this.route('students.edit'), {'student_id': studentID});
        },
        deleteStudent(studentID){
            this.confirmationRoute = 'students.destroy'
            this.confirmationData = studentID
            this.isOpen = true
        },
        viewStudents(classID){
            this.showModal = true
        },
        search(){
            this.$inertia.get(this.route('students.unassigned'), this.params, { replace: true, preserveState: true});
        }
    }
}
</script>
