<template>
    <Authenticated>
        <div class="relative overflow-x-auto mt-4">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Invoice Number
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Invoice Title
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Payable
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Date Issued
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            00102
                        </th>
                        <td class="px-6 py-4">
                            Monthly Fees
                        </td>
                        <td class="px-6 py-4">
                            34000.00
                        </td>
                        <td class="px-6 py-4">
                            Unpaid
                            <br>
                            <Link :href="route('parent.invoices.index')" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Pay Now</Link>
                        </td>
                        <td class="px-6 py-4">
                            01/06/2023
                        </td>
                    </tr>
                    <tr class="bg-white border-b">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            00102
                        </th>
                        <td class="px-6 py-4">
                            Monthly Fees
                        </td>
                        <td class="px-6 py-4">
                            34000.00
                        </td>
                        <td class="px-6 py-4">
                            Unpaid
                            <br>
                            <Link :href="route('parent.invoices.index')" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Pay Now</Link>
                        </td>
                        <td class="px-6 py-4">
                            01/06/2023
                        </td>
                    </tr>
                    <tr class="bg-white">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            00102
                        </th>
                        <td class="px-6 py-4">
                            Monthly Fees
                        </td>
                        <td class="px-6 py-4">
                            34000.00
                        </td>
                        <td class="px-6 py-4">
                            Unpaid
                            <br>
                            <Link :href="route('parent.invoices.index')" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Pay Now</Link>
                        </td>
                        <td class="px-6 py-4">
                            01/06/2023
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </Authenticated>
</template>

<script setup>
import Authenticated from '@/Layouts/Parent/Authenticated.vue';
import { Link } from '@inertiajs/inertia-vue3';
</script>
