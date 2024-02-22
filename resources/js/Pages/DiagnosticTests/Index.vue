<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Diagnostic Test" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="flex space-x-1 justify-end">
                <BreezeButton :route="route('dt.settings.create')">New Diagnostic Test</BreezeButton>
                <!-- <div class="relative inline-block text-left group"> -->
                    <BreezeButton buttonType="info" :route="route('dt.settings.languages')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 512 512">
                            <path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/>
                        </svg>
                    </BreezeButton>
                <!-- </div> -->
            </div>
            <hr class="my-3 border border-dashed border-gray-400">
            <div class="flex flex-wrap gap-4 mb-3">
                <div class="relative w-full lg:w-1/3 xl:w-1/4">
                    <svg class="absolute top-2.5 left-3 h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                        <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <input type="text" class="h-10 border-2 border-gray-300 w-full appearance-none focus:ring-0 focus:border-gray-300 py-1 pl-10 pr-4 text-gray-700 bg-white rounded-md" v-debounce:800ms="search" v-model="params.search">
                </div>
                <div class="relative w-full lg:w-1/3 xl:w-1/4">
                    <Multiselect 
                        @select="search"
                        @deselect="search"
                        v-model="params.language_id"
                        valueProp="id"
                        :appendNewOption="false"
                        :searchable="true"
                        :options="$page.props.languages"
                        :clearOnSelect="true"
                        :canClear="false"
                        :canDeselect="true"
                        trackBy="name"
                        label="name"
                        placeholder="All Languages"
                        :classes="{
                            container: 'relative w-full flex items-center justify-end box-border cursor-pointer border-2 border-gray-300 rounded-md bg-white text-base leading-snug outline-none h-10',
                            containerDisabled: 'cursor-default bg-gray-100',
                            containerOpen: 'rounded-b-none',
                            containerActive: 'border-2 border-gray-300',
                            singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                            singleLabelText: 'overflow-ellipsis block whitespace-nowrap max-w-full',
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
                <div class="relative w-full lg:w-1/3 xl:w-1/4">
                    <Multiselect
                        @clear="search"
                        @select="search"
                        @deselect="search"
                        v-model="params.age_id"
                        valueProp="id"
                        :appendNewOption="false"
                        :searchable="true"
                        :options="$page.props.ages"
                        :clearOnSelect="true"
                        :canClear="false"
                        :canDeselect="true"
                        trackBy="name"
                        label="name"
                        placeholder="All Ages"
                        :classes="{
                            container: 'relative w-full flex items-center justify-end box-border cursor-pointer border-2 border-gray-300 rounded-md bg-white text-base leading-snug outline-none h-10',
                            containerDisabled: 'cursor-default bg-gray-100',
                            containerOpen: 'rounded-b-none',
                            containerActive: 'border-2 border-gray-300',
                            singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                            singleLabelText: 'overflow-ellipsis block whitespace-nowrap max-w-full',
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
            </div>
            <div class="overflow-x-auto">
                <div class="mx-auto overflow-x-auto sm:overflow-visible">
                    <div class="align-middle inline-block min-w-full">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-300">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" width="3">#</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Age</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Language</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" width="5">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-if="!$page.props.diagnostic_test_list.data.length">
                                        <td class="text-center" colspan="10">
                                            <div class="p-3">
                                                No Record Found! 
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr class="hover:bg-gray-200" v-for="(diagnostic_test_list, index) in $page.props.diagnostic_test_list.data" :key="diagnostic_test_list.ID">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-700">{{ ++index }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ diagnostic_test_list.name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ diagnostic_test_list.age }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ diagnostic_test_list.language }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center">
                                                <div class="flex pr-1">
                                                    <BreezeButton buttonType="blue" @click="viewDiagnosticTest(diagnostic_test_list.id)">
                                                        <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-stars" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5z"/>
                                                            <path d="M2.242 2.194a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.277.277 0 0 0-.094.3l.173.569c.078.256-.213.462-.423.3l-.417-.324a.267.267 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.277.277 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.271.271 0 0 0 .259-.194l.162-.53zm0 4a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.277.277 0 0 0-.094.3l.173.569c.078.255-.213.462-.423.3l-.417-.324a.267.267 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.277.277 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.271.271 0 0 0 .259-.194l.162-.53zm0 4a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.277.277 0 0 0-.094.3l.173.569c.078.255-.213.462-.423.3l-.417-.324a.267.267 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.277.277 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.271.271 0 0 0 .259-.194l.162-.53z"/>
                                                        </svg> -->
                                                        View Details
                                                    </BreezeButton>
                                                </div>
                                                <div class="flex pr-1">
                                                    <BreezeButton buttonType="warning" @click="editDiagnosticTest(diagnostic_test_list.id)">
                                                        <!-- <svg xmlns="http://www.w3.org/2000/svg" class="text-white-600 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg> -->
                                                        Edit
                                                    </BreezeButton>
                                                </div>
                                                <div class="flex">
                                                    <BreezeButton buttonType="danger" @click="deleteDiagnosticTest(diagnostic_test_list.id)">
                                                        <!-- <TrashIcon class="text-white-600 h-4 w-4 fill-current"></TrashIcon> -->
                                                        Delete
                                                    </BreezeButton>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination :page_data="diagnostic_test_list" :params="params"></Pagination>
                        <ConfirmationModal 
                            :show="isOpen" 
                            @close="isOpen = false"
                            confirmationAlert="danger"
                            :confirmationTitle="confirmationTitle"
                            :confirmationText="confirmationText"
                            :confirmationButton="confirmationButton"
                            :confirmationMethod="confirmationMethod"
                            :confirmationRoute="confirmationRoute"
                            :confirmationData="confirmationData"
                        >
                        </ConfirmationModal>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { TrashIcon } from '@heroicons/vue/solid'
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import Pagination from '@/Components/Pagination.vue'
import Multiselect from '@vueform/multiselect'
import { faHeart } from '@fortawesome/free-solid-svg-icons'

export default {
    components: {
        Head, ConfirmationModal, TrashIcon, Link, TabGroup, TabList, Tab, TabPanels, TabPanel, Pagination
    },
    data() {
        return {
            isOpen: false,
            confirmationTitle: '',
            confirmationText: '',
            confirmationAlert: '',
            confirmationButton: '',
            confirmationMethod: '',
            confirmationData: '',
            confirmationRoute: '',
            params: {
                search: this.$page.props.filter.search ? this.$page.props.filter.search : '',
                language_id: this.$page.props.filter.language_id ? this.$page.props.filter.language_id : '',
                age_id: this.$page.props.filter.age_id ? this.$page.props.filter.age_id : '',
            }
        };
    },
    props: {
        diagnostic_test_list: Object,
    },
    methods: {
        handleClick(event){
            event.preventDefault()
        },
        viewDiagnosticTest(dt_id){
            this.$inertia.get(route('dt.settings.details'), {'dt_id': dt_id})
        },
        editDiagnosticTest(dt_id){
            this.$inertia.get(route('dt.settings.edit'), {'dt_id': dt_id})
        },
        deleteDiagnosticTest(dt_id){
            this.confirmationTitle="Are you sure want to delete this diagnostic test?"
            this.confirmationText="All data for this diagnostic test will be erased permanently."
            this.confirmationButton="Delete"
            this.confirmationMethod="delete"
            this.confirmationRoute = 'dt.settings.destroy'
            this.confirmationData = dt_id
            this.isOpen = true
        },
        search(){
            this.$inertia.get(this.route('dt.settings'), this.params, { replace: true, preserveState: true});
        }
    }

}
</script>
                                