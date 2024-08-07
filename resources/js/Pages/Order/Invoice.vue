<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <div class="overflow-y-auto scrollbar modal-main" id="invoice" ref="invoice">
        <div class="flex flex-col justify-between divide-y p-8 min-h-screen">
            <div class="flex flex-col flex-grow">
                <div class="flex flex-row justify-between">
                    <div class="flex self-center ">
                        <img src="/images/invoice_logo_alt.jpg" class="w-48 h-28 block select-none" alt="">
                    </div>
                    <div class="text-right">
                        <span class="mt-4 not-italic text-gray-800 text-md">
                            <span class="font-bold text-lg">ALFA and Friends Sdn Bhd</span><br>
                            36, Jalan BP 7/8, Bandar Bukit Puchong,<br>
                            47120 Puchong, Selangor Darul Ehsan,<br>
                            Malaysia<br>
                        </span>
                    </div>
                </div>
                <div class="flex flex-row justify-between items-start">
                    <h3 class="mt-8 text-md font-semibold text-gray-800">To:</h3>
                </div>
                <div class="flex flex-row justify-between items-start space-y-0">
                    <span class="not-italic text-gray-700 text-md space-y-2">
                        <span class="font-bold">{{ invoice_data.parent_full_name }}</span><br>
                        <div class="w-64">
                            <span class="">{{ invoice_data.parent_address }}</span>
                        </div>
                    </span>
                    <div class="space-y-2">
                        <div class="grid grid-cols-1 gap-2">
                            <dl class="grid grid-cols-5" v-if="invoice_data.invoice_number">
                                <dt class="col-span-3 font-semibold text-gray-800">Invoice Number:</dt>
                                <dd class="col-span-2 text-gray-500">{{ invoice_data.invoice_number }}</dd>
                            </dl>
                            <dl class="grid grid-cols-5 gap-x-3" v-if="invoice_data.invoice_number">
                                <dt class="col-span-3 font-semibold text-gray-800">Invoice Date:</dt>
                                <dd class="col-span-2 text-gray-500">{{ moment(invoice_data.date_issued).format('DD MMM Y') }}</dd>
                            </dl>
                            <dl class="grid grid-cols-5">
                                <dt class="col-span-3 font-semibold text-gray-800">Order Number:</dt>
                                <dd class="col-span-2 text-gray-500">{{ invoice_data.order_number }}</dd>
                            </dl>
                            <dl class="grid grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800">Order Date:</dt>
                                <dd class="col-span-2 text-gray-500">{{ moment(invoice_data.created_at).format('DD MMM Y') }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="mt-8 grid sm:grid-cols-2 gap-3">
                    <h4 class="text-md font-semibold text-gray-800 underline">Student: {{ invoice_data.student_name }}</h4>
                </div>
                <!-- Desktop View or Print View -->
                <div class="mt-6">
                    <table class="w-full">
                        <thead class="bg-gray-800">
                            <tr>
                                <th class="text-left py-2 px-4 text-xs font-medium text-gray-100 uppercase w-4/6">Item</th>
                                <th class="py-2 px-4 text-xs font-medium text-gray-100 uppercase w-1/6">Quantity</th>
                                <th class="py-2 px-4 text-xs font-medium text-gray-100 uppercase w-1/6">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border" v-for="data in JSON.parse(invoice_data.products)">
                                <td class="py-2 px-4">
                                    <p class="font-semibold text-md text-gray-800 mb-1">{{ data.product.name }} {{ data.product_variation.option_name ? '- ' + data.product_variation.option_name : '' }} {{ data.product_sub_variation.option_name ? '(' + data.product_sub_variation.option_name + ')': '' }}</p>
                                </td>
                                <td class="text-center align-bottom py-2 px-4">
                                    <p class="font-normal text-md text-gray-800">{{ data.quantity }} </p>
                                </td>
                                <td class="text-center align-bottom py-2 px-4">
                                    <p class="font-normal text-md text-gray-800">0.00</p>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="pt-5 px-4"></td>
                                <td class="pt-5 px-4 text-right" colspan="2">
                                    <div class="flex space-x-8 items-center justify-end pr-9">
                                        <p class="font-bold text-md text-gray-800">Subtotal</p>
                                        <p class="font-semibold text-md text-gray-800">0.00</p>
                                    </div>
                                    <div class="mt-3 border border-gray-700"></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4"></td>
                                <td class="py-2 px-4 text-right" colspan="2">
                                    <div class="flex space-x-8 items-center justify-end pr-9">
                                        <p class="font-bold text-lg text-gray-800">Total</p>
                                        <p class="font-bold text-md text-gray-800">0.00</p>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="pt-8 space-y-4">
                <h4 class="text-xs text-center font-semibold text-gray-800">1. All of our goods are exempt from being returned after you have purchased the item</h4>
                <h4 class="text-xs text-center font-semibold text-gray-800">2. Defective products may only be exchanged within 10 working days of receiving the products</h4>
                <h4 class="text-xs text-center font-semibold text-gray-800">3. Order(s) will be received in 10 working days after every transaction is completed</h4>
            </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment';

export default {
    props: {
        invoice_data: Object
    },
    created(){
        this.scrollToTop()
    },
    methods:{
        scrollToTop() {
            const modalContent = this.$refs.invoice
            if (modalContent) {
                modalContent.scrollTop = 0;
            }
        },
    }
}
</script>