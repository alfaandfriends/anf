<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<style>
.multiselect-assistive-text{
    display: none;
}
.invoices-input-date-picker{
    border: 1px solid #D1D5DB; /* Default border color and thickness */
    border-radius: 0.35rem;
}
:hover.invoices-input-date-picker  {
    border: 1px solid #D1D5DB; /* Highlighted border color and thickness */
}
:focus.invoices-input-date-picker  {
    border: 1px solid #D1D5DB; /* Highlighted border color and thickness */
}
</style>

<template>
    <Head title="Fee Invoices" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 bg-indigo-50 space-y-6 sm:p-6">
                        <div class="grid grid-rows-1 grid-cols-2 sm:grid-cols-2 gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md h-full">
                                    <div class="mb-5">
                                        <h1 class="font-bold text-indigo-800">Invoice Information</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div class="mb-4">
                                            <label for="student_id" class="block text-sm font-bold text-gray-700"> Student Name </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <Multiselect 
                                                v-debounce="findStudents"
                                                v-model="form.student_id"
                                                @close="clearStudents"
                                                valueProp="id"
                                                :loading="list.isLoading"
                                                placeholder="Please enter some characters"
                                                :options="list.students"
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
                                                        formError.student_id ? 
                                                        'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-red-300 rounded-md bg-white sm:text-sm leading-snug outline-none h-10':
                                                        'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white sm:text-sm leading-snug outline-none h-10',
                                                    containerDisabled: 'cursor-default bg-gray-100',
                                                    containerOpen: 'rounded-b-none',
                                                    containerOpenTop: 'rounded-t-none',
                                                    containerActive: 'border border-indigo-300',
                                                    singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                                    singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                                    multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                    search: 'w-full inset-0 outline-none focus:ring-0 appearance-none box-border border-0 sm:text-sm font-sans bg-white rounded-md pl-3.5',
                                                    placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500',
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
                                    <div class="grid grid-cols-1 gap-4">
                                        <div class="mb-4">
                                            <label for="student_id" class="block text-sm font-bold text-gray-700"> Create Bulk (Multiple Invoices) </label>
                                            <Toggle v-model="form.create_bulk" 
                                                :classes="{
                                                    container: 'mt-1 inline-block',
                                                    toggle: 'flex w-12 h-5 rounded-full relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
                                                    toggleOn: 'bg-indigo-500 border-indigo-500 justify-start text-white',
                                                    toggleOff: 'bg-gray-400 border-gray-400 justify-end text-gray-700',
                                                }
                                            "/>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4" v-if="!form.create_bulk">
                                        <div class="mb-4">
                                            <label for="date_issued" class="block text-sm font-bold text-gray-700"> Date Issued </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <Datepicker 
                                                    :class="'focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm'" 
                                                    :style="formError.date_issued ? '--dp-border-color: #fa9e9e' : ''" 
                                                    input-class-name="invoices-input-date-picker focus:ring-0"
                                                    v-model="form.date_issued" 
                                                    :enableTimePicker="false"
                                                    :format="'dd/MM/yyyy'"
                                                    :auto-apply="true" 
                                                />
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="due_date" class="block text-sm font-bold text-gray-700"> Due Date </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <Datepicker 
                                                    :class="'focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm'" 
                                                    :style="formError.due_date ? '--dp-border-color: #fa9e9e' : ''" 
                                                    input-class-name="invoices-input-date-picker focus:ring-0"
                                                    v-model="form.due_date" 
                                                    :enableTimePicker="false"
                                                    :format="'dd/MM/yyyy'"
                                                    :auto-apply="true" 
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4" v-else>
                                        <div class="mb-4">
                                            <label for="from_date" class="block text-sm font-bold text-gray-700"> From </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <Datepicker 
                                                    :class="'focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm'" 
                                                    :style="formError.from_date ? '--dp-border-color: #fa9e9e' : ''" 
                                                    input-class-name="invoices-input-date-picker focus:ring-0"
                                                    v-model="form.from_date" 
                                                    :enableTimePicker="false"
                                                    :month-picker="true"
                                                    :format="'dd/MM/yyyy'"
                                                    :auto-apply="true" 
                                                />
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="to_date" class="block text-sm font-bold text-gray-700"> To </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <Datepicker no-today
                                                    :class="'focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm'" 
                                                    :style="formError.to_date ? '--dp-border-color: #fa9e9e' : ''" 
                                                    input-class-name="invoices-input-date-picker focus:ring-0"
                                                    v-model="form.to_date" 
                                                    :enableTimePicker="false"
                                                    :format="'dd/MM/yyyy'"
                                                    :auto-apply="true" 
                                                    :month-picker="true"
                                                    :min-date="`${form.from_date.year}-${form.from_date.month+1}`"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-5 mt-5">
                                        <div class="flex justify-between items-center">
                                            <h1 class="font-bold text-indigo-800"> Programmes </h1>
                                        </div>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <div class="mb-10">
                                            <div class="flex justify-end mb-3">
                                                <BreezeButton buttonType="info" @click="addProgramme">Add Programme</BreezeButton>
                                            </div>
                                            <table class="w-full">
                                                <thead>
                                                    <tr class="bg-gray-600">
                                                        <th class="text-left text-white text-sm py-2 px-4 w-1/12">#</th>
                                                        <th class="text-left text-white text-sm py-2 px-4 w-7/12">Programme</th>
                                                        <th class="text-left text-white text-sm py-2 px-4 w-2/12">Discount</th>
                                                        <th class="text-left text-white text-sm py-2 px-4 w-2/12">Amount</th>
                                                        <th class="text-left text-white text-sm py-2 px-4 w-2/12">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-if="!form.invoice_items.length">
                                                        <td colspan="10" class="py-4 text-center">No programme added</td>
                                                    </tr>
                                                    <tr v-for="item, invoice_item_index in form.invoice_items">
                                                        <td class="border text-sm align-top py-2 px-4">{{ invoice_item_index + 1 }}</td>
                                                        <td class="border text-sm py-2 px-4">
                                                            <div class="flex flex-col space-y-4">
                                                                <div class="bg-indigo-300 py-2 px-3 rounded-t-md">
                                                                    <label class="font-semibold"> {{ item.programme_name }} ( Level {{ item.programme_level }} )</label>
                                                                </div>
                                                                <div class="flex flex-col space-y-2 pl-5">
                                                                    <div class="bg-indigo-100 py-1 px-3 rounded-sm">
                                                                        <label> {{ item.programme_type }} </label>
                                                                    </div>
                                                                    <div class="bg-indigo-100 py-1 px-3 rounded-sm" v-if="item.include_material_fee">
                                                                        <label> Material Fee </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="border text-sm py-2 px-4 align-bottom">
                                                            <div class="flex flex-col space-y-1.5">
                                                                <input type="number" min="0" name="" id="" class="py-1 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" v-model="item.programme_fee_discount" autocomplete="off" @input="numbersOnly($event, invoice_item_index)">
                                                                <input  v-if="item.include_material_fee" type="number" min="0" name="" id="" class="py-1 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" v-model="item.material_fee_discount" autocomplete="off" @input="numbersOnly($event, invoice_item_index)">
                                                            </div>
                                                        </td>
                                                        <td class="border text-sm py-2 px-4 align-bottom">
                                                            <div class="flex flex-col space-y-1.5">
                                                                <input type="number" min="0" name="" id="" class="py-1 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" v-model="item.programme_fee" autocomplete="off" @input="numbersOnly($event, invoice_item_index)">
                                                                <input  v-if="item.include_material_fee" type="number" min="0" name="" id="" class="py-1 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" v-model="item.material_fee" autocomplete="off" @input="numbersOnly($event, invoice_item_index)">
                                                            </div>
                                                        </td>
                                                        <td class="border text-sm py-2 px-4 self-center">
                                                            <BreezeButton buttonType="danger" @click="deleteProgramme(invoice_item_index)">Delete</BreezeButton>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class=" border-b border-dashed border-indigo-900 mb-5"></div>
                                    <div class="grid grid-cols-3">
                                        <div class="mb-4 text-left">
                                            <label for="payment_status" class="block text-sm font-bold text-gray-700"> Payment Status </label>
                                            <select name="payment_status" id="payment_status" class="mt-1 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" autocomplete="off" v-model="form.status">
                                                <option :value="status.id" v-for="status in $page.props.payment_status">{{ status.name }}</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                        </div>
                                        <div class="mb-4 text-right pr-5">
                                            <label for="amount" class="block text-md font-bold text-gray-700"> Total Amount </label>
                                            <span class="text-2xl font-bold text-indigo-500">{{ totalFee(form.invoice_items) }}</span>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md h-full">
                                    <div class="mb-5">
                                        <h1 class="font-bold text-indigo-800">Collect Payment</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <div class="mb-4">
                                            <label for="date" class="block text-sm font-bold text-gray-700"> Date </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                
                                                <Datepicker 
                                                    :class="'focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm'" 
                                                    input-class-name="invoices-input-date-picker focus:ring-0"
                                                    v-model="form.payment.date" 
                                                    :enableTimePicker="false"
                                                    :format="'dd/MM/yyyy'"
                                                    :auto-apply="true" 
                                                />
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="transaction_id" class="block text-sm font-bold text-gray-700"> Transaction ID </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="transaction_id" id="transaction_id" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.transaction_id ? 'border-red-300' : 'border-gray-300'" v-model="form.payment.transaction_id" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <div class="mb-4">
                                            <label for="student_name" class="block text-sm font-bold text-gray-700"> Proof of Payment </label>
                                            <div class="mt-1 items-center space-x-2 w-full">
                                                <div class="mb-4" v-if="!form.payment.proof.url.length"> 
                                                    <label class="block focus:ring-0 focus:border-gray-300">
                                                        <span class="sr-only">Browse File</span>
                                                        <input type="file" ref="file_input" class="focus:ring-0 border rounded-md block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-gray-700 focus:outline-none" :class="$page.props.errors.proof ? 'border-red-300' : 'border-gray-300'" @change="uploadFile"/>
                                                    </label>
                                                </div>
                                                <div class="flex justify-between py-2 border bg-gray-50 shadow-md p-4 rounded-md" v-else>
                                                    <a :href="form.payment.proof.file ? form.payment.proof.url : '/storage/proof_of_payment/' + form.payment.proof.url" download class="flex items-center space-x-2 text-indigo-500 hover:text-indigo-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 448 512">
                                                            <path d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z"/>
                                                        </svg>
                                                        <span>{{ form.payment.proof.file ? form.payment.proof.file.name : form.payment.proof.url  }}</span>
                                                    </a>
                                                    <div class="flex">
                                                        <button type="button" class="rounded-md p-2 bg-red-500 text-white" @click="deleteProof()">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" fill="currentColor" class="text-white h-3 w-3">
                                                                <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="flex items-center justify-end">
                                        <div class="flex space-x-2">
                                            <BreezeButton buttonType="gray" :route="route('fee.invoices')">Cancel</BreezeButton>
                                            <BreezeButton type="submit">Save</BreezeButton>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <Modal :showModal="open_modal" modalType="md" @hideModal="open_modal = false">
            <template v-slot:header>
                <h3 class="text-gray-900 text-xl font-semibold">                
                    Invoice
                </h3>                
            </template>
            <template v-slot:content>
                <div class="p-5">
                    <div class="grid grid-cols-1">
                        <div class="mb-4">
                            <label for="student_id" class="block text-sm font-bold text-gray-700"> Centre </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <Multiselect 
                                v-model="programme_form.centre_id"
                                valueProp="ID"
                                placeholder="Please enter some keywords"
                                :options="$page.props.allowed_centres"
                                :searchable="true"
                                noOptionsText="Nothing found"
                                noResultsText="Nothing found"
                                :clearOnSelect="true"
                                :canClear="false"
                                :canDeselect="false"
                                :internal-search="false"
                                trackBy="label"
                                label="label"
                                :classes="{
                                    container: 
                                        error.centre_id ? 
                                        'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-red-300 rounded-md bg-white sm:text-sm leading-snug outline-none h-10':
                                        'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white sm:text-sm leading-snug outline-none h-10',
                                    containerDisabled: 'cursor-default bg-gray-100',
                                    containerOpen: 'rounded-b-none',
                                    containerOpenTop: 'rounded-t-none',
                                    containerActive: 'border border-indigo-300',
                                    singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                    singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                    multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                    search: 'w-full inset-0 outline-none focus:ring-0 appearance-none box-border border-0 sm:text-sm font-sans bg-white rounded-md pl-3.5',
                                    placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500',
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
                        <div class="mb-4">
                            <label for="student_id" class="block text-sm font-bold text-gray-700"> Programme </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <select name="programme_id" id="programme_id" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="error.programme_id ? 'border-red-300' : 'border-gray-300'" v-model="programme_form.programme_id" autocomplete="off">
                                    <option value="">Please Select</option>
                                    <option :value="programme.id" v-for="(programme, index) in $page.props.programmes" :key="index">{{ programme.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="programme_level" class="block text-sm font-bold text-gray-700"> Programme Level</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <select name="programme_level" id="programme_level" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="error.programme_level ? 'border-red-300' : 'border-gray-300'" v-model="programme_form.programme_level" autocomplete="off">
                                    <option value="">Please Select</option>
                                    <option :value="level.level" v-for="(level, index) in $page.props.levels" :key="index">{{ level.level }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="fee_type_id" class="block text-sm font-bold text-gray-700"> Fee Type</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <select name="fee_type_id" id="fee_type_id" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="error.programme_type ? 'border-red-300' : 'border-gray-300'" v-model="programme_form.programme_type" autocomplete="off">
                                    <option value="">Please Select</option>
                                    <option :value="fee_type.id" v-for="(fee_type, index) in $page.props.fee_types" :key="index">{{ fee_type.label }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="include_material_fee" class="cursor-pointer">
                                <input id="include_material_fee" class="form-check-input h-5 w-5 mt-0.5 border border-gray-300 rounded-sm bg-white hover:bg-white focus:ring-transparent text-indigo-500 transition duration-200 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" v-model="programme_form.include_material_fee" :value="programme_form.include_material_fee"> Include Material Fee
                            </label>
                        
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot:footer>
                <div class="flex justify-end space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                    <BreezeButton buttonType="gray" @click="cancelProgramme">Cancel</BreezeButton>
                    <BreezeButton buttonType="info" @click="saveProgramme">Save</BreezeButton>
                </div>
            </template>
        </Modal>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import moment from 'moment';
import Datepicker from '@vuepic/vue-datepicker';
import Multiselect from '@vueform/multiselect'
import { debounce } from 'vue-debounce'
import Modal from '@/Components/Modal.vue'
import Toggle from '@vueform/toggle';

export default {
    components: {
        Head, Link, Multiselect, Modal, Toggle
    },
    data(){
        return{
            open_modal: false,
            form: {
                create_bulk: false,
                from_date: '',
                to_date: '',
                formatted_to_date: '',
                student_id: '',
                invoice_items: [],
                date_issued: '',
                due_date: '',
                invoice_amount: '',
                status: 1,
                payment: {
                    date: '',
                    transaction_id: '',
                    proof: {
                        url: '',
                        file: '',
                    }
                }
            },
            list: {
                isLoading: false,
                students: []
            },
            programme_form: {
                centre_id: '',
                centre_name: '',
                programme_id: '',
                programme_name: '',
                programme_level: '',
                programme_type: '',
                programme_fee: '',
                programme_fee_discount: '',
                include_material_fee: false,
                material_fee: '',
                material_fee_discount: '',
            },
            error: {
                centre_id: false,
                programme_id: false,
                programme_level: false,
                programme_type: false,
            },
            formError: {
                student_id: false,
                date_issued: false,
                due_date: false,
                from_date: false,
                to_date: false,
            }
        }
    },
    watch: {
        'form.invoice_items': {
            handler(newVal) {
                newVal.forEach(item => {
                    !item.programme_fee             ? item.programme_fee = 0 : ''
                    !item.programme_fee_discount    ? item.programme_fee_discount = 0 : ''
                    !item.material_fee              ? item.material_fee = 0 : ''
                    !item.material_fee_discount     ? item.material_fee_discount = 0 : ''
                });
            },
            deep: true,
        },
        'form.create_bulk': {
            handler() {
                this.formError.date_issued = false,
                this.formError.due_date = false,
                this.formError.from_date = false,
                this.formError.to_date = false,
                this.form.from_date = '',
                this.form.to_date = '',
                this.form.date_issued = '',
                this.form.due_date = ''
            },
            deep: true,
        },
        'form.from_date': {
            handler() {
                this.form.to_date = ''
            },
            deep: true,
        }
    },
    methods: {
        submit() {
            this.formError.student_id   = !this.form.student_id ? true : false
            this.formError.date_issued  = !this.form.create_bulk && !this.form.date_issued ? true : false
            this.formError.due_date     = !this.form.create_bulk && !this.form.due_date ? true : false
            this.formError.from_date    = this.form.create_bulk && !this.form.from_date ? true : false
            this.formError.to_date      = this.form.create_bulk && !this.form.to_date ? true : false
            
            const hasError    =   Object.values(this.formError).some(value => value === true)
            if(!hasError){
                if(this.form.invoice_items.length < 1){
                    alert('Please add at least 1 programme.')
                    return
                }
                this.form.invoice_amount = this.totalFee(this.form.invoice_items)
                this.$inertia.post(route('fee.invoices.store'), this.form, { preserveState: true})
            }
        },
        numbersOnly (evt, index){
            evt = evt ? evt : window.event;
            var charCode = evt.which ? evt.which : evt.keyCode;
            
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();
            } else {
                // Get the input value
                let inputValue = evt.target.value.trim();
                
                if (inputValue === '') {
                inputValue = '0'; // Set default value as 0
                } else if (inputValue !== '0' && inputValue.startsWith('0')) {
                // Remove leading zero if it exists
                inputValue = inputValue.replace(/^0+/, '');
                }
                
                evt.target.value = inputValue !== '' ? inputValue : '0'; // Keep '0' if value is empty
                
                return true;
            }
        },
        totalFee(invoice_items) {
            let total = 0;
            for (const item of invoice_items) {
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
        deleteProof(){
            this.form.payment.proof.url                 =   []
            this.form.payment.proof.file                =   ''
            this.form.payment.proof.delete_previous     =   true
        },
        uploadFile($event){
            const file  =   $event.target.files[0]
            
            if(file.type == 'application/pdf' || file.name.toLowerCase().endsWith('.pdf') || file.type == 'image/jpeg' || file.name.toLowerCase().endsWith('.png')){
                this.form.payment.proof.url     =   [URL.createObjectURL(file)];
                this.form.payment.proof.file    =   file
            }
            else{
                alert('Only Image / PDF File allowed!')
                this.$refs.file_input.value = ''
                this.form.payment.proof.url = ''
                this.form.payment.proof.file = ''
            }
        },
        findStudents(query){
            debounce(val => '400ms')(10)
            if(query){
                this.list.isLoading = true
                axios.get(route('students.find'), {
                    params: {
                        'keyword': query
                    }
                })
                .then((res) => {
                    this.list.students = res.data
                    this.list.isLoading = false
                });
            }
        },
        addProgramme(){
            this.programme_form.centre_id   =   ''
            this.programme_form.centre_name   =   ''
            this.programme_form.programme_id   =   ''
            this.programme_form.programme_name   =   ''
            this.programme_form.programme_level   =   ''
            this.programme_form.programme_type   =   ''
            this.programme_form.include_material_fee   =   false
            this.open_modal = true
        },
        saveProgramme(){
            this.error.centre_id        = !this.programme_form.centre_id ? true : false
            this.error.programme_id     = !this.programme_form.programme_id ? true : false
            this.error.programme_level  = !this.programme_form.programme_level ? true : false
            this.error.programme_type   = !this.programme_form.programme_type ? true : false
            
            const hasError    =   Object.values(this.error).some(value => value === true)
            if(!hasError){
                this.form.invoice_items.push({
                    centre_id: this.programme_form.centre_id,
                    centre_name: this.$page.props.allowed_centres.find(obj => obj.ID === this.programme_form.centre_id)?.label,
                    programme_id: this.programme_form.programme_id,
                    programme_name: this.$page.props.programmes.find(obj => obj.id === this.programme_form.programme_id)?.name,
                    programme_level: this.programme_form.programme_level,
                    programme_type: this.$page.props.fee_types.find(obj => obj.id === this.programme_form.programme_type)?.label,
                    programme_fee: 0,
                    programme_fee_discount: 0,
                    include_material_fee: this.programme_form.include_material_fee,
                    material_fee: 0,
                    material_fee_discount: 0,
                })
                this.open_modal = false
            }
        },
        cancelProgramme(){
            this.error.centre_id        = false
            this.error.programme_id     = false
            this.error.programme_level  = false
            this.error.programme_type   = false
            this.open_modal = false
        },
        deleteProgramme(index){
            this.form.invoice_items.splice(index, 1)
        }
    },
}
</script>
