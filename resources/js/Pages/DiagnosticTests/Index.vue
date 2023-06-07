<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Diagnostic Test" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-middle inline-block min-w-full">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg px-1">
                            <div class="flex py-2 justify-end">
                                <BreezeButton :route="route('dt.settings.create')" class="py-3 px-4">New Diagnostic Test</BreezeButton>
                            </div>
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
                            <Pagination :page_data="diagnostic_test_list"></Pagination>
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
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { TrashIcon } from '@heroicons/vue/solid'
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import Pagination from '@/Components/Pagination.vue'

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
        };
    },
    props: {
        diagnostic_test_list: Object,
    },
    methods: {
        handleClick(event){
            console.log(event)
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
    }

}
</script>
                                