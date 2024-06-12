<template>
    <Head title="Fee Invoices" />
    <Authenticated>
        <div class="flex justify-center">
            <div class="flex-1 max-w-4xl overflow-auto justify-center">
                <div class="flex justify-center py-10">
                    <span class="text-lg text-gray-500">Coming Soon...</span>
                </div>
            </div>
        </div>
    </Authenticated>
</template>

<script setup>
import Authenticated from '@/Layouts/Parent/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import BreezeButton from '@/Components/Button.vue';
</script>

<script>
import axios from 'axios'
import moment from 'moment';

export default {
    components: {
        Head, Link
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
