<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<style>
.multiselect-assistive-text{
    display: none;
}
.invoices-date-picker{
    border: 2px solid #D1D5DB; /* Default border color and thickness */
    border-radius: 0.35rem;
}
:hover.invoices-date-picker  {
    border: 2px solid #D1D5DB; /* Highlighted border color and thickness */
}
:focus.invoices-date-picker  {
    border: 2px solid #D1D5DB; /* Highlighted border color and thickness */
}
</style>

<template>
    <Head title="Fee Invoices" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <!-- <div class="flex justify-end mb-3" v-if="$page.props.can.create_fee_invoices">
                <BreezeButton :route="route('fee.invoices.create', {'params': params})">New invoice</BreezeButton>
            </div>
            <hr class="my-3 border border-dashed border-gray-400"> -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-2 mb-3">
                <div class="relative w-full">
                    <svg class="absolute top-2.5 left-3 h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                        <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <input type="text" class="h-10 border-2 border-gray-300 w-full appearance-none focus:ring-0 focus:border-gray-300 py-1 pl-10 pr-4 text-gray-700 bg-white rounded-md" v-debounce:800ms="search" v-model="params.search">
                </div>
                <!-- <div class="relative w-full">
                    <div class="mt-1 mx-1 sm:mt-1 hs-dropdown [--auto-close:inside] relative sm:inline-flex z-20">
                        <button id="hs-dropdown-auto-close-inside" type="button" class="hs-dropdown-toggle py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800">
                        Clickable inside
                        <svg class="hs-dropdown-open:rotate-180 size-2.5" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        </button>
                    
                        <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden bg-white shadow-md rounded-lg p-2 mt-2 dark:bg-neutral-800 dark:border dark:border-neutral-700" aria-labelledby="hs-dropdown-auto-close-inside">
                        <div class="relative flex items-start py-2 px-3 rounded-lg hover:bg-gray-100 dark:hover:bg-neutral-700">
                            <div class="flex items-center h-5 mt-1">
                            <input id="hs-dropdown-item-checkbox-delete" name="hs-dropdown-item-checkbox-delete" type="checkbox" class="shrink-0 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" checked>
                            </div>
                            <label for="hs-dropdown-item-checkbox-delete" class="ms-3.5">
                            <span class="mt-1 block text-sm font-semibold text-gray-800 dark:text-neutral-300">Delete</span>
                            </label>
                        </div>
                        <div class="relative flex items-start py-2 px-3 rounded-lg hover:bg-gray-100 dark:hover:bg-neutral-700">
                            <div class="flex items-center h-5 mt-1">
                            <input id="hs-dropdown-item-checkbox-archive" name="hs-dropdown-item-checkbox-archive" type="checkbox" class="shrink-0 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                            </div>
                            <label for="hs-dropdown-item-checkbox-archive" class="ms-3.5">
                            <span class="mt-1 block text-sm font-semibold text-gray-800 dark:text-neutral-300">Archive</span>
                            </label>
                        </div>
                        </div>
                    </div>
                </div> -->
                <div class="relative w-full">
                    <Multiselect 
                        @select="search"
                        @deselect="search"
                        v-model="params.centre_id"
                        valueProp="ID"
                        :appendNewOption="false"
                        :searchable="true"
                        :options="$page.props.allowed_centres"
                        :clearOnSelect="false"
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
                        @clear="search"
                        v-model="params.programme_id"
                        valueProp="id"
                        :appendNewOption="false"
                        :searchable="true"
                        :options="$page.props.programmes"
                        :clearOnSelect="false"
                        :closeOnDeselect="true"
                        :canClear="true"
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
                <div class="relative w-full">
                    <Datepicker :class="'w-full rounded-lg shadow-sm'" 
                                input-class-name="invoices-date-picker focus:ring-0"
                                v-model="params.date" 
                                format="MMMM yyyy"
                                :month-picker="true" 
                                :auto-apply="true" 
                                :placeholder="'Month / Year'" 
                                :clearable="false"
                    />
                </div>
                <div class="relative w-full self-center">
                    <BreezeButton buttonType="gray" class="py-2 px-3" :route="route('fee.invoices')">Clear Search</BreezeButton>
                </div>
            </div>
            <div class="overflow-x-auto">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-300">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/14">#</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Name / invoice </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Date Issued</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Due Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Amount</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Status</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-if="!$page.props.invoices.data.length">
                                <td class="text-center" colspan="10">
                                    <div class="p-3">
                                        No Record Found! 
                                    </div>
                                </td>
                            </tr> 
                            <tr class="" v-for="(result, invoice_index) in $page.props.invoices.data" :key="result.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-700">{{ invoice_index + 1 }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ result.student_name }}
                                        </p>
                                    </div>
                                    <div class="mt-2 sm:flex sm:justify-between">
                                        <div class="flex items-center space-x-2">
                                            <p class="flex items-center text-sm text-gray-500">
                                            #{{ result.invoice_number }}
                                            </p>
                                            <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-1 w-1 text-gray-400" viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z"/>
                                            </svg>
                                            <p class="flex items-center text-sm text-gray-500">
                                            {{ result.invoice_number }}
                                            </p> -->
                                        </div>
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">{{ result.title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ moment(result.date_issued).format('DD MMM Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ moment(result.due_date).format('DD MMM Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ result.amount }}</div>
                                </td>
                                <td class="">
                                    <div class="ml-2 flex-shrink-0 flex">
                                        <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800" :class="[result.status_bg_color, result.status_text_color]">
                                        {{ result.status }}
                                        </p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center justify-start space-x-2">
                                        <!-- <BreezeButton buttonType="blue" @click="viewInvoice(invoice_index)">View / Print</BreezeButton> -->
                                        <BreezeButton buttonType="warning" @click="editInvoice(result.id)" v-if="$page.props.can.edit_fee_invoices">Edit / Collect Payment</BreezeButton>
                                        <BreezeButton buttonType="danger" @click="deleteInvoice(result.id)" v-if="$page.props.can.delete_fee_invoices && result.can_delete == 1">Delete</BreezeButton>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <Pagination :page_data="$page.props.invoices" :params="params"></Pagination>
                </div>
            </div>
        </div>
        <ConfirmationModal 
            :show="isOpen" 
            @close="isOpen = false"
            confirmationAlert="danger"
            confirmationTitle="Delete Invoice"
            confirmationText="Are you sure want to delete this invoice?"
            confirmationButton="Delete"
            confirmationMethod="delete"
            :confirmationRoute="confirmationRoute"
            :confirmationData="confirmationData"
        />
    </BreezeAuthenticatedLayout>
