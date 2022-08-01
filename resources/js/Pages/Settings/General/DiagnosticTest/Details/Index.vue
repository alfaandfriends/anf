

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
                        <TabPage/>
                        <div class="flex mt-4 bg-white px-1 rounded">
                            <div class="overflow-hidden w-1/2 p-4">
                                <div class="flex justify-between border-b border-dashed border-indigo-900 mt-1 items-center mb-4">
                                    <h1 class="font-semibold text-indigo-800">Questions</h1>
                                    <div class="flex justify-start">
                                        <Link :href="route('settings.diagnostic_test.details.create', {'dt_id': $page.props.diagnostic_test_id})" class="py-2 px-6 bg-blue-500 text-white  mb-2 rounded shadow">
                                            <div class="flex">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="pl-2">Add</span> 
                                            </div>
                                        </Link>
                                    </div>
                                </div>
                                <draggable class="w-full" v-model="dtList" v-if="dtList.length > 0" @change="updateSorting">
                                    <div class="mb-1" v-for="(element, index) in dtList" :key="index">
                                        <div class="flex">
                                            <div class="cursor-pointer w-full flex justify-between list-group-item bg-indigo-200 py-2 px-5 text-left" :class="showdtDetails ? 'rounded-tl' : 'rounded-l'" @click="dtEdit(element.id, element.dt_id)">
                                                {{ (index+1) + '. ' + element.name }}
                                            </div>
                                            <div class="cursor-pointer p-2 bg-red-500 hover:bg-red-700" :class="showdtDetails ? 'rounded-tr' : 'rounded-r'" @click="dtDelete(element.id)">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </draggable>
                                <div v-else class="flex text-center p-6 border-2 rounded text-red-500 border-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="pl-2">No record found for diagnostic test.</span>
                                </div>
                            </div>
                            <div class="overflow-hidden w-1/2 p-4">
                                <div class="flex justify-between border-b border-dashed border-indigo-900 mt-1 items-center mb-4">
                                    <h1 class="font-semibold text-indigo-800 font-bold">Conditions</h1>
                                    <div class="flex justify-start">
                                        <Link :href="route('settings.diagnostic_test.conditions.create', {'dt_id': $page.props.diagnostic_test_id})" class="py-2 px-6 bg-blue-500 text-white  mb-2 rounded shadow">
                                            <div class="flex">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="pl-2">Add</span> 
                                            </div>
                                        </Link>
                                    </div>
                                </div>
                                <div class="space-y-6 pb-6">
                                    <template v-if="$page.props.diagnostic_test_conditions.length > 0">
                                        <div class="flex items-center" v-for="(condition, index) in $page.props.diagnostic_test_conditions" :key="condition.id">
                                            <span>{{ index + 1 }}. </span>
                                            <div class="flex flex-row justify-between pl-3">
                                                <div class="flex flex-col">
                                                    <span class="underline font-bold">Final score lower than {{ condition.score_capped }}</span>
                                                    <span class="text-sm italic text-blue-900">{{ condition.message }}</span>
                                                </div>
                                                <div class="flex flex-col space-y-1 mx-2">
                                                    <div class="rounded bg-yellow-500 hover:bg-yellow-700 p-1 text-white cursor-pointer">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </div>
                                                    <div class="rounded bg-red-500 hover:bg-red-700 p-1 text-white cursor-pointer" @click="conditionDelete(condition.id)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="flex text-center p-6 border-2 rounded text-red-500 border-red-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="pl-2">No condition found for diagnostic test.</span>
                                        </div>
                                    </template>
                                </div>
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
    </BreezeAuthenticatedLayout>
</template>

<script>
import { defineComponent } from 'vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
import { TrashIcon } from '@heroicons/vue/solid'
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import { VueDraggableNext } from 'vue-draggable-next'
import TabPage from '@/Pages/Settings/General/Tab.vue'

export default defineComponent({
    components: {
        Head, Link, TabGroup, TabList, Tab, TabPanels, TabPanel, ConfirmationModal, TrashIcon, draggable: VueDraggableNext, 
    },
    props: {
        diagnostic_test_id: String
    },
    updated(){
        this.dtList = this.$page.props.diagnostic_test_list  ? this.$page.props.diagnostic_test_list  : [];
    },
    mounted(){
        this.dtList = this.$page.props.diagnostic_test_list  ? this.$page.props.diagnostic_test_list  : [];
    },
    data() {
        return {
            enabled: true,
            isOpen: false,
            showdtDetails: false,
            dragging: true,
            confirmationTitle: '',
            confirmationText: '',
            confirmationAlert: '',
            confirmationButton: '',
            confirmationMethod: '',
            confirmationData: '',
            confirmationRoute: '',
            dragging: true,
            dtList: this.$page.props.diagnostic_test_list  ? this.$page.props.diagnostic_test_list  : [],
            form: {
                label: '',
                image_location: '',
                redirect_yes: '',
                redirect_no: '',
                order: ''
            }
        };
    },
    methods: {
        dtEdit(test_id, dt_id){
            this.$inertia.get(route('settings.diagnostic_test.details.edit'), {'test_id': test_id, 'dt_id': dt_id}, {preserveScroll: true})
        },
        dtDelete(test_id){
            this.confirmationTitle="Delete Diagnostic Test Item"
            this.confirmationText="Are you sure want to delete this item?"
            this.confirmationButton="Delete"
            this.confirmationMethod="delete"
            this.confirmationRoute = 'settings.diagnostic_test.details.destroy'
            this.confirmationData = test_id
            this.isOpen = true
        },
        updateSorting(){
            this.$inertia.post(route('settings.diagnostic_test.details.sort'), {'sorted_list': this.dtList}, {preserveScroll: true})
        },
        conditionDelete(condition_id){
            this.confirmationTitle="Delete Diagnostic Test Condition"
            this.confirmationText="Are you sure want to delete this condition?"
            this.confirmationButton="Delete"
            this.confirmationMethod="delete"
            this.confirmationRoute = 'settings.diagnostic_test.conditions.destroy'
            this.confirmationData = condition_id
            this.isOpen = true
        }
    }
})
</script>
                                