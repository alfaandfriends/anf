<template>
    <Head title="Home" />
    <div class="fixed w-full flex justify-center top-[4rem] md:top-[10rem] font-extrabold bg-white border border-gray-300 py-3 z-20">
        <span>{{ $page.props.session_data.current_active_programme.name }}</span>
    </div>
    <Authenticated>
        <div class="max-w-xl mx-auto border shadow bg-white rounded-lg px-4 mt-14">
            <simplebar data-simplebar-auto-hide="true">
                <div class="flex justify-evenly sm:justify-center space-x-8 md:space-x-10 pt-3 pb-4 font-medium">
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap" :class="route().current('parent.stories') ? 'font-extrabold' : ''" @click="$inertia.get(route('parent.stories', $page.props.session_data.current_active_programme.encrypted_id))">
                        <img src="/images/parents/stories.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Stories</span>
                    </div>
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap" :class="route().current('parent.progress_reports') ? 'font-extrabold' : ''" @click="$inertia.get(route('parent.progress_reports'))">
                        <img src="/images/parents/progress_report.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Progress Reports</span>
                    </div>
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap" :class="route().current('parent.invoices') ? 'font-extrabold' : ''" @click="$inertia.get(route('parent.invoices'))">
                        <img src="/images/parents/fee_invoice.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Invoices</span>
                    </div>
                    <!-- <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap" v-if="$page.props.programme_info.id == 3 || $page.props.programme_info.id == 5"> -->
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap" :class="route().current('parent.art_gallery') ? 'font-extrabold' : ''" @click="$inertia.get(route('parent.art_gallery'))">
                        <img src="/images/parents/art_gallery.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Art Gallery</span>
                    </div>
                    <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap" :class="route().current('parent.art_book') ? 'font-extrabold' : ''" @click="$inertia.get(route('parent.art_book'))">
                        <img src="/images/parents/art_book.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Art Book</span>
                    </div>
                </div>
            </simplebar>
        </div>
        <div class="max-w-xl mx-auto mt-10">
            <div class="flex items-center space-y-3" v-if="$page.props.invoices.length">
                <h2 class="text-lg md:text-xl mx-1 font-extrabold">Invoices</h2>
            </div>
            <div class="flex justify-center mx-1 mt-10" v-if="!$page.props.invoices.length">
                <span class="text-slate-500">No Invoices Found</span>
            </div>
            <div class="mt-3">
                <div class="bg-white shadow rounded-lg border">
                    <simplebar data-simplebar-auto-hide="true" class=" max-h-screen">
                        <ul class="divide-y divide-slate-200 dark:divide-zink-500 px-6 py-4">
                            <li class="flex items-center gap-3 py-2 first:pt-0 last:pb-0" v-for="invoice, invoice_index in $page.props.invoices">
                                <div class="grow">
                                    <h6 class="font-semibold text-sm">Invoice No: {{ invoice.invoice_number }}</h6>
                                    <p class="text-slate-500 text-sm font-medium">Date Issued: {{ moment(invoice.due_date).format('DD MMM Y') }}</p>
                                    <p class="text-slate-500 text-sm font-medium">Due Date: {{ moment(invoice.due_date).format('DD MMM Y') }}</p>
                                    <p class="text-slate-500 text-sm font-medium">Amount: {{ invoice.amount }}</p>
                                    <p class="text-sm font-medium">Status: <span :class="[invoice.status_text_color]">{{ invoice.status }}</span></p>
                                </div>
                                <div class="shrink-0">
                                    <a v-if="invoice.status_id == 1" :href="invoice.payment_url" class="text-sm cursor-pointer font-medium px-3 py-1 text-indigo-600 rounded bg-indigo-100 hover:bg-indigo-200 hover:rounded whitespace-nowrap">Pay Now</a>
                                    <a v-if="invoice.status_id == 2" class="text-sm cursor-pointer font-medium px-3 py-1 text-blue-600 bg-blue-100 hover:bg-blue-200 rounded whitespace-nowrap" @click="generating[invoice_index] ? '' : viewInvoice(invoice.id, invoice_index)">{{ generating[invoice_index] ? 'Generating...' : 'View' }}</a>
                                </div>
                            </li>
                        </ul>
                    </simplebar>
                </div>
            </div>
        </div>
    </Authenticated>
</template>

<script setup>
import Authenticated from '@/Layouts/Parent/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import simplebar from 'simplebar-vue';
import 'simplebar-vue/dist/simplebar.min.css';
import axios from 'axios'
import moment from 'moment';
</script>

<script>
export default {
    components: {
        simplebar
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