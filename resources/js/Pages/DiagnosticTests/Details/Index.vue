<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Diagnostic Test" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form>
                    <div class="px-4 py-5 bg-indigo-100 space-y-6 sm:p-6 h-full">
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3 space-y-2">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="overflow-hidden">
                                        <div class="flex justify-between border-b border-dashed border-indigo-900 mt-1 items-center mb-4">
                                            <div class="flex items-center space-x-2">
                                                <h1 class="text-indigo-800 font-bold">Categories</h1>
                                                <Tooltip :raw_HTML="categories_tooltip"></Tooltip>
                                            </div>
                                            <div class="flex justify-start mb-2">
                                                <BreezeButton :route="route('dt.settings.categories.create', {'dt_id': $page.props.diagnostic_test_id})">
                                                    New Category
                                                </BreezeButton>
                                            </div>
                                        </div>
                                        <template v-if="$page.props.diagnostic_test_categories.length > 0">
                                            <div class="flex flex-col">
                                                <ul class="bg-white rounded-lg text-gray-900 w-full">
                                                    <li class="hover:bg-gray-100 flex justify-between py-2 border-b border-gray-200 w-full rounded-t-lg items-center" v-for="(category, index) in $page.props.diagnostic_test_categories" :key="category.id">
                                                        <span>{{ index + 1 }}. {{ category.name }}</span>
                                                        <div class="flex space-x-1">
                                                            <div class="rounded bg-yellow-500 hover:bg-yellow-700 p-1 text-white cursor-pointer shadow-md">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" @click="categoriesEdit(category.id)">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                                </svg>
                                                            </div>
                                                            <div class="rounded bg-red-500 hover:bg-red-700 p-1 text-white cursor-pointer shadow-md" @click="categoriesDelete(category.id)">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <div class="flex text-center text-gray-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="pl-2">No category found.</span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                <!-- <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="flex justify-between border-b border-dashed border-indigo-900 mt-1 items-center mb-4">
                                        <div class="flex items-center space-x-2">
                                            <h1 class="text-indigo-800 font-bold">Conditions</h1>
                                            <Tooltip :raw_HTML="conditions_tooltip"></Tooltip>
                                        </div>
                                        <div class="flex justify-start mb-2">
                                            <BreezeButton :route="route('dt.settings.conditions.create', {'dt_id': $page.props.diagnostic_test_id})">
                                                New Condition
                                            </BreezeButton>
                                        </div>
                                    </div>
                                    <template v-if="$page.props.diagnostic_test_conditions.length > 0">
                                        <div class="flex items-center" v-for="(condition, index) in $page.props.diagnostic_test_conditions" :key="condition.id">
                                            <span>{{ index + 1 }}. </span>
                                            <div class="flex flex-row justify-between pl-3">
                                                <div class="flex flex-col">
                                                    <span class="underline font-bold">Final score lower than {{ condition.score_capped }}</span>
                                                    <span class="text-sm italic text-blue-900">{{ condition.message }}</span>
                                                </div>
                                                <div class="flex flex-col space-y-1 mx-2">
                                                    <div class="rounded bg-yellow-500 hover:bg-yellow-700 p-1 text-white cursor-pointer shadow-md">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" @click="conditionsEdit(condition.id)">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </div>
                                                    <div class="rounded bg-red-500 hover:bg-red-700 p-1 text-white cursor-pointer shadow-md" @click="conditionsDelete(condition.id)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="flex text-center text-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="pl-2">No condition found.</span>
                                        </div>
                                    </template>
                                </div> -->
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="overflow-hidden">
                                        <div class="flex justify-between border-b border-dashed border-indigo-900 mt-1 items-center mb-4">
                                            <h1 class="text-indigo-800 font-bold">Questions</h1>
                                            <div class="flex justify-start mb-2">
                                                <BreezeButton :route="route('dt.settings.details.create', {'dt_id': $page.props.diagnostic_test_id})">
                                                    New Question
                                                </BreezeButton>
                                            </div>
                                        </div>
                                        <draggable class="w-full" v-model="dtList" v-if="dtList.length > 0" @change="updateSorting">
                                            <div class="mb-1" v-for="(element, index) in dtList" :key="index">
                                                <div class="flex">
                                                    <div class="cursor-pointer w-full flex justify-between list-group-item bg-indigo-200 py-1 px-5 text-left" :class="showdtDetails ? 'rounded-tl' : 'rounded-l'" @click="dtEdit(element.id, element.dt_id)">
                                                        {{ (index+1) + '. ' + element.question }}
                                                    </div>
                                                    <div class="cursor-pointer p-1 bg-red-500 hover:bg-red-700" :class="showdtDetails ? 'rounded-tr' : 'rounded-r'" @click="dtDelete(element.id)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </draggable>
                                        <div v-else class="flex text-center text-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="pl-2">No record found.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
import Tooltip from '@/Components/Tooltip.vue'

export default defineComponent({
    components: {
        Head, Link, TabGroup, TabList, Tab, TabPanels, TabPanel, ConfirmationModal, TrashIcon, draggable: VueDraggableNext, Tooltip
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
            categories_tooltip: '<span class="text-white">This is conditions tooltip, please set the text in html file to indicate the description of the tooltip actually elaborate</span>',
            conditions_tooltip: '<span class="text-white">This is conditions tooltip, please set the text in html file to indicate the description of the tooltip actually elaborate</span>',
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
            this.$inertia.get(route('dt.settings.details.edit'), {'test_id': test_id, 'dt_id': dt_id}, {preserveScroll: true})
        },
        dtDelete(test_id){
            this.confirmationTitle="Delete Diagnostic Test Item"
            this.confirmationText="Are you sure want to delete this item?"
            this.confirmationButton="Delete"
            this.confirmationMethod="delete"
            this.confirmationRoute = 'dt.settings.details.destroy'
            this.confirmationData = test_id
            this.isOpen = true
        },
        updateSorting(){
            this.$inertia.post(route('dt.settings.details.sort'), {'sorted_list': this.dtList}, {preserveScroll: true})
        },
        conditionsEdit(condition_id){
            this.$inertia.get(route('dt.settings.conditions.edit'), {'condition_id': condition_id}, {preserveScroll: true})
        },
        conditionsDelete(condition_id){
            this.confirmationTitle="Delete Diagnostic Test Condition"
            this.confirmationText="Are you sure want to delete this condition?"
            this.confirmationButton="Delete"
            this.confirmationMethod="delete"
            this.confirmationRoute = 'dt.settings.conditions.destroy'
            this.confirmationData = condition_id
            this.isOpen = true
        },
        categoriesEdit(category_id){
            this.$inertia.get(route('dt.settings.categories.edit'), {'category_id': category_id}, {preserveScroll: true})
        },
        categoriesDelete(category_id){
            this.confirmationTitle="Delete Diagnostic Test Category"
            this.confirmationText="Are you sure want to delete this category?"
            this.confirmationButton="Delete"
            this.confirmationMethod="delete"
            this.confirmationRoute = 'dt.settings.categories.destroy'
            this.confirmationData = category_id
            this.isOpen = true
        }
    }
})
</script>
                                