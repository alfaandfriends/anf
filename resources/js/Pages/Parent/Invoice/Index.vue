<template>
    <Head title="Invoices" />
    <Authenticated>
        <div class="overflow-x-auto no-scrollbar">
            <div class="bg-white shadow rounded-lg border">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-gray-700 capitalize bg-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Invoice Number
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Date Issued
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Due Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Amount
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b" v-if="!$page.props.invoices.length">
                            <td class="text-center py-4" colspan="10">
                                No record found.
                            </td>
                        </tr>
                        <tr class="bg-white border-b hover:bg-gray-50" v-else v-for="invoice, invoice_index in $page.props.invoices">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ invoice.invoice_number }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ moment(invoice.date_issued).format('DD MMM Y') }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ moment(invoice.due_date).format('DD MMM Y') }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap text-center">
                                {{ invoice.amount }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-xs font-medium px-2 py-1 rounded" :class="[invoice.status_bg_color, invoice.status_text_color]">{{ invoice.status }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a v-if="invoice.status_id == 1" :href="invoice.payment_url" class="cursor-pointer font-medium px-3 py-1 text-indigo-600 hover:bg-indigo-200 hover:rounded whitespace-nowrap">Pay Now</a>
                                <a v-else class="cursor-pointer font-medium px-3 py-1 text-blue-600 bg-blue-100 hover:bg-blue-200 rounded whitespace-nowrap" @click="generating[invoice_index] ? '' : viewInvoice(invoice.id, invoice_index)">{{ generating[invoice_index] ? 'Generating...' : 'View / Download' }}</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <Modal :showModal="open_modal" modalType="md" @hideModal="open_modal = false">
            <template v-slot:header>
                <h3 class="text-gray-900 text-xl font-semibold">                
                    Invoice
                </h3>                
            </template>
            <template v-slot:content>
                <MonthlyFee :invoice_data="invoice_data"></MonthlyFee>
            </template>
            <template v-slot:footer>
                <div class="flex justify-between space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                    <BreezeButton buttonType="blue" class="px-4 py-2 space-x-2" @click="print">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
                        </svg>
                        <span>Print</span>
                    </BreezeButton>
                    <BreezeButton buttonType="gray" @click="open_modal = false">Close</BreezeButton>
                </div>
            </template>
        </Modal>
    </Authenticated>
</template>

<script setup>
import Authenticated from '@/Layouts/Parent/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import BreezeButton from '@/Components/Button.vue';
</script>

<script>
import Modal from '@/Components/Modal.vue'
import axios from 'axios'
import moment from 'moment';

export default {
    components: {
        Head, Link, Modal
    },
    data(){
        return{
            open_modal: false,
            generating: [],
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
    methods: {
        viewInvoice(invoice_id, index){
            if(this.generating[index]){
                return
            }
            this.generating[index] = true
            axios.get(route('fee.invoices.generate'), {
                responseType: 'blob', // Set the response type to 'blob' to handle binary data
                params: {
                    'invoice_id': invoice_id
                }
            })
            .then(response => {
                // Create a Blob object from the response data
                const blob = new Blob([response.data], { type: 'application/pdf' });

                // Create a URL for the Blob object
                const pdfUrl = URL.createObjectURL(blob);

                // Open the PDF in a new tab
                window.open(pdfUrl, '_blank');
                this.generating[index] = false
            })
            .catch(error => {
                console.error('Error fetching PDF:', error);
                this.generating[index] = false
            });
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
        pay(billing_id){
            window.location.href = import.meta.env.VITE_BILLPLZ_ENDPOINT+billing_id
        },
    },
    mounted(){
        this.$page.props.invoices.forEach(element => {
            this.generating.push(false)
        });
    }
}
</script>
