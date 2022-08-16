<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
</script>

<template>
    <Head title="General Setting" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                General Setting
            </h2>
        </template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-middle inline-block min-w-full">
                        <ul class="flex justify-start space-x-1 text-white">
                            <li>
                                <button @click="currentTab('settings.fee_type_list')" class="inline-block px-4 py-2"
                                        :class="route().current('settings.fee_type_list') ? 'bg-white text-indigo-800 border-indigo-500 border-t-2' :
                                                           'bg-indigo-500 text-white border-indigo-500 border-t-2 hover:bg-indigo-700 hover:border-indigo-700'">Fee Type List</button>
                            </li>
                            <li>
                                <button @click="currentTab('settings.fee_period_list')" class="inline-block px-4 py-2"
                                        :class="route().current('settings.fee_period_list') ? 'bg-white text-indigo-800 border-indigo-500 border-t-2' : 
                                                           'bg-indigo-500 text-white border-indigo-500 border-t-2 hover:bg-indigo-700 hover:border-indigo-700'">Fee Period List</button>
                            </li>
                        </ul>
                        <div class="mt-4 bg-white">
                            <div v-if="route().current('settings.fee_type_list')">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <div class="flex py-2 justify-end">
                                        <Link :href="route('settings.fee_type_list.create')" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">New Fee Type</Link>
                                    </div>
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-200">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" width="3">#</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fee Type</th>
                                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr v-if="!$page.props.fee_type_list.data.length">
                                                <td class="text-center" colspan="10">
                                                    <div class="p-3">
                                                        No Record Found! 
                                                    </div>
                                                </td>
                                            </tr> 
                                            <tr class="hover:bg-gray-200" v-for="(fee_type_list, index) in $page.props.fee_type_list.data" :key="fee_type_list.ID">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-700">{{ ++index }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900 font-bold">{{ fee_type_list.label }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                    <div class="flex justify-center">
                                                        <div class="flex pr-1">
                                                            <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-1 border border-yellow-700 rounded" title="Edit Fee Type" @click="editFeeType(fee_type_list.id)">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="text-white-600 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="flex">
                                                            <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-1 border border-red-700 rounded" title="Delete Fee Type" @click="deleteFeeType(fee_type_list.id)">
                                                                <TrashIcon class="text-white-600 h-4 w-4 fill-current"></TrashIcon>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <template v-if="$page.props.fee_type_list.data.length">
                                        <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 bg-gray-200">
                                            <div class="flex-1 flex justify-between sm:hidden">
                                                <a :href="$page.props.fee_type_list.prev_page_url" v-if="$page.props.fee_type_list.prev_page_url" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Previous </a>
                                                <a :href="$page.props.fee_type_list.next_page_url"  v-if="$page.props.fee_type_list.next_page_url" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Next </a>
                                            </div>
                                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                                <div>
                                                    <p class="text-sm text-gray-700">
                                                        Showing
                                                        <span class="font-medium">{{ $page.props.fee_type_list.from }}</span>
                                                        to
                                                        <span class="font-medium">{{ $page.props.fee_type_list.to }}</span>
                                                        of
                                                        <span class="font-medium">{{ $page.props.fee_type_list.total }}</span>
                                                        results
                                                    </p>
                                                </div>
                                                <div>
                                                    <nav id="pagination" class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                                                        <Link v-for="(link, key) in $page.props.fee_type_list.links"
                                                            :key="key"
                                                            :href="link.url ? link.url : '#'"
                                                            :class="(link.active == false && link.url == null ? 'select-none bg-white border-gray-200 text-gray-300 relative inline-flex items-center px-4 py-2 border text-sm font-medium cursor-not-allowed'
                                                                                : (link.active ? 'select-none z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium' 
                                                                                                                        : ('select-none bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium')))"  
                                                            v-html="link.label"
                                                        >
                                                        </Link>
                                                    </nav>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            <div v-if="route().current('settings.fee_period_list')">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <div class="flex py-2 justify-end">
                                        <Link :href="route('settings.fee_period_list.create')" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">New Fee Period</Link>
                                    </div>
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-200">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" width="3">#</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fee Period</th>
                                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr v-if="!$page.props.fee_period_list.data.length">
                                                <td class="text-center" colspan="10">
                                                    <div class="p-3">
                                                        No Record Found! 
                                                    </div>
                                                </td>
                                            </tr> 
                                            <tr class="hover:bg-gray-200" v-for="(fee_period_list, index) in $page.props.fee_period_list.data" :key="fee_period_list.ID">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-700">{{ ++index }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900 font-bold">{{ fee_period_list.label }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                    <div class="flex justify-center">
                                                        <div class="flex pr-1">
                                                            <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-1 border border-yellow-700 rounded" title="Edit Class" @click="editFeePeriod(fee_period_list.id)">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="text-white-600 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="flex">
                                                            <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-1 border border-red-700 rounded" title="Delete Class" @click="deleteFeePeriod(fee_period_list.id)">
                                                                <TrashIcon class="text-white-600 h-4 w-4 fill-current"></TrashIcon>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <template v-if="$page.props.fee_period_list.data.length">
                                        <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 bg-gray-200">
                                            <div class="flex-1 flex justify-between sm:hidden">
                                                <a :href="$page.props.fee_period_list.prev_page_url" v-if="$page.props.fee_period_list.prev_page_url" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Previous </a>
                                                <a :href="$page.props.fee_period_list.next_page_url"  v-if="$page.props.fee_period_list.next_page_url" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Next </a>
                                            </div>
                                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                                <div>
                                                    <p class="text-sm text-gray-700">
                                                        Showing
                                                        <span class="font-medium">{{ $page.props.fee_period_list.from }}</span>
                                                        to
                                                        <span class="font-medium">{{ $page.props.fee_period_list.to }}</span>
                                                        of
                                                        <span class="font-medium">{{ $page.props.fee_period_list.total }}</span>
                                                        results
                                                    </p>
                                                </div>
                                                <div>
                                                    <nav id="pagination" class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                                                        <Link v-for="(link, key) in $page.props.fee_period_list.links"
                                                            :key="key"
                                                            :href="link.url ? link.url : '#'"
                                                            :class="(link.active == false && link.url == null ? 'select-none bg-white border-gray-200 text-gray-300 relative inline-flex items-center px-4 py-2 border text-sm font-medium cursor-not-allowed'
                                                                                : (link.active ? 'select-none z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium' 
                                                                                                                        : ('select-none bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium')))"  
                                                            v-html="link.label"
                                                        >
                                                        </Link>
                                                    </nav>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { TrashIcon } from '@heroicons/vue/solid'
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
import axios from 'axios';

