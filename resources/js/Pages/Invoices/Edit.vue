<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Invoices" />

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
                                    <div class="grid grid-cols-1">
                                        <div class="mb-4">
                                            <label for="invoice_number" class="block text-sm font-bold text-gray-700"> Invoice Number <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input disabled type="text" name="invoice_number" id="invoice_number" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 bg-gray-100" v-model="this.$page.props.invoice_data.invoice_number" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="mb-4">
                                            <label for="date_issued" class="block text-sm font-bold text-gray-700"> Date Issued <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input disabled type="text" name="date_issued" id="date_issued" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 bg-gray-100" v-model="date_issued" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="due_date" class="block text-sm font-bold text-gray-700"> Due Date <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input disabled type="text" name="due_date" id="due_date" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 bg-gray-100" v-model="due_date" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <div class="mb-4">
                                            <label for="student_name" class="block text-sm font-bold text-gray-700"> Student Name <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input disabled type="text" name="student_name" id="student_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 bg-gray-100" v-model="this.$page.props.invoice_data.student_name" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <div class="mb-10">
                                            <table>
                                                <thead>
                                                    <tr class="bg-gray-600">
                                                        <th class="text-left text-white text-sm py-2 px-4 w-1/12">#</th>
                                                        <th class="text-left text-white text-sm py-2 px-4 w-7/12">Programme</th>
                                                        <th class="text-left text-white text-sm py-2 px-4 w-2/12">Discount</th>
                                                        <th class="text-left text-white text-sm py-2 px-4 w-2/12">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="item, index in form.invoice_items">
                                                        <td class="border text-sm align-top py-2 px-4">{{ index + 1 }}</td>
                                                        <td class="border text-sm py-2 px-4">
                                                            <div class="flex flex-col space-y-4">
                                                                <div class="bg-indigo-300 py-2 px-3 rounded-t-md">
                                                                    <label class="font-semibold"> {{ item.programme }} ( Level {{ item.programme_level }} )</label>
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
                                                                <input type="number" min="0" name="" id="" class="py-1 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" v-model="item.programme_fee_discount" autocomplete="off" @input="numbersOnly">
                                                                <input  v-if="item.include_material_fee" type="number" min="0" name="" id="" class="py-1 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" v-model="item.material_fee_discount" autocomplete="off" @input="numbersOnly">
                                                            </div>
                                                        </td>
                                                        <td class="border text-sm py-2 px-4 align-bottom">
                                                            <div class="flex flex-col space-y-1.5">
                                                                <input type="number" min="0" name="" id="" class="py-1 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" v-model="item.programme_fee" autocomplete="off" @input="numbersOnly">
                                                                <input  v-if="item.include_material_fee" type="number" min="0" name="" id="" class="py-1 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" v-model="item.material_fee" autocomplete="off" @input="numbersOnly">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-3">
                                        <div class="mb-4">
                                            <label for="amount" class="block text-sm font-bold text-gray-700"> Payment Status </label>
                                            <div class="p-1.5 px-3 rounded flex font-semibold mt-2" :class="[$page.props.invoice_data.status_text_color, $page.props.invoice_data.status_bg_color]">{{ $page.props.invoice_data.status }}</div>
                                            <div class=" flex rounded-md shadow-sm">
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                        </div>
                                        <div class="mb-4">
                                            <label for="amount" class="block text-sm font-bold text-gray-700"> Total Amount <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input disabled type="text" name="amount" id="amount" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 bg-gray-100" :value="calculateTotals(this.form.invoice_items)" autocomplete="off">
                                            </div>
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
                                            <label for="payment_type" class="block text-sm font-bold text-gray-700"> Payment Type <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select name="payment_type" id="payment_type" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.payment_type ? 'border-red-300' : 'border-gray-300'" v-model="form.payment.status" autocomplete="off">
                                                    <option value="">Please Select</option>
                                                    <option :value="type.id" v-for="type, index in $page.props.payment_types" :key="type.id">{{ type.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <div class="mb-4">
                                            <label for="transaction_id" class="block text-sm font-bold text-gray-700"> Transaction ID <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="transaction_id" id="transaction_id" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.transaction_id ? 'border-red-300' : 'border-gray-300'" v-model="form.payment.transaction_id" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="date" class="block text-sm font-bold text-gray-700"> Date <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                
                                                <Datepicker 
                                                    :class="'focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm'" 
                                                    :style="$page.props.errors.date ? '--dp-border-color: #fa9e9e' : ''" 
                                                    input-class-name="date-picker"
                                                    v-model="form.payment.date" 
                                                    :enableTimePicker="false"
                                                    :auto-apply="true" 
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <div class="mb-4">
                                            <label for="student_name" class="block text-sm font-bold text-gray-700"> Proof of Payment <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
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
                                            <BreezeButton buttonType="gray" :route="route('invoices')">Cancel</BreezeButton>
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
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import moment from 'moment';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import 'viewerjs/dist/viewer.css'
import { component as Viewer } from "v-viewer"

export default {
    components: {
        Head, Link, Viewer
    },
    data(){
        return{
            date_issued: moment(this.$page.props.invoice_data.date_issued).format('DD MMM Y'),
            due_date: moment(this.$page.props.invoice_data.due_date).format('DD MMM Y'),
            form: {
                invoice_id: this.$page.props.invoice_data.id,
                invoice_items: JSON.parse(this.$page.props.invoice_data.invoice_items),
                payment: {
                    status: '',
                    transaction_id: '',
                    date: ''
                }
            },
            viewer_options: { 
                inline: false, 
                
                url: 'data-source' 
            },
            images: [
                "https://picsum.photos/200/200"
            ]
        }
    },
    methods: {
        submit() {
            this.$inertia.post(route('invoices.update'), this.form, { preserveState: true})
        },
        numbersOnly (evt){
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
        calculateTotals(invoice_items) {
            let programmeFeeSum = 0;
            let materialFeeSum = 0;
            let programmeFeeDiscountSum = 0;
            let materialFeeDiscountSum = 0;

            invoice_items.forEach(item => {
                programmeFeeSum += item.programme_fee;
                programmeFeeDiscountSum += item.programme_fee_discount;

                if (item.include_material_fee) {
                materialFeeSum += item.material_fee;
                materialFeeDiscountSum += item.material_fee_discount;
                }
            });

            this.programmeFeeTotal = programmeFeeSum;
            this.materialFeeTotal = materialFeeSum;
            this.programmeFeeDiscountTotal = programmeFeeDiscountSum;
            this.materialFeeDiscountTotal = materialFeeDiscountSum;

            const grandTotal = (programmeFeeSum - programmeFeeDiscountSum) + (materialFeeSum - materialFeeDiscountSum);

            return grandTotal
        },
        show(){
            this.$viewerApi({options: {
                button: true, 
                navbar: false, 
                title: false, 
                toolbar: false, 
                tooltip: false, 
                movable: false, 
                zoomable: false, 
                rotatable: false, 
                scalable: true, 
                transition: true, 
                fullscreen: true, 
                keyboard: false, 
                movable: false, 
            }, images: ['https://picsum.photos/1280/800']})
        }
    },
}
</script>