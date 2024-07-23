<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Product" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="flex justify-end mb-3" v-if="$page.props.can.create_products">
                <BreezeButton :url="route('products.create')">Add New Product</BreezeButton>
            </div>
            <hr class="my-3 border border-dashed border-gray-400">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-2 mb-3">
                <div class="relative w-full">
                    <svg class="absolute top-2.5 left-3 h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                        <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <input type="text" class="h-10 border-2 border-gray-300 w-full appearance-none focus:ring-0 focus:border-gray-300 py-1 pl-10 pr-4 text-gray-700 bg-white rounded-md" v-debounce:800ms="search" v-model="params.search">
                </div>
            </div>
            <div class="overflow-x-auto">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-300">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/14">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/14">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/14">Description</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-if="!$page.props.products.data.length">
                                <td class="text-center" colspan="10">
                                    <div class="p-3">
                                        No Record Found!
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-200" v-for="(product, index) in $page.props.products.data" :key="index">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-700">{{ index + 1 }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ product.name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ product.description }}</div>
                                </td>
                                <td class="flex px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                                    <BreezeButton @click="editProduct(product.id)" buttonType="warning" title="Edit Category" v-if="$page.props.can.edit_products">
                                        Edit
                                    </BreezeButton>
                                    <BreezeButton @click="deleteProduct(product.id)" buttonType="danger" title="Delete Product" v-if="$page.props.can.delete_products">
                                        Delete
                                    </BreezeButton>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <Pagination :page_data="$page.props.products" :params="params"></Pagination>
                </div>
            </div>
            <ConfirmationModal
                :show="show_confirmation"
                @close="show_confirmation = false"
                confirmationAlert="danger"
                confirmationTitle="Delete Product"
                confirmationText="Are you sure want to delete this product? All the variations and sub variations will deleted once you click the DELETE button. Are you sure?"
                confirmationButton="DELETE"
                confirmationMethod="delete"
                confirmationRoute="products.destroy"
                :confirmationData="product_id"
            />
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import Pagination from '@/Components/Pagination.vue';
import { SearchIcon, TrashIcon, PencilIcon } from '@heroicons/vue/solid';
import { debounce } from 'vue-debounce'

export default {
    components: {
        ConfirmationModal
    },
    data(){
        return{
            show_filter: false,
            show_confirmation: false,
            product_id: '',
            params: {
                search: this.$page.props.filter.search ? this.$page.props.filter.search : '',
            },
        }
    },
    methods: {
        editProduct(product_id){
            this.$inertia.get(this.route('products.edit'), {'product_id': product_id}, { replace: true, preserveState: true});
        },
        deleteProduct(product_id){
            this.product_id =   product_id
            this.show_confirmation = true
        },
        search(){
            this.$inertia.get(this.route('products'), this.params, { replace: true, preserveState: true});
        }
    }
}
</script>