export default {
    components: {
        Head, Link, TabGroup, TabList, Tab, TabPanels, TabPanel, ConfirmationModal, TrashIcon,
    },
    data() {
        return {
            isOpen: false,
            current_tab: 1,
            confirmationTitle: '',
            confirmationText: '',
            confirmationAlert: '',
            confirmationButton: '',
            confirmationMethod: '',
            confirmationData: '',
            confirmationRoute: '',
        };
    },
    created(){
        if(route().current('settings')){
            this.$inertia.get(route('settings.fee_type_list'))
        }
    },
    props: {
        fee_type_list: Object,
        fee_period_list: Object,
    },
    methods: {
        currentTab(routeName){
            this.$inertia.get(route(routeName))
        },
        editFeeType(fee_type_id){
            this.$inertia.get(route('settings.fee_type_list.edit'), {'fee_type_id': fee_type_id})
        },
        deleteFeeType(fee_type_id){
            this.confirmationTitle="Delete Fee Type"
            this.confirmationText="Are you sure want to delete this fee type?"
            this.confirmationButton="Delete"
            this.confirmationMethod="delete"
            this.confirmationRoute = 'settings.fee_type_list.destroy'
            this.confirmationData = fee_type_id
            this.isOpen = true
        },
        editFeePeriod(fee_period_id){
            this.$inertia.get(route('settings.fee_period_list.edit'), {'fee_period_id': fee_period_id})
        },
        deleteFeePeriod(fee_period_id){
            this.confirmationTitle="Delete Fee Period"
            this.confirmationText="Are you sure want to delete this fee period?"
            this.confirmationButton="Delete"
            this.confirmationMethod="delete"
            this.confirmationRoute = 'settings.fee_period_list.destroy'
            this.confirmationData = fee_period_id
            this.isOpen = true
        }
    }

}
</script>
