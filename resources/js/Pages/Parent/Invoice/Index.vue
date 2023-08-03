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
                        <tr class="bg-white border-b hover:bg-gray-50" v-if="!$page.props.invoices.length">
                            <td class="text-center" colspan="10">
                                No invoice found.
                            </td>
                        </tr>
                        <tr class="bg-white border-b hover:bg-gray-50" v-else v-for="invoice in $page.props.invoices">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ invoice.invoice_number }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ invoice.date_issued }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ invoice.due_date }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap text-center">
                                {{ invoice.amount }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-xs font-medium px-2 py-1 rounded" :class="[invoice.status_bg_color, invoice.status_text_color]">{{ invoice.status }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button :href="route('parent.invoices.index')" class="font-medium px-3 py-1 text-blue-600 hover:bg-blue-200 hover:rounded whitespace-nowrap">Pay Now</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </Authenticated>
</template>

<script setup>
import Authenticated from '@/Layouts/Parent/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
</script>
