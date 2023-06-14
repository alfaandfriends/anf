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
    products: {
        type: Object,
    },
});

const isRestore = ref(false);
const toBeRestore = ref();

const search = ref();
const filter = ref();

const restoreItem = (id) => {
    isRestore.value = true;
    toBeRestore.value = id;
}

watch(
    () => search.value, (newValue) => {
        Inertia.visit(route('products.trash', {search: newValue}), { method: 'get' });
    },
    () => filter.value, (newValue) => {
        Inertia.visit(route('products.trash', newValue), { method: 'get' });
    }
);
</script>

<template>
    <Head title="Product" />

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
                        </div>
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-300">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/14">#</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/14">Product Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Price</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Stock</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Sales</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-if="!products.data.length">
                                        <td class="text-center" colspan="10">
                                            <div class="p-3">
                                                No Record Found!
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-200" v-for="(product, index) in products.data" :key="index">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-700">{{ index + 1 }}</div>
                                        </td>
                                        <td class="flex items-center px-6 py-4 whitespace-nowrap">
                                            <img class="w-24 h-24 mr-4" :src="product.image" alt="">
                                            <div class="text-sm font-medium text-gray-900">{{ product.name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ product.price }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ product.stock }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ product.sales }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center">
                                                <div class="flex">
                                                    <BreezeButton @click="restoreItem(product.variation_item_id)" buttonType="warning" title="Delete Product">
                                                        Restore
                                                    </BreezeButton>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <Pagination :page_data="products"></Pagination>
                        </div>
                    </div>
                </div>
            </div>
            <ConfirmationModal
                :show="isRestore"
                @close="isRestore = false"
                confirmationAlert="warning"
                confirmationTitle="Restore Product"
                confirmationText="Are you sure want to restore this product?"
                confirmationButton="Restore"
                confirmationMethod="patch"
                confirmationRoute="product-variation-item.restore"
                :confirmationData="toBeRestore"
            >
            </ConfirmationModal>
        </div>
    </BreezeAuthenticatedLayout>
</template>
