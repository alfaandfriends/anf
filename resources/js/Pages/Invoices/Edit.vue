<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<style>
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
                        <div class="grid grid-cols-1 2xl:grid-cols-3 gap-4">
                            <div class="lg:col-span-2">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md h-full">
                                    <div class="mb-5">
                                        <h1 class="font-bold text-indigo-800">Invoice Information</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <div class="mb-4">
                                            <label for="invoice_number" class="block text-sm font-bold text-gray-700"> Invoice Number </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input disabled type="text" name="invoice_number" id="invoice_number" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 bg-gray-100" v-model="$page.props.invoice_data.invoice_number" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <div class="mb-4">
                                            <label for="student_name" class="block text-sm font-bold text-gray-700"> Student Name </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input disabled type="text" name="student_name" id="student_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 bg-gray-100" v-model="$page.props.invoice_data.student_name" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="mb-4">
                                            <label for="date_issued" class="block text-sm font-bold text-gray-700"> Date Issued </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input disabled type="text" name="date_issued" id="date_issued" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 bg-gray-100" v-model="date_issued" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="due_date" class="block text-sm font-bold text-gray-700"> Due Date </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input disabled type="text" name="due_date" id="due_date" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 bg-gray-100" v-model="due_date" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <div class="mb-10">
                                            <table class="w-full">
                                                <thead>
                                                    <tr class="bg-gray-600">
                                                        <th class="text-left text-white text-sm py-2 px-4 w-1/12">#</th>
                                                        <th class="text-left text-white text-sm py-2 px-4 w-7/12">Items</th>
                                                        <th class="text-center text-white text-sm py-2 px-4 w-2/12">Discount</th>
                                                        <th class="text-center text-white text-sm py-2 px-4 w-2/12">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="item, index in form.invoice_items">
                                                        <td class="border text-sm text-center py-2 px-4">{{ index + 1 }}</td>
                                                        <td class="border text-sm py-2 px-4">
                                                            <div class="grid grid-rows-1 gap-2">
                                                                <div class="border border-dashed border-indigo-400 bg-indigo-200 rounded py-1 px-3">
                                                                    <label class="font-semibold"> {{ item.programme_name }} ( Level {{ item.programme_level }} )</label>
                                                                </div>
                                                                <div class="flex flex-col space-y-2 pl-5">
                                                                    <div class="border border-dashed border-indigo-400 rounded py-1 px-3">
                                                                        <label> {{ item.programme_type }} </label>
                                                                    </div>
                                                                    <div class="bg-indigo-100 py-1 px-3 rounded-sm" v-if="item.include_registration_fee">
                                                                        <label> Registration Fee </label>
                                                                    </div>
                                                                    <div class="bg-indigo-100 py-1 px-3 rounded-sm" v-if="item.include_material_fee">
                                                                        <label> Material Fee </label>
                                                                    </div>
                                                                    <div class="border border-dashed border-blue-400 bg-blue-100 rounded py-1 px-3 space-x-1" v-if="item.promos" v-for="promo in item.promos">
                                                                        <label class="text-xs text-white px-1.5 py-0.5 bg-blue-500 rounded">Promo</label> <label> {{ promo.promo_name }} </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="border text-sm py-2 px-4 align-bottom">
                                                            <div class="flex flex-col space-y-1.5">
                                                                <input type="number" min="0" name="" id="" class="bg-gray-50 py-1 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 cursor-not-allowed" v-model="item.programme_fee_discount" autocomplete="off" @input="numbersOnly" disabled>
                                                                <input v-if="item.include_registration_fee" type="number" min="0" name="" id="" class="bg-gray-50 py-1 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 cursor-not-allowed" v-model="item.registration_fee_discount" autocomplete="off" @input="numbersOnly" disabled>
                                                                <input v-if="item.include_material_fee" type="number" min="0" name="" id="" class="bg-gray-50 py-1 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 cursor-not-allowed" v-model="item.material_fee_discount" autocomplete="off" @input="numbersOnly" disabled>
                                                                <input v-if="item.promos" v-for="promo in item.promos" type="number" min="0" name="" id="" class="bg-gray-50 py-1 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 cursor-not-allowed" :value="promo.type_id === 1 ? item.programme_fee * promo.value / 100 : promo.value" autocomplete="off" @input="numbersOnly" disabled>
                                                            </div>
                                                        </td>
                                                        <td class="border text-sm py-2 px-4 align-bottom">
                                                            <div class="flex flex-col space-y-1.5">
                                                                <input type="number" min="0" name="" id="" class="bg-gray-50 py-1 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 cursor-not-allowed" v-model="item.programme_fee" autocomplete="off" @input="numbersOnly" disabled>
                                                                <input v-if="item.include_registration_fee" type="number" min="0" name="" id="" class="bg-gray-50 py-1 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 cursor-not-allowed" v-model="item.registration_fee" autocomplete="off" @input="numbersOnly" disabled>
                                                                <input v-if="item.include_material_fee" type="number" min="0" name="" id="" class="bg-gray-50 py-1 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 cursor-not-allowed" v-model="item.material_fee" autocomplete="off" @input="numbersOnly" disabled>
                                                                <input v-if="item.promos" v-for="promo in item.promos" type="number" min="0" name="" id="" class="bg-gray-50 py-1 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 cursor-not-allowed" :value="0" @input="numbersOnly" disabled>
                                                            </div>
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
                                            <select name="payment_status" id="payment_status" class="mt-1 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" autocomplete="off" v-model="form.payment.status">
                                                <option :value="status.id" v-for="status in $page.props.invoice_status">{{ status.name }}</option>
                                            </select>
                                            <!-- <div class="text-center p-1.5 px-3 rounded font-semibold mt-2" :class="[$page.props.invoice_data.status_text_color, $page.props.invoice_data.status_bg_color]">
                                                {{ $page.props.invoice_data.status }}
                                            </div> -->
                                        </div>
                                        <div class="mb-4">
                                        </div>
                                        <div class="mb-4 text-right pr-5">
                                            <label for="amount" class="block text-md font-bold text-gray-700"> Total Amount</label>
                                            <span class="text-2xl font-bold text-indigo-500">{{ totalFee(form.invoice_items) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lg:col-span-1">
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
                                                    :style="$page.props.errors.date ? '--dp-border-color: #fa9e9e' : ''" 
                                                    input-class-name="invoices-input-date-picker focus:ring-0"
                                                    v-model="form.payment.date" 
                                                    :enableTimePicker="false"
                                                    :auto-apply="true" 
                                                    :format="'dd/MM/yyyy'"
                                                />
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="transaction_id" class="block text-sm font-bold text-gray-700"> Transaction ID </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="transaction_id" id="transaction_id" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.transaction_id ? 'border-red-300' : 'border-gray-300'" v-model="form.payment.transaction_id" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="student_name" class="block text-sm font-bold text-gray-700"> Proof of Payment </label>
                                            <div class="mt-1 items-center space-x-2 w-full">
                                                <div class="" v-if="!form.payment.proof.url.length"> 
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
                                        <div class="mb-4">
                                            <label for="transaction_id" class="block text-sm font-bold text-gray-700"> Remark </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <textarea type="text" name="transaction_id" id="transaction_id" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.transaction_id ? 'border-red-300' : 'border-gray-300'" v-model="form.payment.remark" autocomplete="off"></textarea>
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
                                            <BreezeButton buttonType="gray" :route="route('fee.invoices', $page.props.params)">Cancel</BreezeButton>
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

export default {
    components: {
        Head, Link,
    },
    data(){
        return{
            date_issued: moment(this.$page.props.invoice_data.date_issued).format('DD MMM Y'),
            due_date: moment(this.$page.props.invoice_data.due_date).format('DD MMM Y'),
            form: {
                params: this.$page.props.params,
                invoice_id: this.$page.props.invoice_data.id,
                invoice_items: JSON.parse(this.$page.props.invoice_data.invoice_items),
                invoice_amount: this.$page.props.invoice_data.amount,
                payment: {
                    status: this.$page.props.invoice_data.status,
                    date: this.$page.props.invoice_data.payment_date,
                    transaction_id: this.$page.props.invoice_data.payment_transaction_id,
                    proof: {
                        url: this.$page.props.invoice_data.payment_proof ? this.$page.props.invoice_data.payment_proof : '',
                        file: '',
                        delete_previous: false
                    },
                    remark: this.$page.props.invoice_data.remark,
                }
            },
        }
    },
    watch: {
        'form.invoice_items': {
            handler(newVal) {
                newVal.forEach(item => {
                    !item.programme_fee             ? item.programme_fee = 0 : ''
                    !item.programme_fee_discount    ? item.programme_fee_discount = 0 : ''
                    !item.registration_fee          ? item.registration_fee = 0 : ''
                    !item.registration_fee_discount ? item.registration_fee_discount = 0 : ''
                    !item.material_fee              ? item.material_fee = 0 : ''
                    !item.material_fee_discount     ? item.material_fee_discount = 0 : ''
                });
            },
            deep: true,
        }
    },
    methods: {
        submit() {
            this.form.invoice_amount = this.totalFee(this.form.invoice_items)
            this.$inertia.post(route('fee.invoices.update'), this.form, { preserveState: true})
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
        totalFee(invoice_items) {
            let total = 0;
            for (const item of invoice_items) {
                // Parse fees and discounts as numbers
                const programmeFee = parseFloat(item.programme_fee);
                const programmeDiscount = parseFloat(item.programme_fee_discount);
                const registrationFee = parseFloat(item.registration_fee);
                const registrationDiscount = parseFloat(item.registration_fee_discount);
                const materialFee = parseFloat(item.material_fee);
                const materialDiscount = parseFloat(item.material_fee_discount);

                // Add programme fee and subtract programme discount
                total += programmeFee - programmeDiscount;

                // Check if material fee should be included
                if (item.include_registration_fee) {
                    // Add material fee and subtract material discount
                    total += registrationFee - registrationDiscount;
                }
                if (item.include_material_fee) {
                    // Add material fee and subtract material discount
                    total += materialFee - materialDiscount;
                }
                var total_promo =   0
                if(item.promos && Array.isArray(item.promos)){
                    for (const promo of item.promos) {
                        if(promo.type_id === 1){
                            total_promo += (programmeFee * promo.value / 100)
                        }
                        if(promo.type_id === 2){
                            total_promo += promo.value
                        }
                    }
                    total = total - total_promo
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
    },
}
</script>