</template>

<script>
import { SearchIcon, TrashIcon, PencilIcon } from '@heroicons/vue/solid'
import { Head, Link } from '@inertiajs/inertia-vue3';
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import Pagination from '@/Components/Pagination.vue'
import moment from 'moment';
import Multiselect from '@vueform/multiselect'
import Datepicker from '@vuepic/vue-datepicker';
import MonthlyFee from '@/Pages/Invoices/MonthlyFee.vue'
import { debounce } from 'vue-debounce'

const printOptions = {
    name: '_blank',
    specs: [
    ],
    styles: [
        'http://127.0.0.1:8000/css/app.css',
    ],
    timeout: 1000, // default timeout before the print window appears
    autoClose: true, // if false, the window will not close after printing
    windowTitle: window.document.title, // override the window title
}

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon, Head, Link, ConfirmationModal, Multiselect, Datepicker, MonthlyFee
    },
    data(){
        return{
            printing: false,
            loading_resource: false,
            show_resource: false,
            isOpen: false,
            confirmationData: '',
            confirmationRoute: '',
            open_modal: false,
            params: {
                search: this.$page.props.filter.search ? this.$page.props.filter.search : '',
                centre_id: this.$page.props.filter.centre_id ? this.$page.props.filter.centre_id : '',
                programme_id: this.$page.props.filter.programme_id ? this.$page.props.filter.programme_id : '',
                date: this.$page.props.filter.date ? this.$page.props.filter.date : { month: new Date().getMonth(), year: new Date().getFullYear() },
            },
            invoice_data: {
                parent_name: '',
                parent_address: 'No 27, Jalan Kap Empat, 17/17D, Seksyen 17, Shah Alam',
                invoice_number: '',
                invoice_items: [],
                date_issued: '',
                due_date: '',
                total_amount: ''
            }
        }
    },
    watch: {
        'params.date': {
            handler(){
                this.$inertia.get(route('fee.invoices'), this.params, { replace: true, preserveState: true})
            },
            deep: true
        }
    },
    methods: {
        viewInvoice(invoice_index){
            this.invoice_data.student_name      = this.$page.props.invoices.data[invoice_index].student_name
            this.invoice_data.parent_name       = this.$page.props.invoices.data[invoice_index].parent_full_name
            this.invoice_data.parent_address    = this.$page.props.invoices.data[invoice_index].parent_address
            this.invoice_data.invoice_number    = this.$page.props.invoices.data[invoice_index].invoice_number
            this.invoice_data.invoice_items     = JSON.parse(this.$page.props.invoices.data[invoice_index].invoice_items)
            this.invoice_data.date_issued       = this.$page.props.invoices.data[invoice_index].date_issued
            this.invoice_data.due_date          = this.$page.props.invoices.data[invoice_index].due_date
            this.invoice_data.total_amount      = this.totalFee(this.$page.props.invoices.data[invoice_index].invoice_items)
            
            this.open_modal = true
        },
        editInvoice(invoice_id){
            this.$inertia.get(route('fee.invoices.edit'), {'invoice_id':invoice_id, 'params': this.params}, {preserveState: false})
        },
        deleteInvoice(invoice_id){
            this.confirmationRoute = 'fee.invoices.destroy'
            this.confirmationData = invoice_id
            this.isOpen = true
        },
        totalFee(invoice_items) {
            let total = 0;
            const parsed_invoice_items =   JSON.parse(invoice_items)
            for (const item of parsed_invoice_items) {
                // Parse fees and discounts as numbers
                const programmeFee = parseFloat(item.programme_fee);
                const programmeDiscount = parseFloat(item.programme_fee_discount);
                const materialFee = parseFloat(item.material_fee);
                const materialDiscount = parseFloat(item.material_fee_discount);

                // Add programme fee and subtract programme discount
                total += programmeFee - programmeDiscount;

                // Check if material fee should be included
                if (item.include_material_fee) {
                // Add material fee and subtract material discount
                total += materialFee - materialDiscount;
                }
            }
            return total;
        },
        print(){
            this.printing = true
            this.$htmlToPaper('invoice', printOptions, () => {
                this.printing = false
            })
        },
        search(){
            this.$inertia.get(route('fee.invoices'), this.params, { replace: true, preserveState: true})
        }
    },
}
</script>