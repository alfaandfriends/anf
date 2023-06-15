<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
import { Head } from '@inertiajs/inertia-vue3';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import Pagination from '@/Components/Pagination.vue';
import { SearchIcon, TrashIcon, PencilIcon } from '@heroicons/vue/solid';
import { ref, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia'

const props = defineProps({
    orders: {
        type: Object,
    },
});

const isDestroy = ref(false);
const toBeDelete = ref();

const search = ref();
const filter = ref();

const destroyItem = (id) => {
    isDestroy.value = true;
    toBeDelete.value = id;
}

watch(
    () => search.value, (newValue) => {
        Inertia.visit(route('orders', {search: newValue}), { method: 'get' });
    },
    () => filter.value, (newValue) => {
        Inertia.visit(route('orders', newValue), { method: 'get' });
    }
);
</script>

<template>
    <Head title="Order" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-middle inline-block min-w-full px-2">
                        <div class="flex justify-between mb-4">
                            <div class="flex space-x-2">
                                <div class="flex relative text-gray-400 focus-within:text-gray-600">
                                    <SearchIcon class="text-gray-600 h-4 w-4 fill-current pointer-events-none absolute top-1/4 left-3" :style="'top:30%'"></SearchIcon>
                                    <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg focus:ring-0 focus:border-gray-300 appearance-none  block pl-10" type="text" v-model="search" placeholder="Search">
                                </div>
                            </div>
                            <BreezeButton :route="route('orders.create')">Add New Order</BreezeButton>
                        </div>
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-300">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/14">#</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/14">Invoice Number</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Email</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Phone</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-6/14">Shipment Provider / Tracking Number</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/14">Status</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/14">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-if="!orders.data.length">
                                        <td class="text-center" colspan="10">
                                            <div class="p-3">
                                                No Record Found!
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-200" v-for="(order, index) in orders.data" :key="index">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-700">{{ index + 1 }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ order.invoice_number }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ order.email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ order.phone }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ order.provider }}/{{ order.tracking }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ order.status }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center">
                                                <div class="flex pr-1">
                                                    <BreezeButton :route="route('orders.edit', order.id)" buttonType="warning" title="Edit Category">
                                                        Edit
                                                    </BreezeButton>
                                                </div>
                                                <div class="flex">
                                                    <BreezeButton @click="destroyItem(order.id)" buttonType="danger" title="Delete Product">
                                                        Delete
                                                    </BreezeButton>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <Pagination :page_data="orders"></Pagination>
                        </div>
                    </div>
                </div>
            </div>
            <ConfirmationModal
                :show="isDestroy"
                @close="isDestroy = false"
                confirmationAlert="danger"
                confirmationTitle="Delete Order"
                confirmationText="Are you sure want to delete this order?"
                confirmationButton="Delete"
                confirmationMethod="delete"
                confirmationRoute="orders.destroy"
                :confirmationData="toBeDelete"
            >
            </ConfirmationModal>
        </div>
    </BreezeAuthenticatedLayout>
</template>
