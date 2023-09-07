<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <div class="overflow-y-auto no-scrollbar modal-main" id="invoice" ref="invoice">
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
                        <span class="font-bold">{{ invoice_data.parent_name }}</span><br>
                        <div class="w-64">
                            <span class="">{{ invoice_data.parent_address }}</span>
                        </div>
                    </span>
                    <div class="space-y-2">
                        <div class="grid grid-cols-1 gap-2">
                            <dl class="grid grid-cols-5">
                                <dt class="col-span-3 font-semibold text-gray-800">Invoice Number:</dt>
                                <dd class="col-span-2 text-gray-500">{{ invoice_data.invoice_number }}</dd>
                            </dl>
                            <dl class="grid grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800">Invoice Date:</dt>
                                <dd class="col-span-2 text-gray-500">{{ moment(invoice_data.date_issued).format('DD MMM Y') }}</dd>
                            </dl>
                            <dl class="grid grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800">Due Date:</dt>
                                <dd class="col-span-2 text-gray-500">{{ moment(invoice_data.due_date).format('DD MMM Y') }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="mt-8 grid sm:grid-cols-2 gap-3">
                    <h4 class="text-md font-semibold text-gray-800 underline">Student: {{ invoice_data.student_name }}</h4>
                </div>
                <!-- <div class="mt-6 sm:hidden md:hidden lg:hidden">
                    <div class="border border-gray-200 p-4 rounded-lg space-y-4">
                        <div class="hidden sm:grid sm:grid-cols-6">
                            <div class="sm:col-span-4 text-xs font-medium text-gray-500 uppercase">Item</div>
                            <div class="text-center sm:col-span-1  text-xs font-medium text-gray-500 uppercase">Discount</div>
                            <div class="text-right text-xs font-medium text-gray-500 uppercase">Amount</div>
                        </div>
                        <div class="hidden sm:block border-b border-gray-200"></div>
                        <div class="grid grid-cols-3 sm:grid-cols-6 gap-2">
                            <div class="col-span-full sm:col-span-4">
                                <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase">Programme</h5>
                                <p class="font-bold text-sm text-gray-800">ALFA and Friends Math ( Level 2 ) </p>
                                <div class="pl-5">
                                    <ul class="list-disc">
                                        <li>
                                            <p class="font-medium text-xs text-gray-800">Plus Fee (2 per week)</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div>
                                <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase">Discount</h5>
                                <p class="sm:text-center text-gray-800">0</p>
                            </div>
                            <div>
                                <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase">Amount</h5>
                                <p class="sm:text-right text-gray-800">100.00</p>
                            </div>
                        </div>
                        <div class="sm:hidden border-b border-gray-200"></div>
                        <div class="grid grid-cols-3 sm:grid-cols-6 gap-2">
                            <div class="col-span-full sm:col-span-4">
                                <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase">Programme</h5>
                                <p class="font-bold text-sm text-gray-800">ALFA and Friends Coding & Robotic ( Level 1 )</p>
                                <div class="pl-5">
                                    <ul class="list-disc">
                                        <li>
                                            <p class="font-medium text-xs text-gray-800">Normal Fee</p>
                                        </li>
                                        <li>
                                            <p class="font-medium text-xs text-gray-800">Material Fee</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div>
                                <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase">Discount</h5>
                                <p class="sm:text-center text-gray-800">0</p>
                            </div>
                            <div>
                                <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase">Amount</h5>
                                <p class="sm:text-right text-gray-800">200.00</p>
                            </div>
                        </div>
                        <div class="sm:hidden border-b border-gray-200"></div>
                        <div class="grid grid-cols-3 sm:grid-cols-6 gap-2">
                            <div class="col-span-full sm:col-span-4">
                                <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase">Programme</h5>
                                <p class="font-bold text-sm text-gray-800">ALFA and Friends Digital Arts ( Level 1 )</p>
                                <div class="pl-5">
                                    <ul class="list-disc">
                                        <li class="">
                                            <p class="font-medium text-xs text-gray-800">Normal Fee</p>
                                        </li>
                                        <li>
                                            <p class="font-medium text-xs text-gray-800">Material Fee</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div>
                                <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase">Discount</h5>
                                <p class="sm:text-center text-gray-800">0</p>
                            </div>
                            <div>
                                <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase">Amount</h5>
                                <p class="sm:text-right text-gray-800">200.00</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-8 flex sm:justify-end sm:hidden md:hidden lg:hidden">
                    <div class="w-full max-w-2xl sm:text-right space-y-2">
                        <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2 px-4">
                            <dl class="grid sm:grid-cols-6 gap-x-3">
                                <dt class="col-span-5 font-semibold text-gray-800">Total:</dt>
                                <dd class="text-gray-800">300.00</dd>
                            </dl>
                        </div>
                    </div>
                </div> -->
    
                <!-- Desktop View or Print View -->
                <div class="mt-6">
                    <table class="w-full">
                        <thead class="bg-gray-800">
                            <tr>
                                <th class="text-left py-2 px-4 text-xs font-medium text-gray-100 uppercase w-4/6">Item</th>
                                <th class="py-2 px-4 text-xs font-medium text-gray-100 uppercase w-1/6">Discount</th>
                                <th class="py-2 px-4 text-xs font-medium text-gray-100 uppercase w-1/6">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border" v-for="data in invoice_data.invoice_items">
                                <td class="py-2 px-4">
                                    <p class="font-bold text-md text-gray-800 mb-1">{{ data.programme_name }} ( Level {{ data.programme_level }} ) - June 2023</p>
                                    <p class="font-normal text-md text-gray-800" v-if="data.include_material_fee">- Material Fee</p>
                                    <p class="font-normal text-md text-gray-800">- {{ data.programme_type }}</p>
                                </td>
                                <td class="text-center align-bottom py-2 px-4">
                                    <p class="font-normal text-md text-gray-800" v-if="data.include_material_fee">{{ data.material_fee_discount }}</p>
                                    <p class="font-normal text-md text-gray-800">{{ data.programme_fee_discount }}</p>
                                </td>
                                <td class="text-center align-bottom py-2 px-4">
                                    <p class="font-normal text-md text-gray-800" v-if="data.include_material_fee">{{ data.material_fee }}</p>
                                    <p class="font-normal text-md text-gray-800">{{ data.programme_fee }}</p>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="pt-5 py-2 px-4"></td>
                                <td class="pt-5 py-2 px-4 text-center">
                                    <p class="font-medium text-lg text-gray-800">Total :</p>
                                </td>
                                <td class="pt-5 py-2 px-4 text-center">
                                    <p class="font-medium text-lg text-gray-800">{{ invoice_data.total_amount }}</p>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="pt-8">
                <h4 class="text-md text-center font-semibold text-xl text-gray-800">Thank you!</h4>
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
    updated(){
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