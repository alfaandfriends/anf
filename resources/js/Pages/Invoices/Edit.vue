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
.invoices-input-date-picker-error{
    border: 1px solid rgba(252, 165, 165); /* Default border color and thickness */
    border-radius: 0.35rem;
}
:hover.invoices-input-date-picker-error  {
    border: 1px solid rgba(252, 165, 165); /* Highlighted border color and thickness */
}
:focus.invoices-input-date-picker-error  {
    border: 1px solid rgba(252, 165, 165); /* Highlighted border color and thickness */
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
                        <div class="grid grid-cols-1 gap-4">
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
                                    <div class="mb-4">
                                        <label for="parent_email" class="block text-sm font-bold text-gray-700"> Parent Email </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input disabled type="text" name="parent_email" id="parent_email" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 bg-gray-100" v-model="$page.props.invoice_data.user_email" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1">
                                    <div class="mb-4">
                                        <label for="payment_link_recipt" class="block text-sm font-bold text-gray-700"> Payment Link / Receipt (Billplz)</label>
                                        <div class="mt-1">
                                            <BreezeButton @click="openPaymentLink()">View</BreezeButton>
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
                                        <span class="text-2xl font-bold text-indigo-500">{{ $page.props.invoice_data.amount }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md h-full">
                                <div class="mb-5">
                                    <div class="flex justify-between items-end mb-2">
                                        <h1 class="font-bold text-indigo-800">Collect Payment</h1>
                                        <BreezeButton @click="showModal" class="normal-case px-4 py-2">Add proof of payment</BreezeButton>
                                    </div>
                                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead>
                                            <tr class="bg-gray-600">
                                                <th class="text-center text-white text-sm py-2 px-4" width="1%">#</th>
                                                <th class="text-left text-white text-sm py-2 px-4" width="10%">Date</th>
                                                <th class="text-left text-white text-sm py-2 px-4" width="15%">Transaction ID</th>
                                                <th class="text-left text-white text-sm py-2 px-4" width="20%">File Name</th>
                                                <th class="text-left text-white text-sm py-2 px-4" width="25%">Remark</th>
                                                <th class="text-center text-white text-sm py-2 px-4" width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-if="form.payment.proofs.length" v-for="proof, proof_index in form.payment.proofs">
                                                <td class="border text-sm py-2 px-4 text-center">{{ proof_index+1 }}</td>
                                                <td class="border text-sm py-2 px-4 whitespace-nowrap">{{ proof.date }}</td>
                                                <td class="border text-sm py-2 px-4 whitespace-nowrap">
                                                    <kbd class="min-h-[18px] inline-flex justify-center items-center px-1 bg-gray-200 border border-transparent font-mono text-gray-800 rounded-md">
                                                        {{ proof.transaction_id }}
                                                    </kbd>
                                                </td>
                                                <td class="border text-sm py-2 px-4 whitespace-nowrap">
                                                    <a :href="proof.file ? proof.url : '/storage/proof_of_payment/' + proof.url" download class="min-h-[30px] inline-flex justify-center items-center py-1 px-1.5 bg-white border border-gray-200 font-mono text-sm text-gray-800 rounded-md shadow-[0px_2px_0px_0px_rgba(0,0,0,0.08)] dark:bg-neutral-900">
                                                        {{ proof.file ? proof.file.name : proof.url }}
                                                    </a>
                                                </td>
                                                <td class="border text-sm py-2 px-4 whitespace-nowrap">{{ proof.remark }}</td>
                                                <td class="border text-sm py-2 px-4 text-center">
                                                    <BreezeButton buttonType="danger" @click="deleteProof(proof_index, proof.id)">Delete</BreezeButton>
                                                </td>
                                            </tr>
                                            <tr v-else>
                                                <td class="border text-sm text-center py-2 px-4 text-gray-600" colspan="10">No Records</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-md">
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
        
        <Modal :showModal="show_add_attachment" :modalType="'sm'" @hideModal="show_add_attachment = false">
            <template v-slot:header>
                <div class="flex items-center justify-between py-3 px-4 border-b rounded-t font-semibold">            
                    <h3 class="text-gray-900 font-semibold">                
                        Add Proof of Payment
                    </h3>    
                    <button type="button" @click="show_add_attachment = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="default-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>                 
            </template>
            <template v-slot:content>
                <div class="p-6 overflow-y-auto no-scrollbar">
                    <div class="grid grid-rows-1">
                        
                        <div class="mb-4">
                            <label for="date" class="block text-sm font-bold text-gray-700"> Date </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                
                                <Datepicker 
                                    :class="'focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm'" 
                                    :input-class-name="errors.date ? 'invoices-input-date-picker-error focus:ring-0' : 'invoices-input-date-picker focus:ring-0'"
                                    v-model="attachment.date" 
                                    :enableTimePicker="false"
                                    :auto-apply="true" 
                                    :format="'dd/MM/yyyy'"
                                />
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="transaction_id" class="block text-sm font-bold text-gray-700"> Transaction ID </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" name="transaction_id" id="transaction_id" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="errors.transaction_id ? 'border-red-300' : 'border-gray-300'" v-model="attachment.transaction_id" autocomplete="off">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="student_name" class="block text-sm font-bold text-gray-700"> Proof of Payment ( <span class="text-xs text-indigo-500">PDF, JPEG</span> )</label>
                            <div class="mt-1 items-center w-full">
                                <div class=""> 
                                    <label class="block focus:ring-0 focus:border-gray-300">
                                        <span class="sr-only">Browse File</span>
                                        <input type="file" ref="file_input" class="focus:ring-0 border rounded-md block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-gray-700 focus:outline-none" :class="errors.proof_of_payment ? 'border-red-300' : 'border-gray-300'" @change="uploadFile"/>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="remark" class="block text-sm font-bold text-gray-700"> Remark </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <textarea type="text" name="remark" id="remark" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" v-model="attachment.remark" autocomplete="off"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot:footer>
                <div class="flex justify-end space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                    <BreezeButton buttonType="gray" @click="show_add_attachment = false">Cancel</BreezeButton>
                    <BreezeButton @click="addAttachment">Add</BreezeButton>
                </div>
            </template>
        </Modal>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import moment from 'moment';
import Datepicker from '@vuepic/vue-datepicker';
import Modal from '@/Components/Modal.vue'

export default {
    components: {
        Head, Link, Modal
    },
    data(){
        return{
            show_add_attachment: false,
            date_issued: moment(this.$page.props.invoice_data.date_issued).format('DD MMM Y'),
            due_date: moment(this.$page.props.invoice_data.due_date).format('DD MMM Y'),
            form: {
                params: this.$page.props.params,
                invoice_id: this.$page.props.invoice_data.id,
                invoice_items: JSON.parse(this.$page.props.invoice_data.invoice_items),
                invoice_amount: this.$page.props.invoice_data.amount,
                payment: {
                    status: this.$page.props.invoice_data.status,
                    proofs: [],
                    proofs_to_delete: [],
                }
            },
            attachment: {
                date: '',
                transaction_id: '',
                url: '',
                file: '',
                remark: '',
            },
            errors: {
                date: false,
                transaction_id: false,
                proof_of_payment: false
            }
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
        clearErrors(){
            this.errors.date = false
            this.errors.transaction_id = false
            this.errors.proof_of_payment = false
        },
        clearAttachmentFields(){
            this.attachment.date = ''
            this.attachment.transaction_id = ''
            this.attachment.url = ''
            this.attachment.file = ''
            this.attachment.remark = ''
        },
        showModal(){
            this.clearErrors()
            this.clearAttachmentFields()
            this.show_add_attachment = true
        },
        deleteProof(proof_index, proof_id){
            this.form.payment.proofs.splice(proof_index, 1)
            if(proof_id){
                this.form.payment.proofs_to_delete.push(proof_id)
            }
        },
        uploadFile($event){
            const file = $event.target.files[0];
                  
            if(file.type == 'application/pdf' || file.name.toLowerCase().endsWith('.pdf') || file.type == 'image/jpeg' || file.name.toLowerCase().endsWith('.png')){
                this.attachment.url = URL.createObjectURL(file)
                this.attachment.file = file
            }
            else{
                alert('Only Image / PDF File allowed!')
                this.$refs.file_input.value = ''
            }
        },
        addAttachment(){
            if(!this.attachment.date || !this.attachment.transaction_id || !this.attachment.file){
                this.errors.date = this.attachment.date ? false : true
                this.errors.transaction_id = this.attachment.transaction_id ? false : true
                this.errors.proof_of_payment = this.attachment.file ? false : true
                return
            }
            this.form.payment.proofs.push({
                'date': moment(this.attachment.date).format('DD-MM-YYYY'),
                'transaction_id': this.attachment.transaction_id,
                'url': this.attachment.url,
                'file': this.attachment.file,
                'remark': this.attachment.remark,
            })
            this.show_add_attachment = false
        },
        openPaymentLink(){ 
            window.open(this.$page.props.invoice_data.payment_url, '_blank');
        }
    },
    mounted(){
        this.$page.props.invoice_attachments.forEach((file) => {
            this.form.payment.proofs.push({
                'id': file.id,
                'date': moment(file.date).format('DD-MM-YYYY'),
                'transaction_id': file.transaction_id,
                'url': file.attachment,
                'file': '',
                'remark': file.remark,
            })
        })
    }
}
</script>